@extends('adminlte::page')

@section('title','Course')

@section('content_header')
    <h1 class="m-0 text-dark">Course</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Course"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering|head_operation')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>Course Name</th>
        <th>Type</th>
        <th>For Department</th>
        <th>For Position</th>
        <th>On Site</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Course">
        <x-input.text title="Course Name" name-id="CourseName"/>

        <x-input.dropdown title="Type" name-id="Type">
            <option></option>
            <option>QP</option>
            <option>WI</option>
            <option>Other</option>
        </x-input.dropdown>

        <x-input.dropdown title="For Department" name-id="ForDepartment">
            <option></option>
            @foreach ($department as $value)
                <option value="{{$value->id}}">{{$value->DepartmentName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="For Position" name-id="ForPosition">
            <option></option>
            @foreach ($position as $value)
                <option value="{{$value->id}}">{{$value->JobPositionName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="OnSite" name-id="OnSite">
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
                <x-data-table.column-script column-name="CourseName"/>
                <x-data-table.column-script column-name="Type"/>
                <x-data-table.column-script column-name="DepartmentName"/>
                <x-data-table.column-script column-name="PositionName"/>
                <x-data-table.column-script column-name="OnSite"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Course"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/courses') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/courses') }}">
                <x-data-table.edit-value-script name="CourseName"/>
                <x-data-table.edit-value-script name="Type"/>
                <x-data-table.edit-value-script name="ForDepartment"/>
                <x-data-table.edit-value-script name="ForPosition"/>
                <x-data-table.edit-value-script name="OnSite"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/courses') }}"/>
        });
    </script>
@endsection
