@extends('adminlte::page')

@section('title','Support Men')

@section('content_header')
    <h1 class="m-0 text-dark">Support Men</h1>
@stop

@section('content')
    <x-header.support-request requestId="{{$support_request->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.support-request>

    <x-data-table.default-data-table color="" collapse-card="" title="Support Men"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ชื่อ - สกุล</th>
        <th>ล่วงเวลาสะสม</th>
        <th>วันที่จะมีล่วงเวลาวันแรก</th>
        <th>Remark</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Employee"
        collapse-button="plus" table-id="_employee">
        <x-slot name="tool">
        </x-slot>
        <th>ID</th>
        <th>Thai Name</th>
        <th>Department</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Consumable">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-select2 name="employee_id" label="ชื่อ - สกุล" data-placeholder="Select an option...">
            <option/>
            @foreach ($employee as $value)
                <option value="{{ $value->id }}">{{ $value->ThaiName }}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="OT" label="ล่วงเวลาสะสม" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input-date name="StartDate" label="วันที่จะมีล่วงเวลาวันแรก" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="support_request_id" id="support_request_id" value="{{$support_request->id}}" />
            <input type="hidden" name="project_id" id="project_id" value="{{$support_request->project_id}}" />
            <input type="hidden" name="department_id2" id="department_id2" value="{{$support_request->department_id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-modal.input-form name-i-d="_employee" modal-title="Add New Employee">
        <x-adminlte-select2 name="department_id" label="Department" data-placeholder="Select an option...">
            <option/>
            @foreach ($department as $value)
                <option value="{{$value->id}}">{{$value->DepartmentName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>
@endsection

@section('js')


    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="OT"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Support Men"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/support_man') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/support_man') }}">
                <x-data-table.edit-value-script name="employee_id"/>
                <x-data-table.edit-value-script name="OT"/>
                <x-data-table.edit-value-script name="StartDate"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/support_man') }}"/>

            <x-data-table.data-table-script table-name="_employee" ajax-url="{{ url('/support_man_employee') }}">
                <x-data-table.column-script column-name="WorkID"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="DepartmentName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.edit-script edit-name="_employee"  edit-url="{{ url('/employees') }}">
                <x-data-table.edit-value-script name="department_id"/>
            </x-data-table.edit-script>

            <x-data-table.submit-script name-i-d="_employee" action-url="{{ url('/support_man_employee') }}">
                <x-data-table.ajax-reload-script table-id="_employee"/>
            </x-data-table.submit-script>
        });
    </script>
@endsection
