@extends('adminlte::page')

@section('title','On The Job Training')

@section('content_header')
    <h1 class="m-0 text-dark">On The Job Training</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="On The Job Training(Office)"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Department</th>
        <th>Trainee</th>
        <th>Job Position</th>
        <th>Course</th>
        <th>Coach</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Job Position"
        collapse-button="plus" table-id="_jobposition">
        <x-slot name="tool">
            <x-button.create-record name-i-d="_jobposition"/>
        </x-slot>
        <th>ID</th>
        <th>Job Name</th>
        <th>Type of Job</th>
        <th>Craft Name</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create On the Job Training">
        <div class="form-group">
            <label class="control-label" >Department</label> <!-- -->
            <div>
                <select class="select2-bootstrap4 dynamicdepartment" name="department_id" id="department_id">
                    <option value="">Department</option>
                    @foreach ($department as $value)
                        <option value="{{$value->id}}">{{$value->DepartmentName}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">Trainee</label>
            <div>
                <select class="select2-bootstrap4 dynamicemployee" name="employee_id" id="employee_id">
                    <option value="">Trainee</option>
                    @foreach ($employee as $value)
                        <option value="{{$value->id}}">{{$value->ThaiName}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">Job Position</label>
            <div>
                <select class="select2-bootstrap4 dynamicjobposition" name="job_position_id" id="job_position_id">
                    <option value="">Job Position</option>
                </select>
            </div>
        </div>

        <x-input.dropdown title="Course" name-id="course_id">
            <option></option>
        </x-input.dropdown>

        <x-input.dropdown title="Coach" name-id="coach_id">
            <option></option>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-slot name="othervalue"></x-slot>
    </x-modal.input-form>

    <div id="formModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Evaluation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result2"></span>
                    <form method="post" id="create_form2" class="form-horizontal">
                        @csrf
                        <x-input.date title="วันที่ประเมิน" name-id="EvaluationDate"/>

                        <x-input.dropdown title="ผลการประเมิน" name-id="Result">
                            <option></option>
                            <option>ผ่าน</option>
                            <option>ไม่ผ่าน</option>
                        </x-input.dropdown>

                        <div class="form-group text-center">
                            <input type="hidden" name="action" id="action" value="Edit" />
                            <input type="hidden" name="hidden_id2" id="hidden_id2" />
                            <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Evaluate" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-modal.input-form name-i-d="" modal-title="Add New Job Position">
        <x-input.text title="Job Position Name" name-id="JobPositionName"/>

        <x-input.text title="Type of Job" name-id="TypeofJob"/>

        <x-input.dropdown title="Craft Name" name-id="craft_id">
            <option></option>
            @foreach ($craft as $value)
                <option value="{{$value->id}}">{{$value->CraftName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-modal.confirm-delete delete-name="_jobposition"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="DepartmentName"/>
                <x-data-table.column-script column-name="ThaiName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="JobPositionName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Course">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="CoachName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_jobposition" ajax-url="{{ url('/jobpositions') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="JobPositionName"/>
                <x-data-table.column-script column-name="TypeofJob">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="CraftName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add On the Job Training"/>

            <x-data-table.create-script name-i-d="_jobposition" title="Add Job Position"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/onthejobtraining_offices') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"{{ url('/onthejobtraining_offices/') }}"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        <x-data-table.edit-value-script name="department_id"/>
                        <x-data-table.edit-value-script name="employee_id"/>
                        <x-data-table.edit-value-script name="coach_id"/>
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit On the Job Training');
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');

                        var departmentid = $('#department_id').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url:"{{ route('dynamicdependent.fetchjobposition') }}",
                            method:"POST",
                            data:{departmentid:departmentid, _token:_token},
                            success:function(result)
                            {
                                $('#job_position_id').html(result);
                                $('#job_position_id').val(data.result.job_position_id);

                                var jobpositionid = $('#job_position_id').val();
                                var employeeid = $('#employee_id').val();
                                var _token2 = $('input[name="_token"]').val();
                                $.ajax({
                                    url:"{{ route('dynamicdependent.fetchcourse') }}",
                                    method:"POST",
                                    data:{departmentid:departmentid, jobpositionid:jobpositionid, employeeid:employeeid, _token:_token},
                                    success:function(result)
                                    {
                                        $('#course_id').html(result);
                                        $('#course_id').val(data.result.course_id);
                                    }
                                })
                            }
                        })
                    }
                })
            });

            $('#create_form2').on('submit', function(event){
                event.preventDefault();

                $.ajax({
                    url: "/onthejobtraining_projects/evaluation",
                    method:"POST",
                    data:$(this).serialize(),
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('.select2-bootstrap4').val(null).trigger('change');
                            $('#create_form2')[0].reset();
                            <x-data-table.ajax-reload-script table-id=""/>
                        }
                        $('#form_result2').html(html);
                    }
                });
            });

            <x-data-table.submit-script name-i-d="_jobposition" action-url="{{ url('/jobpositions') }}">
                <x-data-table.ajax-reload-script table-id="_jobposition"/>
            </x-data-table.submit-script>

            var evaluate_id;

            $(document).on('click', '.evaluate', function(){
                var evaluate_id = $(this).attr('id');
                $('#form_result2').html('');
                $.ajax({
                    url :"{{ url('/onthejobtraining_offices/') }}"+evaluate_id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        <x-data-table.edit-value-script name="EvaluationDate"/>
                        <x-data-table.edit-value-script name="Result"/>
                        $('#hidden_id2').val(evaluate_id);
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formModal2').modal('show');
                    }
                })
            });

            <x-data-table.edit-script edit-name="_jobposition"  edit-url="{{ url('/jobpositions') }}">
                <x-data-table.edit-value-script name="JobPositionName"/>
                <x-data-table.edit-value-script name="TypeofJob"/>
                <x-data-table.edit-value-script name="craft_id"/>
            </x-data-table.edit-script>

            $('.dynamicdepartment').change(function(){
                if($(this).val() != '')
                {
                    var departmentid = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('dynamicdependent.fetchjobposition') }}",
                        method:"POST",
                        data:{departmentid:departmentid, _token:_token},
                        success:function(result)
                        {
                            $('#job_position_id').html(result);
                        }
                    })
                }
            });

            $('.dynamicjobposition').change(function(){
                if($(this).val() != '')
                {
                    var departmentid = $('#department_id').val();
                    var jobpositionid = $(this).val();
                    var employeeid = $('#employee_id').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('dynamicdependent.fetchcourse') }}",
                        method:"POST",
                        data:{departmentid:departmentid, jobpositionid:jobpositionid, employeeid:employeeid, _token:_token},
                        success:function(result)
                        {
                            $('#course_id').html(result);
                        }
                    })
                }
            });

            $('#department_id').change(function(){
                $('#course_id').val('');
                $('#job_position_id').val('');
            });

            $('#job_position_id').change(function(){
                $('#course_id').val('');
            });

            $('#employee_id').change(function(){
                $('#course_id').val('');
                $('#job_position_id').val('');
            });

            <x-data-table.delete-script delete-name="" url="{{ url('/onthejobtraining_offices') }}"/>

            <x-data-table.delete-script delete-name="_jobposition" url="{{ url('/jobpositions') }}"/>
        });
    </script>
@endsection
