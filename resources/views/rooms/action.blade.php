<div class="d-flex gap-2">
    <a href="{{ route('admin.rooms.show',encodeId($room->id)) }}" class="btn btn-icon btn-light-primary  btn-sm js-edit" data-bs-toggle="tooltip" title="Edit">
        <span class="svg-icon svg-icon-3">
            <i class="bi bi-pencil fs-2"></i>
        </span>
    </a>
    <a href="{{ route('admin.rooms.destroy',encodeId($room->id)) }}" class="btn btn-icon btn-light-danger  btn-sm js-delete" data-bs-toggle="tooltip" title="Delete">
        <span class="svg-icon svg-icon-3">
            <i class="bi bi-trash fs-2"></i>
        </span>
    </a>
</div>
