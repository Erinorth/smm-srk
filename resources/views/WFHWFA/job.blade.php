@extends('adminlte::page')

@section('title','WFH/WFA Routine')

@section('content_header')
    <h1 class="m-0 text-dark">Routine Job</h1>
@stop

@section('content')
    <x-header.assignment assignmentId="{{$assignment->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.assignment>

    <x-data-table.default-data-table color="" collapse-card="" title="Routine Job"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            {{-- @foreach ($enddate as $value)
                @php
                    $n = date('Y-m-d', strtotime( $value->EndDate . "+1 days"));
                @endphp
            @endforeach
            @if ( $n > NOW() ) --}}
                <x-button.create-record name-i-d=""/>
            {{-- @else
                @role('admin|head_operation|head_engineering')
                    <x-button.create-record name-i-d=""/>
                @endrole
            @endif --}}
        </x-slot>
        <th>ID</th>
        <th>งาน</th>
        <th>ตัวชี้วัดความสำเร็จ</th>
        <th>คะแนนต่อหน่วย</th>
        <th>รายละเอียด</th>
        <th>คะแนนเต็ม</th>
        <th>คะแนนที่ได้</th>
        <th>ผู้มอบหมายงาน</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Routine Standard"
        collapse-button="plus" table-id="_routine">
        <x-slot name="tool">
            <x-button.create-record name-i-d="_routine"/>
        </x-slot>
        <th>ID</th>
        <th>ชื่องาน</th>
        <th>ตัวชี้วัดความสำเร็จ</th>
        <th>คะแนน</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Work at Hight Measurement">
        <x-input.dropdown title="งาน" name-id="routine_job_id">
            <option></option>
            @foreach ($job as $value)
                <option value="{{$value->id}}">{{$value->RoutineJobName}} // {{$value->Point}}</option>
            @endforeach
        </x-input.dropdown>

        <x-input.text-area title="รายละเอียด" name-id="Detail"/>

        <x-input.text title="จำนวนคะแนนเต็ม" name-id="TargetPoint"/>

        <x-input.dropdown title="ผู้มอบหมายงาน" name-id="Assignor">
            <option></option>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-input.dropdown>

        <x-slot name="othervalue">
            <input type="hidden" name="assignment_id" id="assignment_id" value="{{$assignment->id}}"/>
        </x-slot>
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
                        <x-input.text title="จำนวนคะแนนที่ได้" name-id="AcceptPoint"/>

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

    <x-modal.input-form name-i-d="_routine" modal-title="Add New Routine Job">
        <x-input.text title="ชื่องาน" name-id="RoutineJobName"/>

        <x-input.text title="ตัวชี้วัดความสำเร็จ" name-id="KPI"/>

        <x-input.text title="คะแนน" name-id="Point"/>

        <x-slot name="othervalue">
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-modal.confirm-delete delete-name="_routine"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="RoutineJobName"/>
                <x-data-table.column-script column-name="KPI"/>
                <x-data-table.column-script column-name="Point"/>
                <x-data-table.column-script column-name="Detail">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="TargetPoint"/>
                <x-data-table.column-script column-name="AcceptPoint"/>
                <x-data-table.column-script column-name="Assignor"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_routine" ajax-url="{{ url('/routines') }}">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="RoutineJobName"/>
                <x-data-table.column-script column-name="KPI"/>
                <x-data-table.column-script column-name="Point"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Routine Job"/>

            <x-data-table.create-script name-i-d="_routine" title="Add Routine Job"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/WFH_WFA_jobs') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/routines') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/WFH_WFA_jobs') }}">
                <x-data-table.edit-value-script name="routine_job_id"/>
                <x-data-table.edit-value-script name="Detail"/>
                <x-data-table.edit-value-script name="TargetPoint"/>
                <x-data-table.edit-value-script name="Assignor"/>
            </x-data-table.edit-script>

            <x-data-table.edit-script edit-name="_routine"  edit-url="{{ url('/routines') }}">
                <x-data-table.edit-value-script name="RoutineJobName"/>
                <x-data-table.edit-value-script name="KPI"/>
                <x-data-table.edit-value-script name="Point"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/WFH_WFA_jobs') }}"/>

            <x-data-table.delete-script delete-name="_routine" url="{{ url('/routines') }}"/>

            $('#create_form2').on('submit', function(event){
                event.preventDefault();

                $.ajax({
                    url: "{{ url('/WFH_WFA_jobs/evaluate') }}",
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

            var evaluate_id;

            $(document).on('click', '.evaluate', function(){
                var evaluate_id = $(this).attr('id');
                $('#form_result2').html('');
                $.ajax({
                    url :"{{ url('/WFH_WFA_jobs/') }}"+evaluate_id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        <x-data-table.edit-value-script name="AcceptPoint"/>
                        $('#hidden_id2').val(evaluate_id);
                        $('#action_button').val('Evaluate');
                        $('#action').val('Edit');
                        $('#formModal2').modal('show');
                    }
                })
            });
        });
    </script>
@endsection
