@extends('adminlte::page')

@section('title','Plan Overtime')

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-adminlte-card title="Report" theme="primary" icon="" collapsible="collapsed" removable maximizable>
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/plan_ot_report') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <x-adminlte-select2 name="yearnumber" label="Year" data-placeholder="Select an option...">
                        <option></option>
                        @foreach ($yearnumber as $value)
                            <option value="{{$value->YearNumber}}">{{$value->YearNumber}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="col">
                    <x-adminlte-select2 name="monthnumber" label="Month" data-placeholder="Select an option...">
                        <option></option>
                        @foreach ($monthnumber as $value)
                            <option value="{{$value->MonthNumber}}">{{$value->MonthNumber}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </form>
    </x-adminlte-card>

    {{-- @if ( $employee_16 )
        <x-adminlte-card title="ลว.2" theme="danger" icon="" collapsible="collapsed" removable maximizable>
            <x-slot name="tool"></x-slot>
            <form class="form-horizontal" method="POST" action="{{ url('/plan_ot_report_16') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        <x-adminlte-select2 name="yearnumber_16" label="ปี" data-placeholder="Select an option...">
                            <option></option>
                            @foreach ($yearnumber as $value)
                                <option value="{{$value->YearNumber}}">{{$value->YearNumber}}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="col">
                        <x-adminlte-select2 name="monthnumber_16" label="เดือน" data-placeholder="Select an option...">
                            <option></option>
                            @foreach ($monthnumber as $value)
                                <option value="{{$value->MonthNumber}}">{{$value->MonthNumber}}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="col-sm-1 text-center">
                        <button type="submit" class="btn btn-success btn-sm">Print</button>
                    </div>
                </div>
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Select All <input type="checkbox" id="checkAll"/></th>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee_16 as $value)
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="checkBoxClass" name="employee_16[]" value="{{ $value->id }}"/></td>
                                    <td class="text-center">{{ $value->WorkID }}</td>
                                    <td>{{ $value->ThaiName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
            </form>
        </x-adminlte-card>
    @endif --}}

    <x-content.plan-o-t/>

    <x-content.o-t-frame project-i-d="{{ $project->id}}"/>

    <x-modal.input-form name-i-d="_planot" modal-title="Add New Plan Overtime">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="PlanDate" label="Plan Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-select2 name="employee_id" label="Name" data-placeholder="Select an option...">
            <option></option>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="PlanHour" label="Plan Hour" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}"/>
        </x-slot>
    </x-modal.input-form>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            var project_id = $('#project_id').attr('value');

            <x-j-s.plan-o-t/>

            $('#data_table_otframe').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "/otframe/"+project_id,
                    data: {project_id:project_id},
                },
                columns: [
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
                ],
                "order":[[2,'desc'],[3,'desc'],[0,'asc']],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "dom": "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-6'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "buttons": ["copy", "excel", "print", "colvis"]
            });

            $('#create_form_otframe').on('submit', function(event){
                event.preventDefault();
                var action_url = '';

                if($('#action_otframe').val() == 'Add')
                {
                    action_url = "/otframe";
                }

                if($('#action_otframe').val() == 'Edit')
                {
                    action_url = "/otframe_project/update";
                }

                $.ajax({
                    url: action_url,
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
                            $('#create_form_otframe')[0].reset();
                            <x-data-table.ajax-reload-script table-id="_otframe"/>
                        }
                        $('#form_result_otframe').html(html);
                    }
                });
            });

            $(document).on('click', '.edit_otframe', function(){
                var id = $(this).attr('id');
                var employee_id = $(this).attr('employee_id');
                var Year = $(this).attr('Year');
                var Month = $(this).attr('Month');
                $('#form_result_otframe').html('');
                $.ajax({
                    url :"/otframe/"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        <x-data-table.edit-value-script name="Frame"/>
                        <x-data-table.edit-value-script name="Remark2"/>
                        $('#hidden_id_otframe').val(id);
                        $('#employee_id2').val(employee_id);
                        $('#Year').val(Year);
                        $('#Month').val(Month);
                        $('#action_button_otframe').val('Edit');
                        $('#action_otframe').val('Edit');
                        $('#formModal_otframe').modal('show');
                        console.log(employee_id);
                        console.log(Year);
                        console.log(Month);
                    }
                })
            });

            /* $(function(e){
                $('#checkAll').click(function(){
                    $('.checkBoxClass').prop('checked',$(this).prop('checked'));
                });
            }); */
        });
    </script>
@endsection
