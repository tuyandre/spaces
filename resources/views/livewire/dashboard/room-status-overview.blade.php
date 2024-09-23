<div class="table-responsive">
    <table class="table table-row-dashed table-row-gray-300 gy-4">
        <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>Room Number</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
            <tr>
                <td>{{ $room->room_number }}</td>
                <td>
                    @if($room->isUnderMaintenance())
                        <span class="badge bg-warning">Under Maintenance</span>
                    @else
                        <span class="badge rounded-pill bg-{{ $room->statusColor}}-subtle">{{ $room->status }}</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
