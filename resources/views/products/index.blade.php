@extends('adminlte::page')

@section('title','Product')

@section('content_header')
    <h1 class="m-0 text-dark">Product</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Product"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>ID</th>
        <th>Product Code</th>
        <th>Product Name</th>
        <th>Service</th>
        <th>Department</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Location">
        <x-input.text title="Product Code" name-id="ProductCode"/>

        <x-input.text title="Product Name" name-id="ProductName"/>

        <x-input.text title="Service" name-id="Service"/>

        <x-input.dropdown title="Department" name-id="department_id">
            <option></option>
            @foreach ($department as $value)
                <option value="{{$value->id}}">{{$value->DepartmentName}}</option>
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
                <x-data-table.column-script column-name="ProductCode"/>
                <x-data-table.column-script column-name="ProductName"/>
                <x-data-table.column-script column-name="Service"/>
                <x-data-table.column-script column-name="DepartmentName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Product"/>

            <x-data-table.submit-script name-i-d="" action-url="products">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="products">
                <x-data-table.edit-value-script name="ProductCode"/>
                <x-data-table.edit-value-script name="ProductName"/>
                <x-data-table.edit-value-script name="Service"/>
                <x-data-table.edit-value-script name="department_id"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="products"/>
        });
    </script>
@endsection
