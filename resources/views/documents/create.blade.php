@extends('adminlte::page')

@section('title','Document')

@section('content_header')
    <h1 class="m-0 text-dark">Document</h1>
@stop

@section('content')
    <x-header.item itemId="{{$item->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.item>

    <x-data-table.default-data-table color="" collapse-card="" title="Document"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Document Name</th>
        <th>Document Code</th>
        <th>Remark</th>
        <th>Attachment</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Create Document">
        <x-adminlte-input name="DocumentName" label="Document Name" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="DocumentCode" label="Document Code" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-adminlte-input-file name="Attachment" label="Select File for Upload" igroup-size="" placeholder="Choose a file...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>

        <x-slot name="othervalue">
            <input type="hidden" name="item_id" id="item_id" value="{{$item->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน document.pdf').'">การใช้งาน Document</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="DocumentName"/>
                <x-data-table.column-script column-name="DocumentCode">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Attachment">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc']</x-slot>
            </x-data-table.data-table-script>

            $('#create_record').click(function(){
                $('#DocumentName').prop('disabled', false);
                $('#DocumentCode').prop('disabled', false);
                $('#Remark').prop('disabled', false);
                $('#Attachment').prop('disabled', false);
                $('.select2-bootstrap4').val(null).trigger('change');
                $('.select2-hidden-accessible').val(null).trigger('change');
                $('#create_form')[0].reset();
                $('.modal-title').text('Add New Special Tool');
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
                    action_url = "/documents";
                }

                if($('#action').val() == 'Edit')
                {
                    action_url = "/documents/update";
                }

                if($('#action').val() == 'Change')
                {
                    action_url = "/documents/change";
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
                    url :"{{ url('/documents/') }}"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        $('#DocumentName').prop('disabled', false);
                        $('#DocumentCode').prop('disabled', false);
                        $('#Remark').prop('disabled', false);
                        $('#Attachment').prop('disabled', true);
                        <x-data-table.edit-value-script name="DocumentName"/>
                        <x-data-table.edit-value-script name="DocumentCode"/>
                        <x-data-table.edit-value-script name="Remark"/>
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
                    url :"{{ url('/documents/') }}"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        $('#form_result').html('');
                        $('#DocumentName').prop('disabled', true);
                        $('#DocumentCode').prop('disabled', true);
                        $('#Remark').prop('disabled', true);
                        $('#Attachment').prop('disabled', false);
                        <x-data-table.edit-value-script name="DocumentName"/>
                        <x-data-table.edit-value-script name="DocumentCode"/>
                        <x-data-table.edit-value-script name="Remark"/>
                        $('#hidden_id').val(id);
                        $('#action_button').val('Change');
                        $('#action').val('Change');
                        $('#formModal').modal('show');
                    }
                })
            });

            <x-data-table.delete-script delete-name="" url="{{ url('/documents') }}"/>
        });
    </script>
@endsection
