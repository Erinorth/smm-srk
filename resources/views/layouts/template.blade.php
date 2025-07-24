@extends('layouts.app')

@section('title')
    Consumable
@endsection

@section('css')

@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Consumable</h1>
@stop

@section('content')
    <h3 class="text-center">Consumable</h3> <!-- -->
    @role('store_keeper|head_store_keeper|admin')
        <div class="text-right">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Consumable</button> <!-- -->
            <a class="btn btn-success btn-sm" href="{{ URL('consumable_addstores') }}">Add Consumable to Store</a>
        </div>
    @endrole
    <br>
    <table class="table table-striped table-bordered table-sm" id="Consumable_table"> <!-- -->
        <thead>
          <tr>
            <th class="text-center">ชื่อวัสดุ</th>
            <th class="text-center">ขนาด</th>
            <th class="text-center">หน่วย</th>
            <th class="text-center">ราคา</th>
            <th class="text-center">รหัสอุปกรณ์</th>
            <th class="text-center">รหัสจัดซื้อ</th>
            <th class="text-center">Min</th>
            <th class="text-center">In Store</th>
            <th class="text-center">Max</th>
            <th class="text-center">Prepare</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
    </table>
@endsection

<x-modal.input-form name-i-d="" modal-title="Add New Consumable</h4> <!-- -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="Consumable_form" class="form-horizontal"> <!-- -->
                        @csrf
                        <x-input.dropdown>
            <x-slot name="title">ชื่อวัสดุ</label> <!-- -->
                            <div>
                                <input type="text" class="form-control" name="ConsumableName" id="ConsumableName"> <!-- -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">ขนาด</label>
                            <div>
                                <input type="text" class="form-control" name="Detail" id="Detail">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">หน่วย</label>
                            <div>
                                <input type="text" class="form-control" name="Unit" id="Unit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">ราคา</label>
                            <div>
                                <input type="text" class="form-control" name="Cost" id="Cost">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">รหัสอุปกรณ์</label>
                            <div>
                                <input type="text" class="form-control" name="ConsumableCode" id="ConsumableCode">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">รหัสจัดซื้อ</label>
                            <div>
                                <input type="text" class="form-control" name="PurchaseCode" id="PurchaseCode">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Min</label>
                            <div>
                                <input type="text" class="form-control" name="Min" id="Min">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Max</label>
                            <div>
                                <input type="text" class="form-control" name="Max" id="Max">
                            </div>
                        </div>
                        <x-slot name="othervalue">
                            </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(document).ready(function(){

            $('#Consumable_table').DataTable({ //
                processing: true,
                serverSide: true,
                ajax: {
                url: "{{ route('consumables.index') }}", //
            },
                columns: [ //
                    <x-data-table.column-script column-name=">ConsumableName',
                        name: 'ConsumableName</x-slot>
                </x-data-table.column-script>
                    <x-data-table.column-script column-name=">Detail',
                        name: 'Detail',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">Unit',
                        name: 'Unit',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">Cost',
                        name: 'Cost',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">ConsumableCode',
                        name: 'ConsumableCode',
                    },
                    <x-data-table.column-script column-name=">PurchaseCode',
                        name: 'PurchaseCode',
                    },
                    <x-data-table.column-script column-name=">Min',
                        name: 'Min',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">InStore',
                        name: 'InStore',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">Max',
                        name: 'Max',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">Prepare',
                        name: 'Prepare',
                        orderable: false
                    },
                    <x-data-table.column-script column-name=">action',
                        name: 'action',
                        orderable: false
                    }
 </x-data-table.data-table-script>

        <x-data-table.create-script name-i-d="" title="Add New Consumable"/>

        $('#Consumable_form').on('submit', function(event){ //
            event.preventDefault();
            var action_url = '';

            if($('#action').val() == 'Add')
            {
                action_url = "{{ route('consumables.store') }}"; //
            }

            if($('#action').val() == 'Edit')
            {
                action_url = "{{ route('consumable.update') }}"; //
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
                        $('#Consumable_form')[0].reset(); //
                        <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

        <x-data-table.edit-script edit-name="" >
                <x-slot name="url">consumables</x-slot>
                <x-slot name="title">Consumable</x-slot>
                    $('#ConsumableName<x-data-table.edit-value-script name="ConsumableName); //
                    $('#Detail<x-data-table.edit-value-script name="Detail);
                    $('#Unit<x-data-table.edit-value-script name="Unit);
                    $('#Cost<x-data-table.edit-value-script name="Cost);
                    $('#ConsumableCode<x-data-table.edit-value-script name="ConsumableCode);
                    $('#PurchaseCode<x-data-table.edit-value-script name="PurchaseCode);
                    $('#Min<x-data-table.edit-value-script name="Min);
                    $('#Max<x-data-table.edit-value-script name="Max);

                    Consumable</x-data-table.edit-script>

        var user_id;

        $(document).on('click', '.delete', function(){
            user_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function(){
            $.ajax({
                url:"consumables/>
        });
    </script>
@endsection
