@extends('adminlte::page')

@section('title','WFH/WFA Week')

@section('content_header')
    <h1 class="m-0 text-dark">Week</h1>
@stop

@section('content')
    {{-- <x-card.default-card color="" collapse-card="collapsed-card" title="Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/WFHWFA_actual') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >Week</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="weekreport" id="weekreport">
                                <option></option>
                                @foreach ($week as $value)
                                    <option value="{{$value->id}}">{{$value->StartOfWeek}} To {{$value->EndOfWeek}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>
        </form>
    </x-card.default-card> --}}

    <x-data-table.default-data-table color="" collapse-card="" title="Week"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Year</th>
        <th>Week</th>
        <th>Start</th>
        <th>End</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Year"/>
                <x-data-table.column-script column-name="Week"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="EndDate"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[2,'desc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
