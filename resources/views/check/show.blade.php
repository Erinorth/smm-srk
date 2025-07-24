@extends('adminlte::page')

@section('title','Check Data All')

@section('content_header')
    <h1 class="m-0 text-dark">Check</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Check"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Location</th>
        <th>Product</th>
        <th>Machine</th>
        <th>System</th>
        <th>Equipment</th>
        <th>Scope</th>
        <th>Consumable</th>
        <th>Hazard</th>
        <th>Safety Tag</th>
        <th>Special Tool</th>
        <th>Tool</th>
        <th>Work Procedure</th>
        <th>Document</th>
        <th>Quality Control</th>
        <th>Spare Part</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="LocationName"/>
                <x-data-table.column-script column-name="ProductName"/>
                <x-data-table.column-script column-name="MachineName"/>
                <x-data-table.column-script column-name="SystemName"/>
                <x-data-table.column-script column-name="EquipmentName"/>
                <x-data-table.column-script column-name="ScopeName"/>
                <x-data-table.column-script column-name="Consumable"/>
                <x-data-table.column-script column-name="Hazard"/>
                <x-data-table.column-script column-name="SafetyTag"/>
                <x-data-table.column-script column-name="SpecialTool"/>
                <x-data-table.column-script column-name="Tool"/>
                <x-data-table.column-script column-name="WorkProcedure"/>
                <x-data-table.column-script column-name="Document"/>
                <x-data-table.column-script column-name="QualityControl"/>
                <x-data-table.column-script column-name="SparePart"/>
                <x-slot name="order">[0,'asc'],[1,'asc'],[2,'asc'],[3,'asc'],[4,'asc'],[5,'asc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
