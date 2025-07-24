@extends('adminlte::page')

@section('title','Duration')

@section('content_header')
    <h1 class="m-0 text-dark">Duration</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-6">
            <x-widget.small-box title="Safety" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                theme="red" url="#" url-text="View details"/>
        </div>
        <div class="col-6">
            <x-widget.small-box title="Quality" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                theme="red" url="#" url-text="View details"/>
        </div>
        <div class="col-6">
            <x-widget.small-box title="Duration" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                theme="red" url="#" url-text="View details"/>
        </div>
        <div class="col-6">
            <x-widget.small-box title="Cost" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                theme="red" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="Incidence" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-car-crash"
                theme="red" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="Claim" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-coins"
                theme="primary" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="Complain" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-regular fa-comments"
                theme="green" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="Rework" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-rotate"
                theme="yellow" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="Duration" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-regular fa-clock"
                theme="secondary" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="TIFR" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-chart-line"
                theme="cyan" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="DI" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-chart-pie"
                theme="red" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="Total Loss" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-dumpster"
                theme="blue" url="#" url-text="View details"/>
        </div>
        <div class="col-4">
            <x-widget.small-box title="Law Assesment" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-scale-balanced"
                theme="cyan" url="#" url-text="View details"/>
        </div>
        <div class="col-6">
            <x-widget.small-box title="Medical Examination" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-solid fa-stethoscope"
                theme="secondary" url="#" url-text="View details"/>
        </div>
        <div class="col-6">
            <x-widget.small-box title="Occupational Disease" text="กฟนม-ธ. 0 / อบค. 0" icon="fa-brands fa-accessible-icon"
                theme="green" url="#" url-text="View details"/>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">Area Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                <div class="chart">
                    <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card card-danger">
                <div class="card-header">
                <h3 class="card-title">Donut Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- PIE CHART -->
            <div class="card card-danger">
                <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            </div>
            <!-- /.col (LEFT) -->
            <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
                <div class="card-header">
                <h3 class="card-title">Line Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                <div class="chart">
                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-success">
                <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- STACKED BAR CHART -->
            <div class="card card-success">
                <div class="card-header">
                <h3 class="card-title">Stacked Bar Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                <div class="chart">
                    <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Filter" collapse-button="plus">
        <x-slot name="tool"></x-slot>
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
        <br>
        <div class="row">
            <div class="col">
                <div class="container border rounded">
                    <div class="row">
                        <div class="col-2">
                            <h5>Job Position</h5>
                        </div>
                        <div class="col">

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
                            <h5>Craft</h5>
                        </div>
                        <div class="col">

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
                            <h5>Vehicle Type</h5>
                        </div>
                        <div class="col">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-card.default-card>

    <div class="row">
        <div class="col-6">
            <x-chart.half-card collapse-card="" title="Project Quantity" collapse-button="minus"
                chart-id="project"/>
        </div>
        <div class="col-6">
            <x-chart.half-card collapse-card="" title="Man Power" collapse-button="minus"
                chart-id=""/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-chart.half-card collapse-card="" title="Vehicle" collapse-button="minus"
                chart-id=""/>
        </div>
        <div class="col-6">
            <x-chart.half-card collapse-card="" title="PM Order" collapse-button="minus"
                chart-id=""/>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <x-chart.half-card collapse-card="" title="Consumable" collapse-button="minus"
                chart-id=""/>
        </div>
        <div class="col-6">
            <x-chart.half-card collapse-card="" title="Tool" collapse-button="minus"
                chart-id=""/>
        </div>
    </div>
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

            var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

            var areaChartData = {
            labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [
                {
                    label               : 'Digital Goods',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [28, 48, 40, 19, 86, 27, 90],
                    tension : 0.3,
                },
                {
                    label               : 'Electronics',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : [65, 59, 80, 81, 56, 55, 40],
                    tension : 0.3,
                },
            ]
            }

            var areaChartOptions = {
                    plugins: {
                        filler: {
                            drawTime: 'beforeDatasetsDraw'
                        }
                    },
                    maintainAspectRatio : false,
                    responsive : true,
                    legend: {
                        display: false
                    },
                    scales: {
                        x: {
                            gridLines : {
                                display : false,
                            }
                        },
                        y: {
                            gridLines : {
                                display : false,
                            }
                        }
                    }
                }

            // This will get the first returned node in the jQuery collection.
            new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
            })

            //-------------
            //- LINE CHART -
            //--------------
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChartOptions = $.extend(true, {}, areaChartOptions)
            var lineChartData = $.extend(true, {}, areaChartData)
            lineChartData.datasets[0].fill = false;
            lineChartData.datasets[1].fill = false;
            lineChartOptions.datasetFill = false

            var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
            })

            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData        = {
            labels: [
                'Chrome',
                'IE',
                'FireFox',
                'Safari',
                'Opera',
                'Navigator',
            ],
            datasets: [
                {
                data: [700,500,400,600,300,100],
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }
            ]
            }
            var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
            })

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData        = donutData;
            var pieOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
            })

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
                barChartData.datasets[0] = temp1
                barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
            var stackedBarChartData = $.extend(true, {}, barChartData)

            var stackedBarChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        });
    </script>
@endsection
