@extends('adminlte::page')

@section('title', 'Consumable')

@section('content_header')
    <h1 class="m-0 text-dark">Return Consumable</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Consumable"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Pick Date</th>
        <th>PM Order</th>
        <th>Consumable Name</th>
        <th>Detail</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Remark</th>
        <th>Return</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Return Consumable">
        <x-input.text title="Return" name-id="Return"/>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การเบิก คืน consumable.pdf').'">การเบิก คืน Consumable</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="created_at"/>
                <x-data-table.column-script column-name="PMOrder">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="ConsumableName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Pick">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Return">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.submit-script name-i-d="" action-url="consumable_returns">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="consumable_returns">
                <x-data-table.edit-value-script name="Return"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>
        });
    </script>
@endsection
