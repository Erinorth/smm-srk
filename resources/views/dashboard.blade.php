@extends('adminlte::page')

@section('title','Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="container-fluid">
        {{-- <div class="row">
            <div class="col">
                <x-adminlte-card title="Project Quantity" theme="primary" icon="" collapsible removable maximizable>
                    <x-adminlte-card title="Filter" theme="info" icon="" collapsible="collapsed" removable>
                        <div class="row">
                            <div class="col">
                                <div class="container border rounded">
                                    <div class="row">
                                        <div class="col-2">
                                            <h5>Date Range</h5>
                                        </div>
                                        <div class="col">
                                            <x-input.date title="Start" name-id="startdate"/>
                                        </div>
                                        <div class="col">
                                            <x-input.date title="End" name-id="enddate"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="container border rounded">
                                    <div class="row">
                                        <div class="col-2">
                                            <h5>Date Range Type</h5>
                                        </div>
                                        <div class="col">
                                            <div class="icheck-primary icheck-inline">
                                                <input type="radio" id="radioDay" name="show_type" value="1" checked/>
                                                <label for="radioDay">Day</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="radio" id="radioMonth" name="show_type" value="2"/>
                                                <label for="radioMonth">Month</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="radio" id="radioYear" name="show_type" value="3"/>
                                                <label for="radioYear">Year</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="container border rounded">
                                    <div class="row">
                                        <div class="col-2">
                                            <h5>Project Type</h5>
                                        </div>
                                        <div class="col">
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Hydro_in" name="project_type[]" value="1" checked/>
                                                <label for="Hydro_in">Hydro(In)</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Hydro_out" name="project_type[]" value="2" checked/>
                                                <label for="Hydro_out">Hydro(Out)</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Wind" name="project_type[]" value="3" checked/>
                                                <label for="Wind">Wind</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Crane" name="project_type[]" value="4" checked/>
                                                <label for="Crane">Crane</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Diver" name="project_type[]" value="5" checked/>
                                                <label for="Diver">Diver</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="GPT" name="project_type[]" value="6" checked/>
                                                <label for="GPT">GPT</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Travel17" name="project_type[]" value="7" checked/>
                                                <label for="Travel17">Travel17</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Purchasing" name="project_type[]" value="8" checked/>
                                                <label for="Purchasing">Purchasing</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Repairing" name="project_type[]" value="9" checked/>
                                                <label for="Repairing">Repairing</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Caribrating" name="project_type[]" value="10" checked/>
                                                <label for="Caribrating">Caribrating</label>
                                            </div>
                                            <div class="icheck-primary icheck-inline">
                                                <input type="checkbox" id="Travel16" name="project_type[]" value="11" checked/>
                                                <label for="Travel16">Travel16</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-adminlte-card>
                    <canvas id="project" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </x-adminlte-card>
            </div>
        </div> --}}
        @php

            if ( ISSET($expensive_tool->RangeCapacity) ) {
                $text_expensive_tool = $expensive_tool->CatagoryName.' / '.$expensive_tool->RangeCapacity;
            } else {
                $text_expensive_tool = $expensive_tool->CatagoryName;
            };
            if ( $expensive_tool->UF > 66 ) {
                $color_expensive = "green";
            } elseif ( $expensive_tool->UF > 33 ) {
                $color_expensive = "yellow";
            } else {
                $color_expensive = "red";
            }

            $text_pm = "ที่ยังเปิดอยู่ ".$pm_use." / ทั้งหมด ".$pm_all;
            if ( $pm_use/$pm_all > 0.66 ) {
                $color_pm = "red";
            } elseif ( $pm_use/$pm_all > 0.33 ) {
                $color_pm = "yellow";
            } else {
                $color_pm = "green";
            }
        @endphp
        <div class="row">
            <div class="col-6">
                <x-adminlte-small-box title="Safety" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                    theme="red" url="/dashboard_safety" url-text="View details"/>
            </div>
            {{-- <div class="col-6">
                <x-adminlte-small-box title="Quality" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                    theme="red" url="/dashboard_quality" url-text="View details"/>
            </div>
            <div class="col-6">
                <x-adminlte-small-box title="Duration" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                    theme="red" url="/dashboard_duration" url-text="View details"/>
            </div>
            <div class="col-6">
                <x-adminlte-small-box title="Cost" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                    theme="red" url="/dashboard_cost" url-text="View details"/>
            </div> --}}
            <div class="col-6">
                <x-adminlte-small-box title="Overtime" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-clock"
                    theme="red" url="/dashboard_overtime" url-text="View details"/>
            </div>
            {{-- <div class="col-6">
                <x-adminlte-small-box title="Utilization Factor" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                    theme="red" url="/dashboard_duration" url-text="View details"/>
            </div> --}}
            <div class="col-6">
                <x-adminlte-small-box title="Expensive Tool" :text="$text_expensive_tool" icon="fa-solid fa-tools"
                    :theme="$color_expensive" url="/dashboard_expensive_tool" url-text="View details"/>
            </div>
            <div class="col-6">
                <x-adminlte-small-box title="PM Order" :text="$text_pm" icon="fas fa-sort-numeric-down"
                    :theme="$color_pm" url="/pmorders/1/index" url-text="View details"/>
            </div>
        </div>
        {{-- @role('admin|head_operation|head_engineering')
            <div class="row">
                <div class="col">
                    <x-adminlte-card title="Safety and Health" theme="primary" collapsible="collapsed" removable maximizable>
                        <x-slot name="toolsSlot">
                            <x-adminlte-button class="btn-sm" theme="primary" icon="fa fa-lg fa-fw fa-plus-square" name-i-d="create_record_safety_health_control"/>
                        </x-slot>
                        <x-data-table.data-table name-i-d="_safety_health_control">
                            <th>Month</th>
                            <th>Target TIFR</th>
                            <th>Incident</th>
                            <th>Man</th>
                            <th>Day</th>
                            <th>Target DI</th>
                            <th>DI</th>
                            <th>Lost Day</th>
                            <th>Total Loss</th>
                            <th>Target Examination</th>
                            <th>Examination</th>
                            <th>Target Disease</th>
                            <th>Disease</th>
                            <th>Action</th>
                            <x-slot name="othertable">
                            </x-slot>
                        </x-data-table.data-table>
                    </x-adminlte-card>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-adminlte-card title="Quality" theme="primary" collapsible="collapsed" removable maximizable>
                        <x-slot name="toolsSlot">
                            <x-adminlte-button class="btn-sm" theme="success" icon="fa fa-lg fa-fw fa-plus-square" name-i-d="create_quality"/>
                        </x-slot>
                    </x-adminlte-card>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <x-adminlte-card title="PA" theme="primary" collapsible="collapsed" removable maximizable>
                        <x-slot name="toolsSlot">
                            <x-adminlte-button class="btn-sm" theme="success" icon="fa fa-lg fa-fw fa-plus-square" name-i-d="create_PA"/>
                        </x-slot>
                    </x-adminlte-card>
                </div>
            </div>
        @endrole --}}
    </div>

    <x-modal.input-form name-i-d="_safety_health_control" modal-title="Add Safety Health Control">
        @php
            $config = ['format' => 'YYYY-MM'];
        @endphp
        <x-adminlte-input-date name="Month" label="Month" :config="$config" placeholder="Choose a date...">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <x-adminlte-input name="T_TIFR" label="Target TIFR" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Incident" label="Incident" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Man" label="Man" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Day" label="Day" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="T_DI" label="Target DI" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="DI" label="DI" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="LossDay" label="Loss Day" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="T_TotalLoss" label="Target TotalLoss" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="TotalLoss" label="Total Loss" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="T_Examination" label="Target Examination" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Examination" label="Examination" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="T_Disease" label="Target Disease" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="Disease" label="Disease" placeholder="number" type="number">
            <x-slot name="appendSlot">
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-slot name="othervalue"></x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name="_safety_health_control"/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }

            var startdate = new Date();
                startdate.setDate(startdate.getDate() - 30);
                startdate = formatDate(startdate);

            var enddate = new Date();
                enddate.setDate(enddate.getDate() + 30);
                enddate = formatDate(enddate);

            var showtype = 1;

            var project_type = [1,2,3,4,5,6,7,8,9,10,11];

            var ctx = document.getElementById('project').getContext('2d');
            var chart = new Chart(ctx, {
                type: "line",
                data: {},
                options: {
                    scales: {
                        yAxes: {
                            ticks: {
                                min: 0
                            }
                        }
                    }
                }
            });

            ajax_request();

            function ajax_request(){
                $.ajax({
                    url: "/dashboard/project2",
                    type: 'POST',
                    dataType: 'json',
                    data:{'startdate':startdate, 'enddate':enddate, 'showtype':showtype, 'project_type':project_type},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        chart.data = {
                            labels: data.date,
                            datasets: [
                                {
                                    label: 'จำนวนงาน/วัน',
                                    data: data.count_project,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 1)',
                                    stepped: 'middle'
                                }
                            ]
                        };
                        chart.update();
                        console.log(data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            };

            $('#startdate').change(function(){
                startdate = $('#startdate').val();
                ajax_request();
            });

            $('#enddate').change(function(){
                enddate = $('#enddate').val();
                ajax_request();
            });

            $('input[type=radio][name="show_type"]').change(function() {
                showtype = $(this).val();
                ajax_request();
            });

            $('input[type=checkbox]').change(function(){
                project_type = [];
                $("input:checkbox:checked").each(function () {
                    project_type.push($(this).val());
                });
                ajax_request();
            });

            /* <x-data-table.data-table-script table-name="_safety_health_control" ajax-url="/safety_health_control">
                <x-data-table.column-script column-name="Month"/>
                <x-data-table.column-script column-name="T_TIFR"/>
                <x-data-table.column-script column-name="Incident"/>
                <x-data-table.column-script column-name="Man"/>
                <x-data-table.column-script column-name="Day"/>
                <x-data-table.column-script column-name="T_DI"/>
                <x-data-table.column-script column-name="DI"/>
                <x-data-table.column-script column-name="LossDay"/>
                <x-data-table.column-script column-name="TotalLoss"/>
                <x-data-table.column-script column-name="T_Examination"/>
                <x-data-table.column-script column-name="Examination"/>
                <x-data-table.column-script column-name="T_Disease"/>
                <x-data-table.column-script column-name="Disease"/>
                <x-data-table.column-script column-name="action">
                    orderable: false
                </x-data-table.column-script>
                <x-slot name="order">[1,'asc']</x-slot>
            </x-data-table.data-table-script>

            <x-data-table.create-script name-i-d="_safety_health_control" title="Add New Employee"/>

            <x-data-table.submit-script name-i-d="_safety_health_control" action-url="safety_health_control">
                <x-data-table.ajax-reload-script table-id=""/>
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name="_safety_health_control"  edit-url="safety_health_control">
                <x-data-table.edit-value-script name="Month"/>
                <x-data-table.edit-value-script name="T_TIFR"/>
                <x-data-table.edit-value-script name="Incident"/>
                <x-data-table.edit-value-script name="Man"/>
                <x-data-table.edit-value-script name="Day"/>
                <x-data-table.edit-value-script name="T_DI"/>
                <x-data-table.edit-value-script name="DI"/>
                <x-data-table.edit-value-script name="LossDay"/>
                <x-data-table.edit-value-script name="TotalLoss"/>
                <x-data-table.edit-value-script name="T_Examination"/>
                <x-data-table.edit-value-script name="Examination"/>
                <x-data-table.edit-value-script name="T_Disease"/>
                <x-data-table.edit-value-script name="Disease"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="_safety_health_control" url="safety_health_control"/> */
        });
    </script>
@endsection
