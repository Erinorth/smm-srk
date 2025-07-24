@extends('adminlte::page')

@section('title', 'Job')

@section('content_header')
    <h1 class="m-0 text-dark">Jobs</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Menu" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <h6 class="text-center">Job</h6>
        <div class="container text-center">
            @role('planner|site_engineer|supervisor|admin|head_operation|head_engineering')
                <a class="btn btn-primary btn-sm" href="{{ URL('project_meetings/'.$project->id) }}">Meeting</a>
            @endrole
            @role('supervisor|admin|head_operation')
                <a class="btn btn-primary btn-sm" href="{{ URL('performance_employees/'.$project->id) }}">Team Performance</a>
                <a class="btn btn-primary btn-sm" href="{{ URL('performance_projects/'.$project->id) }}">Project Performance</a>
            @endrole
        </div>
        <br>
        <h6 class="text-center">Check & Print</h6>
        <div class="container text-center">
            <a href="{{ url('checkall/'.$project->id) }}" class="btn btn-secondary btn-sm">All Data</a>
            <a href="{{ url('worklist/'.$project->id) }}" class="btn btn-secondary btn-sm">Work List</a>
            <a href="{{ url('project_procedures/'.$project->id) }}" class="btn btn-secondary btn-sm">Procedure</a>
            <a href="{{ url('consumable/'.$project->id) }}" class="btn btn-secondary btn-sm">Consumable List</a>
            <a href="{{ url('sparepart/'.$project->id) }}" class="btn btn-secondary btn-sm">Spare Part List</a>
            <a href="{{ url('tool/'.$project->id) }}" class="btn btn-secondary btn-sm">Tool List</a>
            <a href="{{ url('MR_all/'.$project->id) }}" class="btn btn-secondary btn-sm">Maintenance Report</a>
            <a href="{{ url('performance_manhour/'.$project->id) }}" class="btn btn-secondary btn-sm">Man-Hour Report</a>
        </div>
        <br>
    </x-card.default-card>

    @if ( count($progressgdata) != 0 )
        <div class="row">
            <div class="col">
                <x-chart.progress collapse-card="" title="Progress"
                collapse-button="minus" chart-id="progress"/>
            </div>
        </div>
        @php
            $p = 1;
        @endphp
    @else
        @php
            $p = 0;
        @endphp
    @endif

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
@endsection

@section('js')
    <script>
        $(document).ready(function(){

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

            var p = "<?php echo $p ?>";

            if ( p != 0 ){
                var ctx = document.getElementById('progress').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                    labels:  {!!json_encode($progresschart->labels)!!} ,
                    datasets: [
                        {
                            label: 'Plan',
                            backgroundColor: {!! json_encode($progresschart->colours)!!},
                            data:  {!! json_encode($progresschart->plan)!!},
                            borderColor: {!! json_encode($progresschart->colours)!!},
                        },{
                            label: 'Actual',
                            data: {!! json_encode($progresschart->actual)!!},
                            borderColor: {!! json_encode($progresschart->colours2)!!},
                            backgroundColor: {!! json_encode($progresschart->colours2)!!},
                        },{
                            label: 'Sum Plan',
                            data: {!! json_encode($progresschart->csumplan)!!},
                            type: 'line',
                            borderColor: {!! json_encode($progresschart->colours3)!!},
                            backgroundColor: {!! json_encode($progresschart->colours5)!!},
                        },{
                            label: 'Sum Actual',
                            data: {!! json_encode($progresschart->csumactual)!!},
                            type: 'line',
                            borderColor: {!! json_encode($progresschart->colours4)!!},
                            backgroundColor: {!! json_encode($progresschart->colours5)!!},
                        }
                    ]},
                });
            }
        });
    </script>
@endsection
