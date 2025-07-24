<div class="text-center">
    @role('admin|head_operation|head_engineering')
        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{ $data->id }}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{ $data->id }}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
        <button class="evaluate btn btn-xs btn-default text-info mx-1 shadow" name="edit" id="{{ $data->id }}" title="Evaluate"><i class="fa fa-lg fa-fw fa-ruler-vertical"></i></button>
    @else
        N/A
    @endrole
</div>