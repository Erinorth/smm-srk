@extends('adminlte::page')

@section('title','Project Type')

@section('content_header')
    <h1 class="m-0 text-dark">Project Type</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Project Type"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering|head_operation')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>ID</th>
        <th>Type Name</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add Standard Milestone">
        <x-input.text title="Type Name" name-id="TypeName"/>

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
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Type Name"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/project_types') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/project_types') }}">
                <x-data-table.edit-value-script name="TypeName"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/project_types') }}"/>
        });
    </script>
@endsection
