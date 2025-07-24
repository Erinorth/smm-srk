@extends('adminlte::page')

@section('title','Employee')

@section('content_header')
    <h1 class="m-0 text-dark">Employee</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Employee"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering|head_operation')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>Code</th>
        <th>ID</th>
        <th>Thai Name</th>
        <th>English Name</th>
        <th>Position</th>
        <th>EGAT Email</th>
        <th>Department</th>
        <th>Admin</th>
        <th>Telephone Number</th>
        <th>Action</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Employee">
        <x-adminlte-input name="WorkID" label="Work ID" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="ThaiName" label="Thai Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="EnglishName" label="English Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Position" label="Position" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="EGATEmail" label="EGAT Email" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="department_id" label="Department" data-placeholder="Select an option...">
            <option/>
            @foreach ($department as $value)
                <option value="{{$value->id}}">{{$value->DepartmentName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="Admin" label="Admin" data-placeholder="Select an option...">
            <option/>
            <option>Head</option>
            <option>Admin</option>
            <option>No</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Telephone" label="Telephone Number" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-content.department/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="{{ url('/employees') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="WorkID"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="EnglishName"/>
                <x-data-table.column-script column-name="Position"/>
                <x-data-table.column-script column-name="EGATEmail"/>
                <x-data-table.column-script column-name="DepartmentName"/>
                <x-data-table.column-script column-name="Admin"/>
                <x-data-table.column-script column-name="Telephone"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Employee"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/employees') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name="" edit-url="{{ url('/employees') }}">
                <x-data-table.edit-value-script name="WorkID"/>
                <x-data-table.edit-value-script name="ThaiName"/>
                <x-data-table.edit-value-script name="EnglishName"/>
                <x-data-table.edit-value-script name="Position"/>
                <x-data-table.edit-value-script name="EGATEmail"/>
                <x-data-table.edit-value-script name="department_id"/>
                <x-data-table.edit-value-script name="Admin"/>
                <x-data-table.edit-value-script name="Telephone"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/employees') }}"/>

            <x-j-s.department/>
        });
    </script>
@endsection
