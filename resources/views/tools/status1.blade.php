<div class="text-center">
    @if ( $data->Status = "Returned")
        In Store
    @else {{$data->Status}}
    @endif
</div>