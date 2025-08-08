@extends('adminlte::page')

@section('title','Spare Part')

@section('content_header')
    <h1 class="m-0 text-dark">Spare Part</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Spare Part"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Spare Part Name</th>
        <th>Detail</th>
        <th>Unit</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Spare Part">
        <x-adminlte-input name="SparePartName" label="Spare Part Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Detail" label="Detail" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Unit" label="Unit" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
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
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Spare Part"/>

            <x-data-table.submit-script name-i-d="" action-url="spareparts">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/spareparts') }}">
                <x-data-table.edit-value-script name="SparePartName"/>
                <x-data-table.edit-value-script name="Detail"/>
                <x-data-table.edit-value-script name="Unit"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="spareparts"/>
        });
    </script>
@endsection
