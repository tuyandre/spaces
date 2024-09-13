<div class="d-flex flex-shrink-0 gap-2">
    <a class="btn btn-icon btn-light-primary btn-sm rounded-2 js-edit" href="{{ route('admin.buildings.types.show',encodeId( $buildingType->id)) }}">
        <i class="bi bi-pencil-square"></i>
    </a>
    <a class="btn btn-icon btn-light-danger btn-sm rounded-2 js-delete" href="{{ route('admin.buildings.types.destroy', encodeId($buildingType->id)) }}">
        <i class="bi bi-trash"></i>
    </a>
</div>
