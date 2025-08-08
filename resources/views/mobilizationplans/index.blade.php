@extends('adminlte::page')

@section('title','Mobilization Plan')

@section('content_header')
    <h1 class="m-0 text-dark">Mobilization Plan</h1>
@stop

@section('content')
    <x-card.default-card color="" collapse-card="" title="Calendar" collapse-button="minus">
        <x-slot name="tool"></x-slot>
        <div class="container">
            <div id="calendar"></div>
        </div>
    </x-card.default-card>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Report" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/mobilization_reports') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >From</label> <!-- -->
                        <div class="col">
                            <input type="date" class="form-control" name="startDate" id="startDate">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >To</label> <!-- -->
                        <div class="col">
                            <input type="date" class="form-control" name="endDate" id="endDate">
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Report</button>
                </div>
            </div>
        </form>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Mobilization Plan"
        collapse-button="plus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Remark</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Project">
        <x-input.dropdown title="Employee" name-id="employee_id">
            <option></option>
            @foreach ($employee as $value)
                <option value="{{$value->id}}" >{{$value->ThaiName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.date title="Start Date" name-id="StartDate"/>

        <x-input.date title="End Date" name-id="EndDate"/>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@stop

@section('js')
    <script>
        $(document).ready(function(){

            $('#calendar').fullCalendar({
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today',
                },
                defaultView: 'timelineMonth',
                resourceLabelText: 'Employee',
                resourceGroupField: 'Section',
                resources: 'mobilizationplan_resources',
                events: 'mobilizationplan_calendars',
                eventAfterRender: function(event, element) {
                    $(element).tooltip({
                        title: event.description,
                        container: "body"
                    });
                }
            });

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="EndDate"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Mobilization Plan"/>

            <x-data-table.submit-script name-i-d="" action-url="mobilizationplans">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/mobilizationplans') }}">
                <x-data-table.edit-value-script name="employee_id"/>
                <x-data-table.edit-value-script name="StartDate"/>
                <x-data-table.edit-value-script name="EndDate"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="mobilizationplans"/>
        });
    </script>
@endsection
