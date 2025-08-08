@extends('adminlte::page')

@section('title','Product-Stakeholder')

@section('content_header')
    <h1 class="m-0 text-dark">Product-Stakeholder</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Product-Stakeholder"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>Product Name</th>
        <th>ผู้มีส่วนได้เสีย</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Product-Stakeholder">
        <x-input.dropdown title="Product Name" name-id="product_id">
            <option></option>
            @foreach ($product as $value)
                <option value="{{$value->id}}">{{$value->ProductName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.dropdown title="ผู้มีส่วนได้เสีย" name-id="stakeholder_id">
            <option></option>
            @foreach ($stakeholder as $value)
                <option value="{{$value->id}}">{{$value->StakeholderName}}</option>
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
                <x-data-table.column-script column-name="ProductName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="StakeholderName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add New Stakeholder"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/QSH_product_stakeholders') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/QSH_product_stakeholders') }}">
                <x-data-table.edit-value-script name="product_id"/>
                <x-data-table.edit-value-script name="stakeholder_id"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/QSH_product_stakeholders') }}"/>
        });
    </script>
@endsection
