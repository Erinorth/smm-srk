@extends('adminlte::page')

@section('title','Hoist List')

@section('content_header')
    <h1 class="m-0 text-dark">Hoist List</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Hoist List"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Customer</th>
        <th>Brand</th>
        <th>Capacity (Tons)</th>
        <th>Model</th>
        <th>Serial Number</th>
        <th>Local Code</th>
        <th>Durable Supplie Code</th>
        <th>Asset Tool Code</th>
        <th>Register Date</th>
        <th>Standard Dimension (P) mm.</th>
        <th>Standard Chain Dimension (D) mm.</th>
        <th>Standard 10 Links Dimension mm.</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Hoist Testing">
        <x-adminlte-input name="Customer" label="Customer" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Brand" label="Brand" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Capacity" label="Capacity (Tons)" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Model" label="Model" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="SerialNumber" label="Serial Number" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="LocalCode" label="Local Code" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="DurableSupplieCode" label="Durable Supplie Code" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="AssetToolCode" label="Asset Tool Code" placeholder="Input a text..."
            disable-feedback/>

        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="RegisterDate" label="Register Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input name="StandardP" label="Standard Dimension (P) mm." placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="StandardD" label="Standard Chain Dimension (D) mm." placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Standard10Link" label="Standard 10 Links Dimension mm." placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน hoist testing.pdf').'">การใช้งาน Hoist Testing</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Customer"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Capacity"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="DurableSupplieCode"/>
                <x-data-table.column-script column-name="AssetToolCode"/>
                <x-data-table.column-script column-name="RegisterDate"/>
                <x-data-table.column-script column-name="StandardP"/>
                <x-data-table.column-script column-name="StandardD"/>
                <x-data-table.column-script column-name="Standard10Link"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Hoist List"/>

            <x-data-table.submit-script name-i-d="" action-url="hoist_list">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="hoist_lists">
                <x-data-table.edit-value-script name="Customer"/>
                <x-data-table.edit-value-script name="Brand"/>
                <x-data-table.edit-value-script name="Capacity"/>
                <x-data-table.edit-value-script name="Model"/>
                <x-data-table.edit-value-script name="SerialNumber"/>
                <x-data-table.edit-value-script name="LocalCode"/>
                <x-data-table.edit-value-script name="DurableSupplieCode"/>
                <x-data-table.edit-value-script name="AssetToolCode"/>
                <x-data-table.edit-value-script name="RegisterDate"/>
                <x-data-table.edit-value-script name="StandardP"/>
                <x-data-table.edit-value-script name="StandardD"/>
                <x-data-table.edit-value-script name="Standard10Link"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="hoist_list"/>
        });
    </script>
@endsection
