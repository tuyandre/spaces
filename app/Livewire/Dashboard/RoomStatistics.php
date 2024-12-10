<?php

namespace App\Livewire\Dashboard;

use App\Constants\Status;
use App\Models\Booking;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;

class RoomStatistics extends Component
{

    public int $totalRooms = 0;
    public int $availableRooms = 0;
    public int $underMaintenance = 0;

    public function render(): Factory|Application|\Illuminate\Contracts\View\View|View
    {
        $this->totalRooms = Room::count();
        $this->availableRooms = Room::whereDoesntHave('maintenances', function ($query) {
            $query->where('start_date', '<=', now())->where('end_date', '>=', now());
        })->count();
        $this->underMaintenance = Room::whereHas('maintenances', function ($query) {
            $query->where('start_date', '<=', now())->where('end_date', '>=', now());
        })->count();

        $totalBookings = Booking::query()->where('status','=',Status::Approved)->count();
        return view('livewire.dashboard.room-statistics',compact('totalBookings'));
    }
}
