@extends('adminlte::page')

@section('title','Expensive Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Expensive Tool</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <x-adminlte-card title="เครื่องมือราคาเกิน 1 แสน" theme="primary" removable maximizable>
                    <x-slot name="toolsSlot">
                    </x-slot>
                    <x-data-table.data-table name-i-d="_expensivetool">
                        <th>Catagory Name</th>
                        <th>Range Capacity</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Serial Number</th>
                        <th>Local Code</th>
                        <th>Durable Supply Code</th>
                        <th>Asset Tool Code</th>
                        <th>TimeOfUse</th>
                        <th>UF(Hour/Year)</th>
                        <x-slot name="othertable">
                        </x-slot>
                    </x-data-table.data-table>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="_expensivetool" ajax-url="/dashboard_tooltimeconfirm">
                <x-data-table.column-script column-name="CatagoryName"/>
                <x-data-table.column-script column-name="RangeCapacity"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="DurableSupplieCode"/>
                <x-data-table.column-script column-name="AssetToolCode"/>
                <x-data-table.column-script column-name="Hour"/>
                <x-data-table.column-script column-name="UF"/>
                <x-slot name="order">[9,'asc'],[8,'asc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
