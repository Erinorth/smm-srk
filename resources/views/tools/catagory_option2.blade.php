<div class="text-center">
    @role('admin|store_keeper')
        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{ $data->id }}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{ $data->id }}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
    @else N/A
    @endrole
</div>