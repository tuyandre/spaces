<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\ValidateStoreBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Notifications\BookingReviewNotification;
use App\Services\InvoiceService;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Exceptions\Exception;

class BookingController extends Controller
{


    /**
     * Display a listing of the resource.
     * @throws Exception
     * @throws \Exception
     */
    public function index()
    {
        $userId = \request('user_id', auth()->id());
        if (\request()->ajax()) {
            $data = Booking::query()
                ->when(\request('type') != 'all', function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->with('room.roomType', 'room.building', 'user')
                ->select('bookings.*');
            return datatables()->eloquent($data)
                ->addColumn('action', function (Booking $booking) {
                    return view('bookings.action', compact('booking'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('bookings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTypes = RoomType::all();
        $nowHour = now()->hour;
        $times = [];

        for ($i = 0; $i < 24 - $nowHour; $i++) {
            $times[] = ($nowHour + $i) % 24;
        }
        return view('bookings.create', compact('roomTypes', 'times'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(ValidateStoreBookingRequest $request)
    {
        $data = $request->validated();
        unset($data['room_type_id']);
        $data['user_id'] = auth()->id();
        $data['is_guest_booking'] = isset($data['is_guest_booking']) ? 1 : 0;
        $data['status'] = Status::Pending;
        DB::beginTransaction();
        // Combine check-in date and time into one date

        $data['start_date'] = $data['check_in_date'] . ' ' . $data['check_in_time'] . ':00:00';
        $data['end_date'] = $data['check_out_date'] . ' ' . $data['check_out_time'] . ':00:00';

        $booking = Booking::query()->create($data);
        $booking->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => 'Booking created.',
            'is_comment' => false,
            'status' => Status::Pending,
        ]);
        DB::commit();
        if ($request->ajax()) {
            session()->flash('success', 'Booking created successfully.');
            return response()->json([
                'message' => 'Booking created successfully.',
                'redirect' => route('admin.bookings.index', ['type' => 'all'])
            ]);
        }
        return redirect()->route('admin.bookings.index', ['type' => 'all'])
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['room.roomType', 'room.building', 'user', 'flow' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        return view('bookings.show', compact('booking'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        if (\request()->ajax()) {
            return response()->json(['message' => 'Booking deleted successfully.']);
        }
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    /**
     * @throws Throwable
     */
    public function cancelBooking(Booking $booking)
    {
        // Update booking status to 'canceled'
        $booking->status = Status::Cancelled;
        $booking->save();

        if (\request()->ajax()) {
            return response()->json(['message' => 'Booking canceled successfully.']);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking canceled successfully.');
    }

    public function checkout(Booking $booking)
    {
        // Update booking status to 'completed'
        $booking->status = Status::Completed;
        $booking->save();

        if (\request()->ajax()) {
            return response()->json(['message' => 'Booking checked out successfully.']);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking checked out successfully.');
    }

    /**
     * @throws Throwable
     */
    public function review(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => ['required'],
            'description' => ['required'],
        ]);
        DB::beginTransaction();
        $booking->update([
            'status' => $data['status'],
            'reviewed_at' => now(),
            'reviewed_by_id' => auth()->id(),
        ]);

        // save flow
        $booking->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => $data['description'],
            'is_comment' => true,
            'status' => $data['status'],
        ]);

        // if booking is for guest, notify the guest email
        if ($booking->is_guest_booking) {
            // make a temporary user object for email notification
            $user = User::make([
                'name' => $booking->guest_name,
                'email' => $booking->guest_email,
                'phone_number' => $booking->guest_phone,
            ]);
        } else {
            $user = User::find($booking->user_id);
        }
        $user->notify(new BookingReviewNotification($booking));
        if ($status = $data['status'] == Status::Approved) {
            // Generate invoice after booking approval
            $invoiceService = new InvoiceService();
            $invoiceService->createInvoice($booking);
        }

        DB::commit();

        if (\request()->ajax()) {
            session()->flash('success', 'Booking reviewed successfully.');
            return response()->json(['message' => 'Booking reviewed successfully.']);
        }
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking reviewed successfully.');
    }


}
