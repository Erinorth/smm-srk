@extends('adminlte::page')

@section('title','Tool History')

@section('content_header')
    <h1 class="m-0 text-dark">Tool History</h1>
@stop

@section('content')
    <x-header.tool-header toolId="{{$tool->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.tool-header>

    <x-data-table.default-data-table color="" collapse-card="" title="Tool History"
        collapse-button="minus" table-id="">
        <x-slot name="tool"></x-slot>
        <th>Date</th>
        <th>Project Name/Status, Activity</th>
        <th>Remark</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Date"/>
                <x-data-table.column-script column-name="Status"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'deas']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
