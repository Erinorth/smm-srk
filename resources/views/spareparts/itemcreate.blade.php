@extends('adminlte::page')

@section('title','Spare Part')

@section('content_header')
    <h1 class="m-0 text-dark">Spare Part</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-data-table.default-data-table color="" collapse-card="" title="Spare Part"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Spare Part Name</th>
        <th>Detail</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Spare Part">
        <x-adminlte-select2 name="spare_part_id" label="Spare Part Name // Detail // Unit" data-placeholder="Select an option...">
            <option/>
            @foreach ($sparepart as $value)
                <option value="{{$value->id}}">{{$value->SparePartName}} / {{$value->Detail}} / {{$value->Unit}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Quantity" label="Quantity" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-slot name="othervalue">
            <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน spare part.pdf').'">การใช้งาน Spare Part</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="SparePartName"/>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Quantity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Spare Part"/>

            <x-data-table.submit-script name-i-d="" action-url="item_spareparts">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/item_spareparts') }}">
                <x-data-table.edit-value-script name="spare_part_id"/>
                <x-data-table.edit-value-script name="Quantity"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="item_spareparts"/>
        });
    </script>
@endsection
