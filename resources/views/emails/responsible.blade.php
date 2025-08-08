@extends('adminlte::page')

@section('title','Responsible')'

@section('content_header')
    <h1 class="m-0 text-dark">Responsible</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Responsible"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_operation|head_engineering')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>ID</th>
        <th>Project Type</th>
        <th>Responsible</th>
        <th>Job Position</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form modal-title="Add New Department">
        <x-input.dropdown title="Project Type" name-id="project_type_id">
            <option></option>
            @foreach ($type as $value)
                <option value="{{ $value->id }}">{{ $value->TypeName }}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="Responsible" name-id="Responsible">
            <option></option>
            <option>SiteEngineer</option>
            <option>AreaManager</option>
        </x-input.dropdown>

        <x-input.dropdown title="Job Position" name-id="MilestoneResponsible">
            <option></option>
            @foreach ($jobposition as $value)
                <option value="{{ $value->id }}">{{ $value->JobPositionName }}</option>
            @endforeach
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
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="TypeName"/>
                <x-data-table.column-script column-name="Responsible"/>
                <x-data-table.column-script column-name="JobPositionName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Responsible"/>

            <x-data-table.submit-script name-i-d="" action-url="mail_responsible">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/mail_responsible') }}">
                <x-data-table.edit-value-script name="project_type_id"/>
                <x-data-table.edit-value-script name="Responsible"/>
                <x-data-table.edit-value-script name="MilestoneResponsible"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="mail_responsible"/>
        });
    </script>
@endsection
