@role('admin|head_engineering|head_operation|head_diving')
    <div class="text-center">
        <button class="edit btn btn-xs btn-default text-info mx-1 shadow" name="edit" id="{{$data->id}}" title="Approve"><i class="fa fa-lg fa-fw fa-ruler-vertical"></i></button>
        @if ( $data->ProjectName == "" )
            <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="{{ url('OJTevaluation_office/'.$data->id) }}"><i class="fa fa-lg fa-fw fa-print"></i></a>
        @else
            <a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="{{ url('OJTevaluation/'.$data->id) }}"><i class="fa fa-lg fa-fw fa-print"></i></a>
        @endif
    </div>
@else
    N/A
@endrole