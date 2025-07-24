@extends('adminlte::page')

@section('title','Consumable')

@section('content_header')
    <h1 class="m-0 text-dark">Add Consumable to Store</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Add Consumable to Store"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Add Date</th>
        <th>Consumable Name</th>
        <th>Detail</th>
        <th>In/Out</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Remark</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add Consumable">
        <x-adminlte-select2 name="consumable_id" label="Consumable Name // Detail // Unit" data-placeholder="Select an option...">
            <option/>
            @foreach ($consumable as $value)
                <option value="{{$value->id}}">{{$value->ConsumableName}} // {{$value->Detail}} // {{$value->Unit}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="InOut" label="In/Out" data-placeholder="Select an option...">
            <option/>
            <option>In</option>
            <option>Out</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Quantity" label="Quantity" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน project.pdf').'">การใช้งาน Project</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="created_at"/>
                <x-data-table.column-script column-name="ConsumableName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="InOut">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Quantity">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Unit">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Consumable"/>

            <x-data-table.submit-script name-i-d="" action-url="consumable_addstores">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="consumable_addstores">
                <x-data-table.edit-value-script name="consumable_id"/>
                <x-data-table.edit-value-script name="InOut"/>
                <x-data-table.edit-value-script name="Quantity"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="consumable_addstores"/>
        });
    </script>
@endsection
