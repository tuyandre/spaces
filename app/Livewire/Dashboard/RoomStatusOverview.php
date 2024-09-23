<?php

namespace App\Livewire\Dashboard;

use App\Models\Room;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;

class RoomStatusOverview extends Component
{
    public function render(): Factory|Application|\Illuminate\Contracts\View\View|View
    {
        $rooms = Room::with('maintenances')
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard.room-status-overview', compact('rooms'));
    }
}
