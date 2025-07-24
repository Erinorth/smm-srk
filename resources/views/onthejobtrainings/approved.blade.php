@extends('adminlte::page')

@section('title','On the Job Training Approved')

@section('content_header')
    <h1 class="m-0 text-dark">Approved</h1>
@stop

@section('content')
    <div class="container-fluid ">
        <div class="row">
            <div class="col">
                <x-adminlte-card title="รับรองการฝึกอบรมในงาน" theme="primary" collapsible removable maximizable>
                    <x-slot name="toolsSlot">
                    </x-slot>
                    <x-data-table.data-table name-i-d="">
                        <th>ID</th>
                        <th>หลักสูตร/หัวข้อ</th>
                        <th>ชื่องาน</th>
                        <th>สถานที่</th>
                        <th>ผู้รับการฝึกสอน</th>
                        <th>วิทยากร/ผู้รับผิดชอบหลักสูตร</th>
                        <th>ผลการ OJT</th>
                        <th>Approved</th>
                        <th>Action</th>
                        <x-slot name="othertable">
                        </x-slot>
                    </x-data-table.data-table>
                </x-adminlte-card>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-adminlte-card title="Class Room Training" theme="green" collapsible="collapsed" removable maximizable>
                    <x-slot name="toolsSlot">
                        <x-adminlte-button class="btn-sm" theme="success" icon="fa fa-lg fa-fw fa-plus-square" name-i-d="create_record_training"/>
                    </x-slot>
                    <x-data-table.data-table name-i-d="_training">
                        <th>id</th>
                        <th>ผู้เข้ารับการอบรม</th>
                        <th>หลักสูตร</th>
                        <th>ผู้บันทึกข้อมูล</th>
                        <th>ผู้รับรอง</th>
                        <th>วันที่รับรอง</th>
                        <th>Action</th>
                        <x-slot name="othertable">
                        </x-slot>
                    </x-data-table.data-table>
                </x-adminlte-card>
            </div>
        </div>
    </div>

    <x-modal.input-form name-i-d="" modal-title="Approve">
        <x-input.date title="Approved Date" name-id="ApprovedDate"/>

        <x-slot name="othervalue"></x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_training" modal-title="Training Record">
        <x-adminlte-select2 name="employee_id" label="ผู้เข้ารับการอบรม" data-placeholder="Select an option...">
            <option/>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Course" label="หลักสูตร" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue"></x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name="_training"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="CourseName"/>
                <x-data-table.column-script column-name="ProjectName"/>
                <x-data-table.column-script column-name="LocationThaiName"/>
                <x-data-table.column-script column-name="Trainee"/>
                <x-data-table.column-script column-name="Coach"/>
                <x-data-table.column-script column-name="result"/>
                <x-data-table.column-script column-name="approve"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Project"/>

            <x-data-table.submit-script name-i-d="" action-url="onthejobtraining_approves">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="onthejobtraining_approves">
                <x-data-table.edit-value-script name="Approver"/>
                <x-data-table.edit-value-script name="ApprovedDate"/>
            </x-data-table.edit-script>

            <x-data-table.data-table-script table-name="_training" ajax-url="/trainings">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="Course"/>
                <x-data-table.column-script column-name="Recorder"/>
                <x-data-table.column-script column-name="Approver"/>
                <x-data-table.column-script column-name="ApprovedDate"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="_training" title="Training Record"/>

            <x-data-table.submit-script name-i-d="_training" action-url="trainings">
                <x-data-table.ajax-reload-script table-id="_training"/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name="_training"  edit-url="trainings">
                <x-data-table.edit-value-script name="employee_id"/>
                <x-data-table.edit-value-script name="Course"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="_training" url="trainings"/>
        });
    </script>
@endsection
