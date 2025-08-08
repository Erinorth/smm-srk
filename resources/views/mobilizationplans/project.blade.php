@extends('adminlte::page')

@section('title', 'Mobilization Plan')

@section('content_header')
    <h1 class="m-0 text-dark">Mobilization Plan</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-card.default-card color="" collapse-card="collapsed-card" title="ออกคำสั่งเดินทาง" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/mobilization_report') }}">
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
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >PM Order</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="pmorder" id="pmorder">
                                <option></option>
                                @foreach ($pmorder as $value)
                                    <option value="{{ $value->id }}">{{ $value->PMOrder }} // {{ $value->PMOrderName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >หน่วยงาน</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="department" id="department">
                                <option></option>
                                @foreach ($department as $value)
                                    <option value="{{ $value->id }}">{{ $value->DepartmentName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >ผู้ควบคุม</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="controller" id="controller">
                                <option></option>
                                @foreach ($employee as $value)
                                    <option value="{{ $value->id }}">{{ $value->ThaiName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Select All <input type="checkbox" id="checkAll"/></th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report as $value)
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="checkBoxClass" name="id[]" value="{{ $value->id }}"/></td>
                                    <td>{{ $value->ThaiName }}</td>
                                    <td class="text-center">{{ $value->StartDate }}</td>
                                    <td class="text-center">{{ $value->EndDate }}</td>
                                    <td>{{ $value->Remark }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </form>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Mobilization Plan"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Allowance</th>
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
        
        <a href="{{ url('/support_request/'.$project->id.'') }}">*หากไม่พบรายชื่อผู้ปฏิบัติงานภายนอก กฟนม-ธ. ต้องไปเพิ่มในขอสนับสนุนผู้ปฏิบัติงานก่อน</a>

        <x-input.date title="Start Date" name-id="StartDate"/>

        <x-input.date title="End Date" name-id="EndDate"/>

        <x-input.dropdown title="Allowance" name-id="Allowance">
            <option>ไม่ได้เบี้ยเลี้ยง</option>
            <option>เบี้ยเลี้ยงปกติ</option>
            <option>เบี้ยเลี้ยงเหมาจ่าย</option>
            <option>เบี้ยเลี้ยงต่างประเทศ</option>
        </x-input.dropdown>

        <x-input.text title="Remark" name-id="Remark"/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="EndDate"/>
                <x-data-table.column-script column-name="Allowance"/>
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
                <x-data-table.edit-value-script name="Allowance"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="mobilizationplans"/>

            $(function(e){
                $('#checkAll').click(function(){
                    $('.checkBoxClass').prop('checked',$(this).prop('checked'));
                });
            });
        });
    </script>
@endsection
