@extends('adminlte::page')

@section('title','Maintenance Report')

@section('content_header')
    <h1 class="m-0 text-dark">Maintenance Report</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Maintenance Report"
        collapse-button="minus" table-id="">
        <x-slot name="tool"></x-slot>
        <th>LocationName</th>
        <th>ProductName</th>
        <th>MachineName</th>
        <th>SystemName</th>
        <th>EquipmentName</th>
        <th>Activity</th>
        <th>Done</th>
        <th>Condition</th>
        <th>Countermeasure</th>
        <th>Remark</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="LocationName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ProductName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="MachineName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="SystemName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="EquipmentName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ActivityName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Done">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Condition">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Countermeasure">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc'],[1,'asc'],[2,'asc'],[3,'asc'],[4,'asc'],[5,'asc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
