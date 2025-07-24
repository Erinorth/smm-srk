@extends('adminlte::page')

@section('title', 'All Milestone')

@section('content_header')
    <h1 class="m-0 text-dark">All Milestone</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="All Milestone"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Job Name</th>
        <th>Type</th>
        <th>Start Date</th>
        <th>Finish Date/Due Date</th>
        <th>Remark</th>
        <th>Responsible</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add Office Milestone">
        <x-input.text title="JobName" name-id="JobName"/>

        <x-input.dropdown title="Type" name-id="Type">
            <option></option>
            <option>Purchasing</option>
        </x-input.dropdown>

        <x-input.date title="StartDate" name-id="StartDate"/>

        <x-input.date title="DueDate" name-id="DueDate"/>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-input.dropdown title="Responsible" name-id="Responsible">
            <option></option>
            @foreach ($responsible as $value)
                <option value="{{ $value->id }}">{{ $value->ThaiName }}</option>
            @endforeach
        </x-input.dropdown>

        @role('admin|head_engineering|head_operation')
            <x-input.text title="KPI" name-id="KPI"/>
        @endrole

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="JobName"/>
                <x-data-table.column-script column-name="Type"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="DueDate">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Responsible"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[2,'desc'],[3,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Office Milestone"/>

            <x-data-table.submit-script name-i-d="" action-url="milestone_alls">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="milestone_alls">
                <x-data-table.edit-value-script name="JobName"/>
                <x-data-table.edit-value-script name="Type"/>
                <x-data-table.edit-value-script name="StartDate"/>
                <x-data-table.edit-value-script name="DueDate"/>
                <x-data-table.edit-value-script name="Remark"/>
                <x-data-table.edit-value-script name="Responsible"/>
                <x-data-table.edit-value-script name="KPI"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="milestone_alls"/>
        });
    </script>
@endsection
