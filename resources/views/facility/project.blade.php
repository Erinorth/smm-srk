@extends('adminlte::page')

@section('title','Request Facility')

@section('content_header')
    <h1 class="m-0 text-dark">Request Facility</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Request Facilities/Tools"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Facility/Tool Name</th>
        <th>Type</th>
        <th>Detail</th>
        <th>Use Date</th>
        <th>Remark</th>
        <th>Attachment</th>
        <th>Action</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Crane/Hoist Certificate" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <a href="{{ url('crane_certificate') }}" class="btn btn-success btn-block btn-sm">Certificate</a>
    </x-card.default-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Request Cranes/Hoist"
        collapse-button="minus" table-id="crane">
        <x-slot name="tool">
            <x-button.create-record name-i-d="crane"/>
        </x-slot>
        <th>Crane/Hoist</th>
        <th>Detail</th>
        <th>Max Use Load</th>
        <th>Use Date</th>
        <th>Remark</th>
        <th>Attachment</th>
        <th>Action</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Request Facilities">
        <x-adminlte-input name="ToolName" label="Facility/Tool Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-select2 name="Type" label="Type" data-placeholder="Select an option...">
            <option/>
            <option>Normal Tools</option>
            <option>Special Tools</option>
            <option>Measuring Tools</option>
            <option>Other Facility</option>
        </x-adminlte-select2>

        <x-adminlte-input name="Detail" label="Detail" placeholder="Input a text..."
            disable-feedback/>

        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="UseDate" label="Use Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.input-form name-i-d="_attachment" modal-title="Add New Attachment">
        <x-adminlte-input-file name="Attachment" id="Attachment" label="Upload files" igroup-size="" placeholder="Choose a file...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}" />
            <input type="hidden" name="attachment_id" id="attachment_id" value="0" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    <x-modal.confirm-delete delete-name="_attachment"/>

    <x-modal.input-form name-i-d="crane" modal-title="Add New Request Crane/Hoist">
        <x-adminlte-select2 name="machine_set_id" label="Crane/Hoist" data-placeholder="Select an option...">
            <option/>
            @foreach ($crane as $value)
                <option value="{{ $value->id }}">{{ $value->MachineName }}@if ($value->Remark != "") //{{ $value->Remark }} @endif @if ($value->SerialNumber != "") //{{ $value->SerialNumber }} @endif</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="MaxUseLoad" label="Max Use Load(tons)" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="UseDate_crane" label="Use Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input name="Remark_crane" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name="crane"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-j-s.data-table2 table-name="" ajax-url="/facility_project_tool" ajax-url2="{{ $project->id }}">
                <x-data-table.column-script column-name="ToolName"/>
                <x-data-table.column-script column-name="Type"/>
                <x-data-table.column-script column-name="Detail"/>
                <x-data-table.column-script column-name="UseDate"/>
                <x-data-table.column-script column-name="Remark"/>
                <x-data-table.column-script column-name="Attachment"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-j-s.data-table2>

            <x-data-table.create-script name-i-d="" title="Request Tools"/>

            <x-data-table.submit-script name-i-d="" action-url="facility_project_tool">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="facility_project_tool">
                <x-data-table.edit-value-script name="ToolName"/>
                <x-data-table.edit-value-script name="Type"/>
                <x-data-table.edit-value-script name="Detail"/>
                <x-data-table.edit-value-script name="UseDate"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="facility_project_tool"/>

            $(document).on('click','.attachment', function(){
                var attachment_id = $(this).attr('id');
                $('#create_form_attachment')[0].reset();
                $('#form_result_attachment').html('');
                $('#action_attachment').val('Upload')
                $('#action_button_attachment').val('Upload')
                $('#formModal_attachment').modal('show');
                console.log(attachment_id);
                $('#attachment_id').val(attachment_id);
            });

            $('#create_form_attachment').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action_url_attachment = '';

                if($('#action_attachment').val() == 'Upload')
                {
                    action_url_attachment = "/facility_project_tool_attachment";
                }

                if($('#action_attachment').val() == 'Edit')
                {
                    action_url_attachment = "/facility_project_tool_attachment/update";
                }

                $.ajax({
                    type:'POST',
                    url: action_url_attachment,
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        var html_attachment = '';
                        if(data.errors)
                        {
                            html_attachment = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html_attachment += '<p>' + data.errors[count] + '</p>';
                            }
                            html_attachment += '</div>';
                            $('#create_form_attachment')[0].reset();
                        }
                        if(data.failures)
                        {
                            console.log('failures');

                            html_attachment = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.failures.length; count++)
                            {
                                html_attachment += '<p> Row:' + data.failures[count].row +
                                ' ' + data.failures[count].errors + '</p>';
                            }
                            html_attachment += '</div>';
                            $('#create_form_attachment')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html_attachment = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form_attachment')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        $('#form_result_attachment').html(html_attachment);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            $(document).on('click','.edit_attachment', function(){
                var uploadid = $(this).attr('id');
                $('#form_result_attachment').html('');
                $('#attachment_id').val(uploadid);
                $('#action_button_attachment').val('Edit');
                $('#action_attachment').val('Edit');
                $('#formModal_attachment').modal('show');
                console.log(uploadid);
            });

            var projectid = $('#project_id').attr('value');
            var user_id_attachment;

            $(document).on('click', '.delete_attachment', function(){
                user_id_attachment = $(this).attr('id');
                $('.modal-title').text('Confirmation');
                $('#ok_button_attachment').text('Delete');
                $('#confirmModal_attachment').modal('show');
                console.log(projectid);
                console.log(user_id_attachment);
            });

            $('#ok_button_attachment').click(function(){
                $.ajax({
                    url:"/facility_project_tool_attachment/destroy/"+user_id_attachment+"/"+projectid,
                    beforeSend:function(){
                        $('#ok_button_attachment').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal_attachment').modal('hide');
                            alert('Data Deleted');
                            location.reload();
                        }, 2000);
                    }
                })
            });

            <x-j-s.data-table2 table-name="crane" ajax-url="/facility_project_crane" ajax-url2="{{ $project->id }}">
                <x-data-table.column-script column-name="MachineName"/>
                <x-data-table.column-script column-name="MachineDetail"/>
                <x-data-table.column-script column-name="MaxUseLoad"/>
                <x-data-table.column-script column-name="UseDate"/>
                <x-data-table.column-script column-name="Remark"/>
                <x-data-table.column-script column-name="Attachment"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-j-s.data-table2>

            <x-data-table.create-script name-i-d="crane" title="Request Cranes"/>

            <x-data-table.submit-script name-i-d="crane" action-url="facility_project_crane">
                <x-data-table.ajax-reload-script table-id="crane"/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name="crane"  edit-url="facility_project_crane">
                <x-data-table.edit-value-script name="machine_set_id"/>
                <x-data-table.edit-value-script name="MaxUseLoad"/>
                $('#UseDate_crane').val(data.result.UseDate);
                $('#UseDate_crane').trigger('change');
                $('#Remark_crane').val(data.result.Remark);
                $('#Remark_crane').trigger('change');
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="crane" url="facility_project_crane"/>
        });
    </script>
@endsection
