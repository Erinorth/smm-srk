<div class="text-center">
    <a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Mile Stone" href="{{ url('projects_milestone/'.$data->id)}}"><i class="fa fa-lg fa-fw fa-tasks"></i></a>
    <a href="{{ url('projects/'.$data->id)}}" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
    @role("planner|admin|head_operation")
        <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$data->id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
    @endrole
</div>
