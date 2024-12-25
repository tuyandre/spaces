<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\ValidateAppointnetRequest;
use App\Jobs\SendAppointmentBookingEmailJob;
use App\Models\AppointmentBooking;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\AppointmentReviewedNotification;
use App\Notifications\BookingReviewNotification;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AppointmentBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $data = AppointmentBooking::query();
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('appointments.show', $row->id) . '" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('bookings.appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookings.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(ValidateAppointnetRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        $model = AppointmentBooking::query()->create($data);
        $model->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => 'Appointment booked.',
            'is_comment' => false,
            'status' => Status::Pending,
        ]);
        SendAppointmentBookingEmailJob::dispatch($model);
        DB::commit();


        if ($request->ajax()) {
            session()->flash('success', 'Appointment Booked Successfully.');
            return response()->json([
                'message' => 'Appointment Booked Successfully.',
                'redirect' => route('appointments.create')
            ]);
        }

        return redirect()
            ->back()->with('success', 'Appointment Booked Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AppointmentBooking $appointmentBooking)
    {
        return view('bookings.appointments.show', compact('appointmentBooking'));
    }


    /**
     * @throws \Throwable
     */
    public function review(Request $request, AppointmentBooking $booking)
    {
        $data = $request->validate([
            'status' => ['required'],
            'description' => ['required'],
            'contact_person_name' => ['required_if:status,approved'],
            'contact_person_email' => ['required_if:status,approved'],
            'contact_person_phone' => ['required_if:status,approved'],
        ]);
        DB::beginTransaction();
        $booking->update([
            'status' => $data['status'],
            'reviewed_at' => now(),
            'reviewed_by_id' => auth()->id(),
            'contact_person_name' => $data['contact_person_name']?? null,
            'contact_person_email' => $data['contact_person_email']?? null,
            'contact_person_phone' => $data['contact_person_phone']?? null,
        ]);

        // save flow
        $booking->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => $data['description'],
            'is_comment' => true,
            'status' => $data['status'],
        ]);

        $user = User::make([
            'name' => $booking->name,
            'email' => $booking->email,
            'phone_number' => $booking->phone,
        ]);
        $user->notify(new AppointmentReviewedNotification($booking));

        DB::commit();

        if (\request()->ajax()) {
            session()->flash('success', 'Booking reviewed successfully.');
            return response()->json(['message' => 'Booking reviewed successfully.']);
        }
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Booking reviewed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppointmentBooking $appointmentBooking)
    {
        $appointmentBooking->delete();
        return redirect()->back()->with('success', 'Appointment Deleted Successfully');
    }
}
