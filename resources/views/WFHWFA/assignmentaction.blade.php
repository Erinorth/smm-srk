<div class="text-center">
    @role('admin|head_operation|head_engineering')
        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$data->id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="{{$data->id}}" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
        <a href="{{ url('WFH_WFA_jobs/'.$data->id) }}" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
    @else
        <a href="{{ url('WFH_WFA_jobs/'.$data->id) }}" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
    @endrole
</div>