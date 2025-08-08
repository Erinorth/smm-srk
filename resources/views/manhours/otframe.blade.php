@extends('adminlte::page')

@section('title','Overtime Frame')

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="Overtime Frame"
        collapse-button="plus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>Name</th>
        <th>Year</th>
        <th>Month</th>
        <th>Frame</th>
        <th>Remark</th>
        <th>Action</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Update Overtime Frame">
        <x-adminlte-select2 name="employee_id" label="Name" data-placeholder="Select an option...">
            <option></option>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="Year" label="Year" data-placeholder="Select an option...">
            <option></option>
            @foreach ($yearnumber as $value)
                <option>{{$value->Year}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="Month" label="Month" data-placeholder="Select an option...">
            <option></option>
            @foreach ($monthnumber as $value)
                <option>{{$value->Month}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="Frame" label="Frame" data-placeholder="Select an option...">
            <option></option>
            <option>0</option>
            <option>30</option>
            <option>45</option>
            <option>60</option>
            <option>90</option>
            <option>120</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="WorkID"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="Year"/>
                <x-data-table.column-script column-name="Month"/>
                <x-data-table.column-script column-name="Frame"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[2,'desc'],[3,'desc'],[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Overtime Frame"/>

            <x-data-table.submit-script name-i-d="" action-url="otframe">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/otframe') }}">
                <x-data-table.edit-value-script name="employee_id"/>
                <x-data-table.edit-value-script name="Year"/>
                <x-data-table.edit-value-script name="Month"/>
                <x-data-table.edit-value-script name="Frame"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="otframe"/>
        });
    </script>
@endsection
