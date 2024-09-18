<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\ValidateStoreBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
                ->with('room.roomType', 'room.building')
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
        $rooms = Room::with(['roomType', 'building'])->get();
        return view('bookings.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidateStoreBookingRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Booking::query()->create($data);
        if ($request->ajax()) {
            session()->flash('success', 'Booking created successfully.');
            return response()->json([
                'message' => 'Booking created successfully.',
                'redirect' => route('admin.bookings.index')
            ]);
        }
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load('room.roomType', 'room.building');
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $booking->load('room.roomType', 'room.building');
        $rooms = Room::with(['roomType', 'building'])->get();
        return view('bookings.edit', compact('booking', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidateStoreBookingRequest $request, Booking $booking)
    {
        $data = $request->validated();
        $booking->update($data);
        if ($request->ajax()) {
            return response()->json(['message' => 'Booking updated successfully.']);
        }
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully.');
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
     * @throws \Throwable
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

}
