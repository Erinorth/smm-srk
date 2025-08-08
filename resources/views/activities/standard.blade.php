@extends('adminlte::page')

@section('title','Activity')

@section('content_header')
    <h1 class="m-0 text-dark">Standard Activity</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Standard Activity"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            @role('admin|head_engineering')
                <x-button.create-record name-i-d=""/>
            @endrole
        </x-slot>
        <th>Scope</th>
        <th>Order</th>
        <th>Activity</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Consumable">
        <x-input.dropdown title="Sope Name" name-id="scope_id">
            <option></option>
            @foreach ($scope as $value)
                <option value="{{$value->id}}">{{$value->ScopeName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.text title="Order" name-id="Order"/>

        <x-input.text title="Activity" name-id="ActivityName"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="ScopeName"/>
                <x-data-table.column-script column-name="Order"/>
                <x-data-table.column-script column-name="ActivityName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc'],[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Standard Activity"/>

            <x-data-table.submit-script name-i-d="" action-url="activity_standards">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/activity_standards') }}">
                <x-data-table.edit-value-script name="scope_id"/>
                <x-data-table.edit-value-script name="Order"/>
                <x-data-table.edit-value-script name="ActivityName"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="activity_standards"/>
        });
    </script>
@endsection
