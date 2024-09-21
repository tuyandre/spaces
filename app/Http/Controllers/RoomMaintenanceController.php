<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\MaintenanceType;
use App\Models\Room;
use App\Models\RoomMaintenance;
use Illuminate\Http\Request;

class RoomMaintenanceController extends Controller
{
    // Create a maintenance record for a room
    public function store(Request $request, Room $room)
    {
        $data = $request->validate([
            'maintenance_type_id' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required',
        ]);
        $room->maintenances()->create($data);
        return response()->json(['success' => 'Room maintenance scheduled successfully']);
    }

    // Mark a maintenance as completed
    public function complete(RoomMaintenance $maintenance)
    {
        $maintenance->status = Status::Completed;
        $maintenance->save();
        return response()->json(['success' => 'Room maintenance marked as completed']);
    }

    // Get all maintenances for a room
    public function index(Room $room)
    {
        $sortColumn = request('sort_col', 'created_at');
        $sortDirection = request('sort_dir', 'desc');
        $q = \request('q');

        $maintenances = $room->maintenances()
            ->with('maintenanceType')
            ->when($q, function ($query) use ($q) {
                $query->where('maintenance_type', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%")
                    ->orWhere('status', 'like', "%$q%")
                    ->orWhere('start_date', 'like', "%$q%")
                    ->orWhere('end_date', 'like', "%$q%");
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);
        $maintenanceTypes = MaintenanceType::query()->get();
        return view('rooms.maintenances', compact('room', 'maintenances', 'maintenanceTypes'));
    }
}
