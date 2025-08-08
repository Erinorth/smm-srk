@extends('adminlte::page')

@section('title','Safety Tag')

@section('css')

@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Safety Tag</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-data-table.default-data-table color="" collapse-card="" title="Safety Tag"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Tag Location</th>
        <th>Purpose</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Consumable">
        <x-adminlte-input name="TagLocation" label="Tag Location" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Purpose" label="Purpose" placeholder="Input a text..."
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
            ['<a href="'. url('storage/user_manual/การใช้งาน safety tag.pdf').'">การใช้งาน Safety Tag</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="TagLocation"/>
                <x-data-table.column-script column-name="Purpose">
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

            <x-data-table.create-script name-i-d="" title="Safety Tag"/>

            <x-data-table.submit-script name-i-d="" action-url="safetytags">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/safetytags') }}">
                <x-data-table.edit-value-script name="TagLocation"/>
                <x-data-table.edit-value-script name="Purpose"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="safetytags"/>
        });
    </script>
@endsection
