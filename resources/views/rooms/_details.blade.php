<div>
    <div class="mb-3">
        <div class="fs-6 fw-bold mb-1">Name</div>
        <div class="fw-semibold text-gray-600">
            {{ $room->name }}
        </div>
    </div>
    <div class="mb-3">
        <div class="fs-6 fw-bold mb-1">Type</div>
        <div class="fw-semibold text-gray-600">
            {{ $room->roomType->name }}
        </div>
    </div>
    <div class="mb-3">
        <div class="fs-6 fw-bold mb-1">Building</div>
        <div class="fw-semibold text-gray-600">
            {{ $room->building->name }}
        </div>
    </div>

    <div class="mb-3">
        <div class="fs-6 fw-bold mb-1">Floor</div>
        <div class="fw-semibold text-gray-600">
            {{ $room->floor }}
        </div>
    </div>
    <div class="mb-3">
        <div class="fs-6 fw-bold mb-1">Status</div>
        <div class="fw-semibold text-{{ $room->status_color }}">
            {{ $room->status }}
        </div>
    </div>

</div>
