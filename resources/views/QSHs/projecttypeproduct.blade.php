@extends('adminlte::page')

@section('title','Project Type-Product')

@section('content_header')
    <h1 class="m-0 text-dark">Stakeholder</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Project Type-Product"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>Project Type Name</th>
        <th>Product Name</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Project Type-Product">
        <x-input.dropdown title="Project Type" name-id="project_type_id">
            <option></option>
            @foreach ($projecttype as $value)
                <option value="{{$value->id}}">{{$value->TypeName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="Product" name-id="product_id">
            <option></option>
            @foreach ($product as $value)
                <option value="{{$value->id}}">{{$value->ProductName}}</option>
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
                <x-data-table.column-script column-name="ProductName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Project Type-Product"/>

            <x-data-table.submit-script name-i-d="" action-url="QSH_project_type_products">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/QSH_project_type_products') }}">
                <x-data-table.edit-value-script name="project_type_id"/>
                <x-data-table.edit-value-script name="product_id"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="QSH_project_type_products"/>
        });
    </script>
@endsection
