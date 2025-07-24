@extends('adminlte::page')

@section('title','Hazard')

@section('css')

@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Hazard</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-data-table.default-data-table color="" collapse-card="" title="Hazard"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Order</th>
        <th>Activity</th>
        <th>Hazard</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Hazard">
        <x-adminlte-select2 name="activity_id" label="Activity" data-placeholder="Select an option...">
            <option/>
            @foreach ($activity as $value)
                <option value="{{$value->id}}">{{$value->ActivityName}} / {{$value->Detail}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="hazard_id" label="Hazard" data-placeholder="Select an option...">
            <option/>
            @foreach ($hazard as $value)
                <option value="{{$value->id}}">{{$value->HazardName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-slot name="othervalue">
            <input type="hidden" name="item_id" id="item_id" value="" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน hazard.pdf').'">การใช้งาน Hazard</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Order"/>
                <x-data-table.column-script column-name="ActivityName"/>
                <x-data-table.column-script column-name="HazardName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Hazard"/>

            <x-data-table.submit-script name-i-d="" action-url="item_hazards">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="item_hazards">
                <x-data-table.edit-value-script name="activity_id"/>
                <x-data-table.edit-value-script name="hazard_id"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="item_hazards"/>
        });
    </script>
@endsection
