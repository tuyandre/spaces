<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class RoomMaintenances extends Component
{
    use WithPagination;

    public $room;
    public $sortColumn = 'start_date';
    public $sortDirection = 'desc';
    public $search = '';
    public $perPage = 10;

    protected $listeners = ['refreshRoomMaintenances' => '$refresh'];

    public function mount($room): void
    {
        $this->room = $room;
    }



    // Method to update sorting
    public function sortBy($column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortColumn = $column;
        }
    }

    // Method to update the search
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        // Retrieve maintenances with search and sort functionality
        $maintenances = $this->room->maintenances()
            ->with('maintenanceType')
            ->where(function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('maintenanceType', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.room-maintenances', [
            'maintenances' => $maintenances,
        ]);
    }
}
