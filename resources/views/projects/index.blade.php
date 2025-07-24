@extends('adminlte::page')

@section('title','Project')

@section('content_header')
    <h1 class="m-0 text-dark">Projects</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <x-adminlte-card title="Calendar" theme="primary" icon="" collapsible removable maximizable>
                    <div id="calendar"></div>
                </x-adminlte-card>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-adminlte-card title="Not Confirmed Project" theme="red" collapsible="collapsed" removable maximizable>
                    <x-slot name="toolsSlot">
                        @role('admin|head_engineering|planner|head_operation|head_diving')
                            <x-button.create-record name-i-d=""/>
                        @endrole
                    </x-slot>
                    <x-data-table.data-table name-i-d="_notconfirmed">
                        <th>Project Name</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>Finish Date</th>
                        <th>Responsible</th>
                        <th>Action</th>
                        <x-slot name="othertable">
                        </x-slot>
                    </x-data-table.data-table>
                </x-adminlte-card>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-data-table.default-data-table color="card-green" collapse-card="collapsed-card" title="Preparing Project"
                    collapse-button="plus" table-id="_preparing">
                    <x-slot name="tool"></x-slot>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>Finish Date</th>
                    <th>Responsible</th>
                    <th>Key Date</th>
                    <th>Milestone</th>
                    <th>Action</th>
                    <x-slot name="othertable">
                    </x-slot>
                </x-data-table.default-data-table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-data-table.default-data-table color="card-cyan" collapse-card="" title="Inprogress Project"
                    collapse-button="minus" table-id="_inprogress">
                    <x-slot name="tool"></x-slot>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>Finish Date</th>
                    <th>Responsible</th>
                    <th>Daily Report Link</th>
                    <th>Key Date</th>
                    <th>Milestone</th>
                    <th>Action</th>
                    <x-slot name="othertable">
                    </x-slot>
                </x-data-table.default-data-table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-data-table.default-data-table color="card-yellow" collapse-card="collapsed-card" title="Finished Project"
                    collapse-button="plus" table-id="_finished">
                    <x-slot name="tool"></x-slot>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>Finish Date</th>
                    <th>Responsible</th>
                    <th>MileStone</th>
                    <th>Action</th>
                    <x-slot name="othertable">
                    </x-slot>
                </x-data-table.default-data-table>
            </div>
        </div>
    </div>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน project.pdf').'">การใช้งาน Project</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>

    <x-modal.input-form name-i-d="" modal-title="Create Project">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input name="ProjectName" label="Project Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="project_type_id" label="Project Type" data-placeholder="Select an option...">
            <option/>
            @foreach ($type as $value)
                <option value="{{$value->id}}">{{$value->TypeName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input-date name="StartDate" label="Start Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input-date name="FinishDate" label="Finish Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-select2 name="SiteEngineer" label="ผู้รับผิดชอบ1/Planner/Site Engineer" data-placeholder="Select an option...">
            <option/>
            @foreach ($siteengineer as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="AreaManager" label="ผู้รับผิดชอบ2/Area Manager/ผู้ควบคุมงาน" data-placeholder="Select an option...">
            <option/>
            @foreach ($areamanager as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Supervisor" label="จำนวนประมาณการการใช้ Supervisor" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Foreman" label="จำนวนประมาณการการใช้ Foreman" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Skill" label="จำนวนประมาณการการใช้ Skill" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-select2 name="Status" label="Status" data-placeholder="Select an option...">
            <option/>
            <option>Not Confirmed</option>
            <option>Confirmed</option>
        </x-adminlte-select2>

        <x-adminlte-select2 name="show" label="Show On Calendar" data-placeholder="Select an option...">
            <option/>
            <option>Yes</option>
            <option>No</option>
        </x-adminlte-select2>

        <x-adminlte-input name="DailyReport" label="Daily Report Link" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue"></x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="keydate" modal-title="Key Date">
        <x-adminlte-input-file name="KeyDate" label="Select Key Date File for Upload" igroup-size="" placeholder="Choose a file...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>

        <x-slot name="othervalue"></x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <div id="formModal_keydate" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result_keydate"></span>
                    <form method="post" id="create_form_keydate" class="form-horizontal" enctype="multipart/form-data" action="javascript:void(0)">
                        @csrf

                        <x-adminlte-input-file name="select_file" label="Select File for Upload" igroup-size="" placeholder="Choose a file...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>

                        <input type="hidden" name="action_keydate" id="action_keydate" value="Upload" />
                        <input type="submit" name="action_button_keydate" id="action_button_keydate" class="btn btn-success" value="Upload" />
                        <input type="hidden" name="project_id" id="project_id"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal_keydate" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Confirmation</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button_keydate" id="ok_button_keydate" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function(){

            var calendar = $('#calendar').fullCalendar({
                /* schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source', */
                schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,timeline'
                },
                events:"{{ url('/project_calendars') }}"
            });

            <x-data-table.data-table-script table-name="_inprogress" ajax-url="{{ url('/projects/inprogress') }}">
                <x-data-table.column-script column-name="ProjectName"/>
                <x-data-table.column-script column-name="TypeName"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="FinishDate"/>
                <x-data-table.column-script column-name="Responsible"/>
                <x-data-table.column-script column-name="DailyReport">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="KeyDate">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="MileStone">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[2,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_notconfirmed" ajax-url="{{ url('/projects') }}">
                <x-data-table.column-script column-name="ProjectName"/>
                <x-data-table.column-script column-name="TypeName"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="FinishDate"/>
                <x-data-table.column-script column-name="Responsible"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[2,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_preparing" ajax-url="{{ url('/projects/prepare') }}">
                <x-data-table.column-script column-name="ProjectName"/>
                <x-data-table.column-script column-name="TypeName"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="FinishDate"/>
                <x-data-table.column-script column-name="Responsible"/>
                <x-data-table.column-script column-name="KeyDate">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="MileStone">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[2,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.data-table-script table-name="_finished" ajax-url="{{ url('/projects/finish') }}">
                <x-data-table.column-script column-name="ProjectName"/>
                <x-data-table.column-script column-name="TypeName"/>
                <x-data-table.column-script column-name="StartDate"/>
                <x-data-table.column-script column-name="FinishDate"/>
                <x-data-table.column-script column-name="Responsible"/>
                <x-data-table.column-script column-name="MileStone">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[3,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Project"/>

            <x-data-table.submit-script name-i-d="" action-url="projects">
                <x-data-table.ajax-reload-script table-id="notconfirmed"/>
                <x-data-table.ajax-reload-script table-id="preparing"/>
                <x-data-table.ajax-reload-script table-id="inprogress"/>
                <x-data-table.ajax-reload-script table-id="finished"/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="projects">
                <x-data-table.edit-value-script name="ProjectName"/>
                <x-data-table.edit-value-script name="project_type_id"/>
                <x-data-table.edit-value-script name="StartDate"/>
                <x-data-table.edit-value-script name="FinishDate"/>
                <x-data-table.edit-value-script name="SiteEngineer"/>
                <x-data-table.edit-value-script name="AreaManager"/>
                <x-data-table.edit-value-script name="Supervisor"/>
                <x-data-table.edit-value-script name="Foreman"/>
                <x-data-table.edit-value-script name="Skill"/>
                <x-data-table.edit-value-script name="Status"/>
                <x-data-table.edit-value-script name="show"/>
                <x-data-table.edit-value-script name="DailyReport"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/projects') }}"/>

            $(document).on('click','.keydate', function(){
                var project_id = $(this).attr('id');
                $('#create_form_keydate')[0].reset();
                $('#form_result_keydate').html('');
                $('#formModal_keydate').modal('show');
                console.log(project_id);
                $('#project_id').val(project_id);
            });

            $('#create_form_keydate').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action_url_keydate = '';

                if($('#action_keydate').val() == 'Upload')
                {
                    action_url_keydate = "{{ url('/upload_keydate') }}";
                }

                if($('#action_keydate').val() == 'Edit')
                {
                    action_url_keydate = "{{ url('/upload_keydate/update') }}";
                }

                $.ajax({
                    type:'POST',
                    url: action_url_keydate,
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        var html_keydate = '';
                        if(data.errors)
                        {
                            html_keydate = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html_keydate += '<p>' + data.errors[count] + '</p>';
                            }
                            html_keydate += '</div>';
                            $('#create_form_keydate')[0].reset();
                        }
                        if(data.failures)
                        {
                            console.log('failures');

                            html_keydate = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.failures.length; count++)
                            {
                                html_keydate += '<p> Row:' + data.failures[count].row +
                                ' ' + data.failures[count].errors + '</p>';
                            }
                            html_keydate += '</div>';
                            $('#create_form_keydate')[0].reset();
                            $('#data_table_inprogress').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html_keydate = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form_keydate')[0].reset();
                            $('#data_table_inprogress').DataTable().ajax.reload();
                            $('#data_table_preparing').DataTable().ajax.reload();
                        }
                        $('#form_result_keydate').html(html_keydate);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            $(document).on('click','.edit_keydate', function(){
                var uploadid = $(this).attr('id');
                $('#form_result_keydate').html('');
                $('#project_id').val(uploadid);
                $('#action_button_keydate').val('Edit');
                $('#action_keydate').val('Edit');
                $('#formModal_keydate').modal('show');
                console.log(uploadid);
            });

            var user_id_keydate;

            $(document).on('click', '.delete_keydate', function(){
                user_id_keydate = $(this).attr('id');
                $('.modal-title').text('Confirmation');
                $('#ok_button_keydate').text('Delete');
                $('#confirmModal_keydate').modal('show');
                console.log(user_id_keydate);
            });

            $('#ok_button_keydate').click(function(){
                $.ajax({
                    url:"{{ url('/upload_keydate/destroy') }}/" + user_id_keydate,
                    beforeSend:function(){
                        $('#ok_button_keydate').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal_keydate').modal('hide');
                            alert('Data Deleted');
                            location.reload();
                        }, 2000);
                    }
                })
            });

        });
    </script>
@endsection
