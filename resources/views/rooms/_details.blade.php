<div>
    <div class="border border-secondary border-dashed d-flex gap-5 p-3 rounded">
       <div class="div">
           <div class="fs-6 fw-bold mb-1">Capacity</div>
           <div class="fw-semibold text-gray-600">
               {{ $room->capacity }}
           </div>
       </div>
        <div>
            <div class="fs-6 fw-bold mb-1">Building</div>
            <div class="fw-semibold text-gray-600">
                {{ $room->building->name }}
            </div>
        </div>
        <div>
            <div class="fs-6 fw-bold mb-1">Floor</div>
            <div class="fw-semibold text-gray-600">
                {{ $room->floor }}
            </div>
        </div>
        <div>
            <div class="fs-6 fw-bold mb-1">Status</div>
            <div class="fw-semibold text-{{ $room->status_color }}">
                {{ $room->status }}
            </div>
        </div>
    </div>
</div>
