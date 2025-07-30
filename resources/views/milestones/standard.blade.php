@extends('adminlte::page')

@section('title','Milestone Standard')

@section('content_header')
    <h1 class="m-0 text-dark">Milestone Standard</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Milestone Standard"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering|head_operation')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>Project Type</th>
        <th>Milestone Activity</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add Standard Milestone">
        <x-input.dropdown title="Project Type" name-id="project_type_id">
            <option></option>
            @foreach ($type as $value)
                <option value="{{ $value->id }}">{{ $value->TypeName }}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="Milestone Activity" name-id="mile_stone_activity_id">
            <option></option>
            @foreach ($activity as $value)
                <option value="{{ $value->id }}">{{ $value->Activity }}</option>
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
                <x-data-table.column-script column-name="TypeName"/>
                <x-data-table.column-script column-name="Activity"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Standard Activity"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/milestone_standards') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/milestone_standards') }}">
                <x-data-table.edit-value-script name="project_type_id"/>
                <x-data-table.edit-value-script name="mile_stone_activity_id"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/milestone_standards') }}"/>
        });
    </script>
@endsection
