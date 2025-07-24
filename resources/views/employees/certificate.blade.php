@extends('adminlte::page')

@section('title','Certificate')

@section('content_header')
    <h1 class="m-0 text-dark">Certificate</h1>
@stop

@section('content')
    <x-data-table.default-data-table color="" collapse-card="" title="All Certificate"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>ID</th>
        <th>WorkID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Effective Date</th>
        <th>Attachment</th>
        <th>Action</th>
        <x-slot name="othertable">
        </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Certificate">
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-select2 name="employee_id" id="employee_id" label="Employee" data-placeholder="Select an option...">
            <option/>
            @foreach ($employee as $value)
                <option value="{{$value->id}}">{{$value->ThaiName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-select2 name="certificate_type_id" id="certificate_type_id" label="Type" data-placeholder="Select an option...">
            <option/>
            @foreach ($type as $value)
                <option value="{{$value->id}}">{{$value->TypeName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input-date name="EffectiveDate" id="EffectiveDate" label="Effective Date" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input-file name="Attachment" id="Attachment" label="Upload files" igroup-size="" placeholder="Choose a file...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>

        <x-slot name="othervalue">
            <input type="hidden" name="certificate_id" id="certificate_id" value="0" />
        </x-slot>
    </x-modal.input-form>

    <div id="confirmModal" class="modal fade" role="dialog">
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
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งานใบรับรองของผู้ปฏิบัติงาน.pdf').'">การใช้งานใบรับรองของผู้ปฏิบัติงาน</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="WorkID"/>
                <x-data-table.column-script column-name="ThaiName"/>
                <x-data-table.column-script column-name="TypeName"/>
                <x-data-table.column-script column-name="EffectiveDate"/>
                <x-data-table.column-script column-name="Attachment">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            $('#create_record').click(function(){
                $('#employee_id').prop('disabled',false);
                $('#employee_certificate_type_id').prop('disabled',false);
                $('#EffectiveDate').prop('disabled',false);
                $('.select2-bootstrap4').val(null).trigger('change');
                $('.select2-hidden-accessible').val(null).trigger('change');
                $('#create_form')[0].reset();
                $('.modal-title').text('Add New Certificate');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#formModal').modal('show');
            });

            $('#create_form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action_url = '';

                if($('#action').val() == 'Add')
                {
                    action_url = "/employees_certificate";
                }

                if($('#action').val() == 'Replace')
                {
                    action_url = "/employees_certificate/update";
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
                            <x-data-table.ajax-reload-script table-id=""/>
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form')[0].reset();
                            <x-data-table.ajax-reload-script table-id=""/>
                        }
                        $('#form_result').html(html);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            $(document).on('click','.edit', function(){
                var uploadid = $(this).attr('id');
                $('#employee_id').prop('disabled',true);
                $('#employee_certificate_type_id').prop('disabled',true);
                $('#EffectiveDate').prop('disabled',true);
                $('#form_result').html('');
                $('#certificate_id').val(uploadid);
                $('#action_button').val('Replace');
                $('#action').val('Replace');
                $('#formModal').modal('show');
                console.log(uploadid);
            });

            var certificate_id;
            var employee_id;
            var certificate_type_id;

            $(document).on('click','.delete', function(){
                certificate_id = $(this).attr('id');
                employee_id = $(this).attr('employeeid');
                certificate_type_id = $(this).attr('certificatetypeid');
                $('.modal-title').text('Confirmation');
                $('#ok_button').text('Delete');
                $('#confirmModal').modal('show');
                console.log(certificate_id);
                console.log(employee_id);
                console.log(certificate_type_id);
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"/employees_certificate/destroy/"+certificate_id+"/"+employee_id+"/"+certificate_type_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            alert('Data Deleted');
                            location.reload();
                        }, 2000);
                    }
                })
            });
        });
    </script>
@endsection
