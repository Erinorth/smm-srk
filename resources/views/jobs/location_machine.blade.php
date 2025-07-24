@extends('adminlte::page')

@section('title','Job')

@section('content_header')
    <h1 class="m-0 text-dark">Job</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="" title="Location / Machine"
        collapse-button="minus" table-id="">
        <x-slot name="tool">
        </x-slot>
        <th>Location Name</th>
        <th>Machine Name</th>
        <th>Action</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Selected"
        collapse-button="plus" table-id="_selected_data_table">
        <x-slot name="tool">
        </x-slot>
        <th>ID</th>
        <th>Location Name</th>
        <th>Machine Name</th>
        <th>Product Name</th>
        <th>System Name</th>
        <th>Equipment Name</th>
        <th>Scope Name</th>
        <th>PM Order</th>
        <th>Remark</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    <div class="form-group text-center">
        <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
    </div>

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

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="LocationName"/>
                <x-data-table.column-script column-name="MachineName"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'asc'],[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            var project_id = $('#project_id').attr('value');
            $('#data_table_selected_data_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/jobs_location_machine_select/"+project_id, //
                },
                columns: [
                    <x-data-table.column-script column-name="id"/>
                    <x-data-table.column-script column-name="LocationName"/>
                    <x-data-table.column-script column-name="MachineName"/>
                    <x-data-table.column-script column-name="ProductName"/>
                    <x-data-table.column-script column-name="SystemName"/>
                    <x-data-table.column-script column-name="EquipmentName"/>
                    <x-data-table.column-script column-name="ScopeName"/>
                    <x-data-table.column-script column-name="PMOrder"/>
                    <x-data-table.column-script column-name="Remark"/>
                ],
                "order":[[1,'asc'],[2,'asc'],[3,'asc'],[4,'asc'],[5,'asc']],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>
@endsection
