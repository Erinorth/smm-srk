@extends('adminlte::page')

@section('title','KPI')

@section('content_header')
    <h1 class="m-0 text-dark">KPI</h1>
@stop

@section('content')
    <x-header.employee-header employeeId="{{$employee->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.employee-header>

    <x-data-table.default-data-table color="" collapse-card="" title="KPI"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Project/Routine</th>
        <th>Duration/Weight</th>
        <th>KPI</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="EndDate">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ProjectName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Duration">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="KPI">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
