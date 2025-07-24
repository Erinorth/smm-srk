<div class="text-center">
    @if ( $data->Status = "Returned")
        In Set/In Store
    @else In Set/{{$data->Status}}
    @endif
</div>