@extends('adminlte::page')

@section('title','Consumable')

@section('content_header')
    <h1 class="m-0 text-dark">Consumable</h1>
@stop

@section('content')
    <x-header.consumable-header consumableId="{{$consumable->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.consumable-header>

    <x-data-table.default-data-table color="" collapse-card="" title="Consumable"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Date</th>
        <th>Project</th>
        <th>Confirmed</th>
        <th>Pick</th>
        <th>Return</th>
        <th>In</th>
        <th>Out</th>
        <th>Remark</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="created_at"/>
                <x-data-table.column-script column-name="ProjectName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Confirmed">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Pick">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Return">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="In">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Out">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
