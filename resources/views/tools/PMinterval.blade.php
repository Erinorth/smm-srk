@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">PM Interval</h1>
@stop

@section('content')
    <x-header.tool toolId="{{$tool->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.tool>

    <x-data-table.default-data-table color="" collapse-card="" title="PM"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Activity</th>
        <th>Interval</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Tool PM">
        <x-input.text-area title="Activity" name-id="Activity"/>

        <x-input.text title="Interval" name-id="Interval"/>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-slot name="othervalue">
            <input type="hidden" name="tool_id" id="tool_id" value="{{$tool->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Activity"/>
                <x-data-table.column-script column-name="Interval">
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

            <x-data-table.create-script name-i-d="" title="Add New Tool PM"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/tool_PM_intervals') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/tool_PM_intervals') }}">
                <x-data-table.edit-value-script name="Activity"/>
                <x-data-table.edit-value-script name="Interval"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/tool_PM_intervals') }}"/>
        });
    </script>
@endsection
