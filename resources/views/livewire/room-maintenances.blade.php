<div>
    <!-- Search Input -->
    <div class="d-flex justify-content-between mb-3">
        <div>
            <input type="text" class="form-control" placeholder="Search maintenances..." wire:model="search">
        </div>
        <div >
            <button type="button" class="btn btn-sm btn-primary px-4 py-3" id="addNew">
                <i class="bi bi-plus fs-3"></i>
                New Maintenance
            </button>
        </div>
    </div>

    <!-- Table -->
    <table class="table ps-2 align-middle border rounded table-row-dashed fs-6 g-5">
        <thead>
        <tr class="text-gray-800 fw-bold fs-7 text-uppercase">

            <th>
                <a href="#" wire:click.prevent="sortBy('start_date')" class="text-decoration-none text-dark">
                    Start Date
                    @if($sortColumn == 'start_date')
                        <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                    @else
                        <i class="bi bi-arrow-down-up"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="#" wire:click.prevent="sortBy('end_date')" class="text-decoration-none text-dark">
                    End Date
                    @if($sortColumn == 'end_date')
                        <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                    @else
                        <i class="bi bi-arrow-down-up"></i>
                    @endif
                </a>
            </th>
            <th>

                <a href="#" wire:click.prevent="sortBy('maintenance_type_id')" class="text-decoration-none text-dark">
                    Type
                    @if($sortColumn == 'maintenance_type_id')
                        <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                    @else
                        <i class="bi bi-arrow-down-up"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="#" wire:click.prevent="sortBy('status')" class="text-decoration-none text-dark">
                    Status
                    @if($sortColumn == 'status')
                        <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                    @else
                        <i class="bi bi-arrow-down-up"></i>
                    @endif
                </a>
            </th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        @foreach($maintenances as $maintenance)
            <tr>
                <td>{{ $maintenance->start_date }}</td>
                <td>{{ $maintenance->end_date }}</td>
                <td>{{ $maintenance->maintenanceType->name ?? 'N/A' }}</td>
                <td>{{ $maintenance->status }}</td>
                <td>

                    <form action="{{ route('admin.rooms.maintenances.destroy', [$room->id, $maintenance->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this maintenance?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light btn-active-light-danger">
                            <i class="bi bi-trash fs-5"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $maintenances->links() }}
    </div>
</div>
