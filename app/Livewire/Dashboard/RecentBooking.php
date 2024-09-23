<?php

namespace App\Livewire\Dashboard;

use App\Models\Booking;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;

class RecentBooking extends Component
{
    public $recentBookings;

    public function mount(): void
    {
        $this->recentBookings = Booking::with('room')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function render(): Factory|Application|\Illuminate\Contracts\View\View|View
    {
        return view('livewire.dashboard.recent-booking');
    }
}
