@extends('adminlte::page')

@section('title', 'Job')

@section('content_header')
    <h1 class="m-0 text-dark">Job</h1>
@stop

@section('content')
    <x-header.job jobId="{{$job->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.job>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Menu" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <h4 class="text-center">Risk Assessment</h4>
        <div class="container text-center">
            <a class="btnprn btn btn-primary btn-sm" href="{{url('risk/'.$job->id)}}">Safety & Health Assessment</a>
            <!--<a class="btnprn btn btn-primary btn-sm" href="{{url('riskquality/'.$job->id)}}">Quality Assessment</a>
            <a class="btnprn btn btn-primary btn-sm" href="{{url('QSH_manuals')}}">Manual</a>-->
        </div>
        <br>
        <h4 class="text-center">Maintenance Report</h4>
        <div class="container text-center">
            @foreach ($item as $value)
                <a class="btnprn btn btn-secondary btn-sm" href="{{url('history/'.$value->item_id.'/'.$value->product_id.'/'.$value->location_id.'/'.$value->machine_id.'/'.$value->system_id.'/'.$value->equipment_id)}}">History Record</a>
            @endforeach
            @role('supervisor|foreman|head_operation|admin')
                <a class="btn btn-primary btn-sm" href="{{url('maintenance_reports/'.$job->id)}}">Insert Data</a>
            @endrole
            <a class="btnprn btn btn-secondary btn-sm" href="{{url('MR/'.$job->id)}}">Print</a>
        </div>
    </x-card.default-card>

    @if ( count($progressgdata) != 0 OR count($manhourdata) != 0 )
        @if ( count($progressgdata) == 0 AND count($manhourdata) != 0)
            <div class="row">
                <div class="col">
                    <x-chart.man-hour collapse-card="" title="Man-Hour"
                    collapse-button="minus" chart-id="manhour"/>
                </div>
            </div>
            @php
                $p = 0;
                $m = 1;
            @endphp
        @elseif ( count($progressgdata) != 0 AND count($manhourdata) == 0 )
            <div class="row">
                <div class="col">
                    <x-chart.progress collapse-card="" title="Progress"
                    collapse-button="minus" chart-id="progress"/>
                </div>
            </div>
            @php
                $p = 1;
                $m = 0;
            @endphp
        @else
            <div class="row">
                <div class="col-6">
                    <x-chart.progress collapse-card="" title="Progress"
                    collapse-button="minus" chart-id="progress"/>
                </div>
                <div class="col-6">
                    <x-chart.man-hour collapse-card="" title="Man-Hour"
                    collapse-button="minus" chart-id="manhour"/>
                </div>
            </div>
            @php
                $p = 1;
                $m = 1;
            @endphp
        @endif
    @else
        @php
            $p = 0;
            $m = 0;
        @endphp
    @endif

    <x-card.default-card color="" collapse-card="" title="Activity" collapse-button="minus">
        <x-slot name="tool"></x-slot>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center">Activity</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activity as $value)
                    <tr>
                        <td class="text-center">{{ $value->ActivityName }}</td>
                        <td class="text-center">{{ $value->Detail }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="text-center">
            @role('supervisor|foreman|head_operation|admin')
                <x-button.menu color="primary" :url="url('item_consumables/'.$job->item_id)" name="Consumable"/>
                <x-button.menu color="primary" :url="url('item_hazards/'.$job->item_id)" name="Hazard"/>
                <x-button.menu color="primary" :url="url('safetytags/'.$job->item_id)" name="Safety Tag"/>
                <x-button.menu color="primary" :url="url('specialtools/'.$job->item_id)" name="Special Tool"/>
                <x-button.menu color="primary" :url="url('item_tool_catagories/'.$job->item_id)" name="Tool"/>
                {{-- <x-button.menu color="primary" :url="url('workprocedures/'.$job->item_id)" name="Work Procedure"/> --}}
                <x-button.menu color="primary" :url="url('workprocedures2/'.$job->item_id)" name="Work Procedure"/>
            @endrole
            @role('site_engineer|admin')
                <x-button.menu color="primary" :url="url('item_activities/'.$job->item_id)" name="Activity"/>
                <x-button.menu color="primary" :url="url('documents/'.$job->item_id)" name="Document"/>
                <x-button.menu color="primary" :url="url('qualitycontrols/'.$job->item_id)" name="Quality Control"/>
                <x-button.menu color="primary" :url="url('item_spareparts/'.$job->item_id)" name="Spare Part"/>
            @endrole
            {{-- <x-button.menu color="info" :url="url('checklist/'.$job->id)" name="Check List"/>
            <x-button.menu color="info" :url="url('checklist2/'.$job->id)" name="Check List2"/> --}}
            <x-button.menu color="info" :url="url('checklist3/'.$job->id)" name="Check List"/>
            {{-- <x-button.menu color="info" :url="url('checklist4/'.$job->id)" name="Check List4"/> --}}
        </div>
    </x-card.default-card>

    <x-modal.input-form name-i-d="" modal-title="Create Date">
        <x-input.date title="Date" name-id="Date"/>

        <x-input.text title="Plan" name-id="Plan"/>

        <x-input.text title="Actual" name-id="Actual"/>

        <x-slot name="othervalue">
            <input type="hidden" name="job_id" id="job_id" value="{{$job->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.data-table-script table-name="" ajax-url="">
                <x-data-table.column-script column-name="Date"/>
                <x-data-table.column-script column-name="Plan">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="Actual">
                    orderable: false
                </x-data-table.column-script>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[0,'desc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="" title="Add Date"/>

            <x-data-table.submit-script name-i-d="" action-url="{{ url('/job_dates') }}">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/job_dates') }}">
                <x-data-table.edit-value-script name="Date"/>
                <x-data-table.edit-value-script name="Plan"/>
                <x-data-table.edit-value-script name="Actual"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="{{ url('/job_dates') }}"/>

            var p = "<?php echo $p ?>";
            var m = "<?php echo $m ?>";

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

            if ( m != 0 ){
                var ctx = document.getElementById('manhour').getContext('2d');
                var mixedChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                    labels:  {!!json_encode($manhourchart->labels)!!} ,
                    datasets: [
                        {
                            label: 'Man Hour',
                            backgroundColor: {!! json_encode($manhourchart->colours)!!},
                            data:  {!! json_encode($manhourchart->manhour)!!},
                            borderColor: {!! json_encode($manhourchart->colours)!!},
                        },{
                            label: 'Plan M-H',
                            data: {!! json_encode($manhourchart->plan)!!},
                            type: 'line',
                            borderColor: ['rgba(54, 162, 235, 1)'],
                            backgroundColor: ['rgba(0, 0, 0, 0)'],
                        },{
                            label: 'Running Sum',
                            data: {!! json_encode($manhourchart->csum)!!},
                            type: 'line',
                            borderColor: ['rgba(255, 206, 86, 1)'],
                            backgroundColor: ['rgba(0, 0, 0, 0)'],
                        }
                    ]},
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {if (value % 1 === 0) {return value;}}
                                },
                                scaleLabel: {
                                    display: false
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                // This more specific font property overrides the global property
                                fontColor: '#122C4B',
                                fontFamily: "'Muli', sans-serif",
                                padding: 25,
                                boxWidth: 25,
                                fontSize: 14,
                            }
                        },
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: 0,
                                bottom: 10
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
