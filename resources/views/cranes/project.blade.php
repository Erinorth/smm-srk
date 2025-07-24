@extends('adminlte::page')

@section('title','Crane Certificate')

@section('content_header')
    <h1 class="m-0 text-dark">Crane Certificate</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-adminlte-card title="Report" theme="primary" icon="" collapsible="collapsed" removable maximizable>
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/crane_report/'.$project->id) }}">
            @csrf
            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-block btn-success btn-sm">Print</button>
                </div>
            </div>
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </form>
    </x-adminlte-card>

    <x-data-table.default-data-table color="" collapse-card="" title="Crane Certificate"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Location Name</th>
        <th>Machine Name</th>
        <th>Remark</th>
        <th>SerialNumber</th>
        <th>Test Date</th>
        <th>Result</th>
        <th>Attachment</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Crane Certificate">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="TestDate" label="Test Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-text-editor name="Result" label="Result"/>

        <x-adminlte-input-file name="Attachment" label="Select File for Upload" igroup-size="" placeholder="Choose a file...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>

        <x-slot name="othervalue">
            <input type="hidden" name="machine_set_id" id="machine_set_id"/>
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="LocationName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="MachineName">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="SerialNumber">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="TestDate"/>
                <x-data-table.column-script column-name="Result">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Attachment">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            $(document).on('click','.add', function(){
                var machine_set_id = $(this).attr('id');
                $('#create_form')[0].reset();
                $('#TestDate').prop('disabled', false);
                $('#Attachment').prop('disabled', false);
                $('#Result').summernote('enable');
                $('#machine_set_id').val(machine_set_id);
                $('#form_result').html('');
                $('#formModal').modal('show');
                console.log(machine_set_id);
            });

            $('#create_form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action_url = '';

                if($('#action').val() == 'Add')
                {
                    action_url = "/crane_certificate";
                }

                if($('#action').val() == 'Edit')
                {
                    action_url = "/crane_certificate/update";
                }

                if($('#action').val() == 'Change')
                {
                    action_url = "/crane_certificate/change";
                }

                $.ajax({
                    type:'POST',
                    url: action_url,
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
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
                            $('#create_form')[0].reset();
                        }
                        if(data.failures)
                        {
                            console.log('failures');

                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.failures.length; count++)
                            {
                                html += '<p> Row:' + data.failures[count].row +
                                ' ' + data.failures[count].errors + '</p>';
                            }
                            html += '</div>';
                            $('#create_form')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"/crane_certificate/"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        $('#TestDate').prop('disabled', true);
                        $('#Result').summernote('enable');
                        $('#Attachment').prop('disabled', true);
                        <x-data-table.edit-value-script name="TestDate"/>
                        $('#Result').summernote("code", data.result.Result);
                        $('#hidden_id').val(id);
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');
                        console.log(data.result.Result);
                    }
                })
            });

            $(document).on('click', '.edit_attachment', function(){
                var id = $(this).attr('id');
                $.ajax({
                    url :"/crane_certificate/"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        $('#form_result').html('');
                        $('#TestDate').prop('disabled', true);
                        $('#Result').summernote('disable');
                        $('#Attachment').prop('disabled', false);
                        <x-data-table.edit-value-script name="TestDate"/>
                        $('#Result').summernote("code", data.result.Result);
                        $('#hidden_id').val(id);
                        $('#action_button').val('Change');
                        $('#action').val('Change');
                        $('#formModal').modal('show');
                    }
                })
            });

            <x-data-table.delete-script delete-name="" url="crane_certificate"/>
        });
    </script>
@endsection
