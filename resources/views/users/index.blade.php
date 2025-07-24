@extends('adminlte::page')

@section('title','User')

@section('content_header')
    <h1 class="m-0 text-dark">User</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="User"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>User Name</th>
        <th>Email</th>
        <th>Work ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Action</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Employee">
        <x-input.text title="User Name" name-id="name"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @role('admin')
        <x-content.link-employee/>
        <x-content.add-role/>
    @endrole
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="{{ url('/users') }}">
                <x-data-table.column-script column-name="UserName"/>
                <x-data-table.column-script column-name="email"/>
                <x-data-table.column-script column-name="WorkID"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="Role"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Employee"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/users') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name="" edit-url="{{ url('/users') }}">
                <x-data-table.edit-value-script name="name"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/users') }}"/>

            <x-j-s.link-employee/>

            <x-j-s.add-role/>
        });
    </script>
@endsection
