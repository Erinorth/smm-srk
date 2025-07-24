@extends('adminlte::page')

@section('title','Daily Report')

@section('content_header')
    <h1 class="m-0 text-dark">Daily Report</h1>
@stop

@section('content')
    <div class="row">
        <div class="col">
            <x-adminlte-card title="Daily Report" theme="primary" removable maximizable>
                <x-slot name="toolsSlot">
                </x-slot>
                <x-data-table.data-table name-i-d="">
                    <th>Project Name</th>
                    <th>Start Date</th>
                    <th>Finish Date</th>
                    <th>Responsible</th>
                    <th>Daily Report</th>
                    <th>Key Date</th>
                    <x-slot name="othertable">
                    </x-slot>
                </x-data-table.data-table>
            </x-adminlte-card>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="ProjectName"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="FinishDate"/>
                <x-data-table.column-script column-name="Responsible"/>
                <x-data-table.column-script column-name="DailyReport">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="KeyDate">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
