@extends('adminlte::page')

@section('title','Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Tool</h1>
@stop

@section('content')
    <x-header.tool-catagory-site toolCatagorySiteId="{{$toolcatagorysite->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.tool-catagory-site>

    <x-data-table.default-data-table color="" collapse-card="" title="Tool Catagory"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
            <x-button.create-record name-i-d=""/>
        </x-slot>
        <th>Code</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Serial Number</th>
        <th>Durable Supplie Code</th>
        <th>Asset Tool Code</th>
        <th>Status</th>
        <th>Remark</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Tool Catagory">
        <x-adminlte-select2 name="tool_id" label="Tool Code" data-placeholder="Select an option...">
            <option/>
            @foreach ($tool as $value)
                <option value="{{$value->tool_id}}">{{$value->LocalCode}}//{{$value->Brand}}//{{$value->Model}}//{{$value->SerialNumber}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="Status" id="Status" value="On Site" />
            <input type="hidden" name="tool_catagory_site_id" id="tool_catagory_site_id" value="{{$toolcatagorysite->id}}" />
        </x-slot>
    </x-modal.input-form>

    <div id="formModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4> <!-- -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result2"></span>
                    <form method="post" id="update_form" class="form-horizontal">
                        @csrf

                        <x-adminlte-select2 name="Status2" label="Status" data-placeholder="Select an option...">
                            <option/>
                            <option>On Site</option>
                            <option>Return</option>
                            <option>Lost</option>
                            <option>Broken</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="Remark2" label="Remark" placeholder="Input a text..."
                            disable-feedback/>

                        <div class="form-group text-center">
                            <input type="hidden" name="action2" id="action2" value="Update" />
                            <input type="hidden" name="tool_catagory_site_id2" id="tool_catagory_site_id2" />
                            <input type="hidden" name="tool_id2" id="tool_id2" />
                            <input type="submit" name="action_button2" id="action_button2" class="btn btn-success" value="Update" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="formModal3" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4> <!-- -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result3"></span>
                    <form method="post" id="update_form3" class="form-horizontal">
                        @csrf

                        <x-adminlte-select2 name="project_id" label="Project" data-placeholder="Select an option...">
                            <option/>
                            @foreach ($project as $value)
                                <option value="{{$value->id}}">{{$value->ProjectName}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input name="Remark3" label="Remark" placeholder="Input a text..."
                            disable-feedback/>

                        <div class="form-group text-center">
                            <input type="hidden" name="action3" id="action3" value="Transfer" />
                            <input type="hidden" name="transfer_id" id="transfer_id" />
                            <input type="hidden" name="tool_catagory_site_id3" id="tool_catagory_site_id3" value="{{$toolcatagorysite->id}}">
                            <input type="submit" name="action_button3" id="action_button3" class="btn btn-success" value="Transfer" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การจัดทำรายการเครื่องมือที่จะนำไปใช้งาน.pdf').'">การจัดทำรายการเครื่องมือที่จะนำไปใช้งาน</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="LocalCode"/>
                <x-data-table.column-script column-name="Brand"/>
                <x-data-table.column-script column-name="Model"/>
                <x-data-table.column-script column-name="SerialNumber"/>
                <x-data-table.column-script column-name="DurableSupplieCode"/>
                <x-data-table.column-script column-name="AssetToolCode"/>
                <x-data-table.column-script column-name="Status">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order"></x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Pick Tool to Site"/>

            <x-data-table.submit-script name-i-d="" action-url="tool_sites">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.delete-script delete-name="" url="tool_sites"/>

            $(document).on('click', '.update', function(){
                var tool_id2 = $(this).attr('tool_id');
                var tool_catagory_site_id2 = $(this).attr('tool_catagory_site_id');
                $('.select2-bootstrap4').val(null).trigger('change');
                $('#update_form')[0].reset();
                $('.modal-title').text('Update');
                $('#tool_id2').val(tool_id2);
                $('#tool_catagory_site_id2').val(tool_catagory_site_id2);
                $('#action_button2').val('Update');
                $('#action2').val('Update');
                $('#form_result2').html('');
                $('#formModal2').modal('show');
                console.log(tool_catagory_site_id2);
                console.log(tool_id2);
            });

            $('#update_form').on('submit', function(event){
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "/tool_sites/update",
                    method:"POST",
                    data:formData,
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
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('.select2-bootstrap4').val(null).trigger('change');
                            $('#update_form')[0].reset();
                            <x-data-table.ajax-reload-script table-id=""/>
                        }
                        $('#form_result2').html(html);
                    }
                });
            });

            $(document).on('click', '.transfer', function(){
                var transfer_id = $(this).attr('id');
                $('.select2-bootstrap4').val(null).trigger('change');
                $('#update_form3')[0].reset();
                $('#transfer_id').val(transfer_id);
                $('#form_result3').html('');
                $('#formModal3').modal('show');
            });

            $('#update_form3').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url: "/tool_sites/transfer",
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
                            $('#update_form3')[0].reset();
                            location.reload();
                        }
                        $('#form_result3').html(html);
                    }
                });
            });
        });
    </script>
@endsection
