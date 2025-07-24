@extends('adminlte::page')

@section('title', 'Job')

@section('content_header')
    <h1 class="m-0 text-dark">Creat Job</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Project Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-header.machine-set-h machineSetId="{{$machineset->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Machine Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.machine-set-h>

    <x-data-table.default-data-table color="" collapse-card="" title="Item"
        collapse-button="minus" table-id="_item">
        <x-slot name="tool">
        </x-slot>
        <th>ID</th>
        <th>Product Name</th>
        <th>System Name</th>
        <th>Equipment Name</th>
        <th>Scope of Work</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="card-collapsed" title="Added"
        collapse-button="plus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Create At</th>
        <th>Product</th>
        <th>System</th>
        <th>Equipment</th>
        <th>Scope</th>
        <th>PM Order</th>
        <th>Remark</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <x-modal.input-form name-i-d="" modal-title="Add New Job">
        <x-adminlte-select2 name="p_m_order_id" label="PM Order" data-placeholder="Select an option...">
            <option/>
            @foreach ($pmorder as $value)
                <option value="{{$value->id}}">{{$value->PMOrder}} / {{$value->PMOrderName}}</option>
            @endforeach
        </x-adminlte-select2>

        <x-adminlte-input name="Remark" label="Remark" placeholder="Input a text..."
            disable-feedback/>

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
            <input type="hidden" name="machine_set_id" id="machine_set_id" value="{{$machineset->id}}" />
            <input type="hidden" name="item_id" id="item_id"/>
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน work list.pdf').'">การใช้งาน Work List</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            var project_id = $('#project_id').attr('value');
            var machine_set_id = $('#machine_set_id').attr('value');
            $('#data_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "/jobs_create/"+project_id+"/"+machine_set_id, //
                },
                columns: [
                    <x-data-table.column-script column-name="created_at"/>
                    <x-data-table.column-script column-name="ProductName">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="SystemName">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="EquipmentName">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="ScopeName">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="PMOrder">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="Remark">
                        orderable: false
                    </x-data-table.column-script>
                    <x-data-table.column-script column-name="action">
                        orderable: false
                    </x-data-table.column-script>
                ],
                "order":[[0,'desc'],[1,'asc'],[2,'asc'],[3,'asc']],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });

            $('#data_table_item').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/job_items/"+machine_set_id,
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'ProductName',
                        name: 'ProductName'
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
                ],
                "order":[[0,'asc'],[1,'asc'],[2,'asc'],[3,'asc'],[4,'asc']],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,

                drawCallback: function(){

                    $(document).on('click','.create_record', function(){
                        var id = $(this).attr('id');
                        $('#form_result').html('');
                        $.ajax({
                            url :"/job_items/"+id+"/create", //
                            dataType:"json",
                            success:function(data)
                            {
                                $('#item_id').val(data.result.id);
                                $('.modal-title').text('Add Job'); //
                                $('#action_button').val('Add');
                                $('#action').val('Add');
                                $('#formModal').modal('show');
                            }
                        })
                    });
                }
            });

            <x-data-table.submit-script name-i-d="" action-url="jobs">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="jobs">
                <x-data-table.edit-value-script name="p_m_order_id"/>
                <x-data-table.edit-value-script name="Remark"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="jobs"/>
        });
    </script>
@endsection
