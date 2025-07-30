@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Tool</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-data-table.default-data-table color="" collapse-card="" title="Tool"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Tool Name</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Consumable">
        <x-adminlte-select2 name="tool_catagory_id" label="Tool Name // Range/Capacity // Unit" data-placeholder="Select an option...">
            <option/>
            @foreach ($toolcatagory as $value)
                <option value="{{$value->id}}">{{$value->CatagoryName}} @isset($value->RangeCapacity) &nbsp;//&nbsp;{{$value->RangeCapacity}} @endisset &nbsp;//&nbsp;{{$value->Unit}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Quantity" label="Quantity" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใส่รายการ tool ใน item.pdf').'">การใส่รายการ Tool ใน Item</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="Quantity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Tool"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/item_tool_catagories') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/item_tool_catagories') }}">
                <x-data-table.edit-value-script name="tool_catagory_id"/>
                <x-data-table.edit-value-script name="Quantity"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/item_tool_catagories') }}"/>
        });
    </script>
@endsection
