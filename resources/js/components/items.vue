<template>
    <h3 class="text-center">Item</h3> <!-- -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <select name="filter_location" id="filter_location" class="form-control filter" data-column="1">
                <option value="">Filter Location</option>
                @foreach ($location as $value)
                    <option value="{{$value->LocationName}}">{{$value->LocationName}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <select name="filter_product" id="filter_product" class="form-control filter" data-column="2">
                <option value="">Filter Product</option>
                @foreach ($product as $value)
                    <option value="{{$value->ProductName}}">{{$value->ProductName}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <select name="filter_machine" id="filter_machine" class="form-control filter" data-column="3">
                <option value="">Filter Machine</option>
                @foreach ($machine as $value)
                    <option value="{{$value->MachineName}}">{{$value->MachineName}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <select name="filter_system" id="filter_system" class="form-control filter" data-column="4">
                <option value="">Filter System</option>
                @foreach ($system as $value)
                    <option value="{{$value->SystemName}}">{{$value->SystemName}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <select name="filter_equipment" id="filter_equipment" class="form-control filter" data-column="5">
                <option value="">Filter Equipment</option>
                @foreach ($equipment as $value)
                    <option value="{{$value->EquipmentName}}">{{$value->EquipmentName}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <select name="filter_scope" id="filter_scope" class="form-control filter" data-column="6">
                <option value="">Filter Scope</option>
                @foreach ($scope as $value)
                    <option value="{{$value->ScopeName}}">{{$value->ScopeName}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @role('admin|head_engineering|planner')
        <div class="text-right">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Item</button> <!-- -->
        </div>
    @endrole
    <br>
    <table class="table table-striped table-bordered table-sm" id="data_table">
        <thead>
          <tr>
            <th class="text-center align-middle">Item ID</th>
            <th class="text-center align-middle">Location Name</th>
            <th class="text-center align-middle">Product Name</th>
            <th class="text-center align-middle">Machine Name</th>
            <th class="text-center align-middle">System Name</th>
            <th class="text-center align-middle">Equipment Name</th>
            <th class="text-center align-middle">Scope of Work</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
    </table>
</template>

<script>
    export default {
        
    }
</script>

@extends('layouts.app')

@section('title')
    Consumable
@endsection

@section('headscripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
@endsection

@section('content')
    
@endsection

@section('modal')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Item</h4> <!-- -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="create_form" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" >Location</label>
                            <div>
                                <select name="location_id" id="location_id" class="form-control">
                                    <option value="">Location Name</option>
                                    @foreach ($location as $value)
                                        <option value="{{$value->id}}">{{$value->LocationName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" >Product</label>
                            <div>
                                <select name="product_id" id="product_id" class="form-control">
                                    <option value="">Product Name</option>
                                    @foreach ($product as $value)
                                        <option value="{{$value->id}}">{{$value->ProductName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" >Machine</label>
                            <div>
                                <select name="machine_id" id="machine_id" class="form-control">
                                    <option value="">Machine Name</option>
                                    @foreach ($machine as $value)
                                        <option value="{{$value->id}}">{{$value->MachineName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" >System</label>
                            <div>
                                <select name="system_id" id="system_id" class="form-control">
                                    <option value="">System Name</option>
                                    @foreach ($system as $value)
                                        <option value="{{$value->id}}">{{$value->SystemName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" >Equipment</label>
                            <div>
                                <select name="equipment_id" id="equipment_id" class="form-control">
                                    <option value="">Equipment Name</option>
                                    @foreach ($equipment as $value)
                                        <option value="{{$value->id}}">{{$value->EquipmentName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" >Scope</label>
                            <div>
                                <select name="scope_id" id="scope_id" class="form-control">
                                    <option value="">Scope Name</option>
                                    @foreach ($scope as $value)
                                        <option value="{{$value->id}}">{{$value->ScopeName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group text-center">
                            <input type="hidden" name="action" id="action" value="Add" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="confirmmodal-title">Confirmation</h2>
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
@endsection

@section('endscripts')
    <script>
        $(document).ready(function(){

                var datatable = $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('/items') }}", //
                    },
                    columns: [ //
                        {
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'LocationName',
                            name: 'LocationName'
                        },
                        {
                            data: 'ProductName',
                            name: 'ProductName'
                        },
                        {
                            data: 'MachineName',
                            name: 'MachineName'
                        },
                        {
                            data: 'SystemName',
                            name: 'SystemName'
                        },
                        {
                            data: 'EquipmentName',
                            name: 'EquipmentName',
                        },
                        {
                            data: 'ScopeName',
                            name: 'ScopeName'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ]
                });
            
            $('.filter').change(function(){
            datatable.column($(this).data('column'))
            .search($(this).val())
            .draw();
            });

            $('#create_record').click(function(){
            $('#create_form')[0].reset();
                $('.modal-title').text('Add New Item'); //
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#formModal').modal('show');
            });

            $('#create_form').on('submit', function(event){
                event.preventDefault();
                var action_url = '';

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ url('/items') }}"; //
                }

                if($('#action').val() == 'Edit')
                {
                    action_url = "{{ url('/items/update') }}"; //
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
                            $('#create_form')[0].reset();
                            $('#data_table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    }
                });
            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"/items/"+id+"/edit", //
                    dataType:"json",
                    success:function(data)
                    {
                        $('#location_id').val(data.result.location_id); //
                        $('#product_id').val(data.result.product_id);
                        $('#machine_id').val(data.result.machine_id);
                        $('#system_id').val(data.result.system_id);
                        $('#equipment_id').val(data.result.equipment_id);
                        $('#scope_id').val(data.result.scope_id);
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Item'); //
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"items/destroy/"+user_id, //
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#data_table').DataTable().ajax.reload();
                            alert('Data Deleted');
                        }, 2000);
                    }
                })
            });
        });
    </script>
@endsection