<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingReportController extends Controller
{
    public function index()
    {
        $lastWeek = Carbon::now()->subWeek();
        $startDate = \request('start_date', $lastWeek->format('Y-m-d'));
        $endDate = \request('end_date', date('Y-m-d'));
        if (request()->ajax()) {
            $roomType = \request('room_type');
            $status = \request('status');
            $data = Booking::query()
                ->with(['room.building', 'room.roomType','room.building'])
                ->when($startDate, fn($query) => $query->where('start_date', '>=', $startDate))
                ->when($endDate, fn($query) => $query->where('end_date', '<=', $endDate))
                ->when($roomType, function ($query) use ($roomType) {
                    $query->whereHas('room', function ($query) use ($roomType) {
                        $query->where('room_type_id', $roomType);
                    });
                })
                ->when($status, fn($query) => $query->where('status', $status));
            return \DataTables::of($data)
                ->make(true);
        }
        $roomTypes = RoomType::query()->get();
        return view('reports.booking', compact('roomTypes','startDate','endDate'));
    }
}
