@extends('adminlte::page')

@section('title','Milestone Standard')

@section('content_header')
    <h1 class="m-0 text-dark">Milestone Activity</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Milestone Activity"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering|head_operation')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>Activity</th>
        <th>Before Start</th>
        <th>After Start</th>
        <th>Before Finish</th>
        <th>After Finish</th>
        <th>Document</th>
        <th>Link</th>
        <th>Folder</th>
        <th>Responsible</th>
        <th>Dynamic</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add Standard Milestone">
        <x-input.text title="Activity" name-id="Activity"/>

        <x-input.text title="Before Start" name-id="BeforeStart"/>

        <x-input.text title="After Start" name-id="AfterStart"/>

        <x-input.text title="Before Finish" name-id="BeforeFinish"/>

        <x-input.text title="After Finish" name-id="AfterFinish"/>

        <x-input.text title="Document" name-id="Document"/>

        <x-input.text title="Link" name-id="Link"/>

        <x-input.text title="Folder" name-id="Folder"/>

        <x-input.dropdown title="Responsible" name-id="Responsible">
            <option></option>
            @foreach ($responsible as $value)
                <option value="{{ $value->id }}">{{ $value->JobPositionName }}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="Dynamic" name-id="Dynamic">
            <option></option>
            <option>Yes</option>
            <option>No</option>
        </x-input.dropdown>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Activity"/>
                <x-data-table.column-script column-name="BeforeStart"/>
                <x-data-table.column-script column-name="AfterStart"/>
                <x-data-table.column-script column-name="BeforeFinish"/>
                <x-data-table.column-script column-name="AfterFinish"/>
                <x-data-table.column-script column-name="Document">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Link">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Folder">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="JobPositionName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Dynamic">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'desc'],[2,'asc'],[3,'desc'],[4,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Standard Activity"/>

            <x-data-table.submit-script name-i-d="" action-url="milestone_activities">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="milestone_activities">
                <x-data-table.edit-value-script name="Activity"/>
                <x-data-table.edit-value-script name="BeforeStart"/>
                <x-data-table.edit-value-script name="AfterStart"/>
                <x-data-table.edit-value-script name="BeforeFinish"/>
                <x-data-table.edit-value-script name="AfterFinish"/>
                <x-data-table.edit-value-script name="Document"/>
                <x-data-table.edit-value-script name="JobName"/>
                <x-data-table.edit-value-script name="Responsible"/>
                <x-data-table.edit-value-script name="Dynamic"/>
                <x-data-table.edit-value-script name="Folder"/>
                <x-data-table.edit-value-script name="Link"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="milestone_activities"/>
        });
    </script>
@endsection
