@extends('adminlte::page')

@section('title', 'Tool')

@section('content_header')
    <h1 class="m-0 text-dark">Tool</h1>
@stop

@section('content')
    <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-data-table.default-data-table color="" collapse-card="collapsed-card" title="Check"
        collapse-button="plus" table-id="amount">
        <x-slot name="tool"></x-slot>
        <th>Job ID</th>
        <th>Location</th>
        <th>Product</th>
        <th>Machine</th>
        <th>System</th>
        <th>Equipment</th>
        <th>Scope</th>
        <th>Remark</th>
        <th>Amount</th>
    <x-slot name="othertable">
        </x-slot>
</x-data-table.default-data-table>

    <x-data-table.default-data-table color="" collapse-card="" title="Job"
        collapse-button="minus" table-id="">
        <x-slot name="tool"></x-slot>
        <th>Job ID</th>
        <th>Location</th>
        <th>Product</th>
        <th>Machine</th>
        <th>System</th>
        <th>Equipment</th>
        <th>Scope</th>
        <th>Remark</th>
        <th>Action</th>
        <x-slot name="othertable">
            </x-slot>
    </x-data-table.default-data-table>

    @php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใส่รายการ tool ใน item.pdf').'">การใส่รายการ Tool ใน Item</a>',null]
        ];
    @endphp
    <x-content.manual :tableData="$tabledata"></x-content.manual>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            var projectid = $('#project_id').attr('value');

            $('#amount').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "/tool_amounts/"+projectid,
                },
                columns: [
                    <x-data-table.column-script column-name="id"/>
                    <x-data-table.column-script column-name="LocationName"/>
                    <x-data-table.column-script column-name="ProductName"/>
                    <x-data-table.column-script column-name="MachineName"/>
                    <x-data-table.column-script column-name="SystemName"/>
                    <x-data-table.column-script column-name="EquipmentName"/>
                    <x-data-table.column-script column-name="ScopeName"/>
                    <x-data-table.column-script column-name="Remark"/>
                    <x-data-table.column-script column-name="CountOfCatagoryName"/>
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

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="id"/>
                <x-data-table.column-script column-name="LocationName"/>
                <x-data-table.column-script column-name="ProductName"/>
                <x-data-table.column-script column-name="MachineName"/>
                <x-data-table.column-script column-name="SystemName"/>
                <x-data-table.column-script column-name="EquipmentName"/>
                <x-data-table.column-script column-name="ScopeName"/>
                <x-data-table.column-script column-name="Remark">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc'],[2,'asc'],[3,'asc'],[4,'asc'],[5,'asc']</x-slot>
            </x-data-table.data-table-script>
        });
    </script>
@endsection
