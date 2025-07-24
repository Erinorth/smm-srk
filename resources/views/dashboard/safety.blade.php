@extends('adminlte::page')

@section('title','Safety')

@section('content_header')
    <h1 class="m-0 text-dark">Safety</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <x-adminlte-card title="Filter" theme="info" icon="" collapsible="collapsed" removable maximizable>
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
                                            <input type="radio" id="radioMonth" name="show_type" value="1" checked/>
                                            <label for="radioMonth">Month</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" id="radioYear" name="show_type" value="2"/>
                                            <label for="radioYear">Year</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-adminlte-card>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-chart.dashboard title-name="จำนวนอุบัติเหตุ" theme-name="primary" i-d-name="accident"/>
            </div>
            <div class="col-md-6">
                <x-chart.dashboard title-name="อัตราความถี่ของอุบัติเหตุ" theme-name="primary" i-d-name="tifr"/>
            </div>
            <div class="col-md-6">
                <x-chart.dashboard title-name="ดัชนีการประสบอันตราย" theme-name="primary" i-d-name="di"/>
            </div>
            <div class="col-md-6">
                <x-chart.dashboard title-name="ความสูญเสียทั้งหมด (Total Loss)" theme-name="primary" i-d-name="totalloss"/>
            </div>
            <div class="col-md-6">
                <x-chart.dashboard title-name="การตรวจสุขภาพประจำปี" theme-name="primary" i-d-name="checkup"/>
            </div>
            <div class="col-md-6">
                <x-chart.dashboard title-name="การเจ็บป่วยจากการทำงาน" theme-name="primary" i-d-name="illness"/>
            </div>
            <div class="col-md-6">
                <x-chart.dashboard title-name="สภาพแวดล้อมในการทำงาน" theme-name="primary" i-d-name="environment"/>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            function startYear(date) {
                var d = new Date(date),
                    month = '' + 1,
                    day = '' + 1,
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }

            function endYear(date) {
                var d = new Date(date),
                    month = 12,
                    day = 31,
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }

            var startdate = new Date();
                startdate = startYear(startdate);

            var enddate = new Date();
                enddate = endYear(enddate);

            var showtype = 1;

                console.log(startdate);
                console.log(enddate);

            <x-j-s.dashboard-chart-filter chart-name="accident">
                scales: {
                    xAxes: {
                        ticks: {
                            min: 0
                        },
                        stacked: true
                    },
                    yAxes: {
                        ticks: {
                            min: 0
                        },
                        stacked: true,
                        beginAtZero: true
                    }
                }
            </x-j-s.dashboard-chart-filter>

            <x-j-s.dashboard-chart chart-name="accident">
                labels: data.month_accident,
                datasets: [
                {
                    label: 'คน (กฟนม-ธ.)',
                    data: data.IncidentMan,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    stack: 1,
                },{
                    label: 'สิ่งของ (กฟนม-ธ.)',
                    data: data.IncidentObj,
                    borderColor: 'rgba(1, 192, 1, 1)',
                    backgroundColor: 'rgba(1, 192, 1, 1)',
                    stack: 1,
                },{
                    label: 'อบค.',
                    data: data.IncidentDiv,
                    borderColor: 'rgba(75, 1, 192, 1)',
                    backgroundColor: 'rgba(75, 1, 192, 1)',
                    stack: 2,
                },{
                    type: 'line',
                    label: 'สะสม กฟนม-ธ.',
                    data: data.cumulative_hydro,
                    borderColor: 'rgba(75, 192, 1, 1)',
                    backgroundColor: 'rgba(75, 192, 1, 1)',
                    stack: 3,
                },{
                    type: 'line',
                    label: 'สะสม อบค.',
                    data: data.cumulative_div,
                    borderColor: 'rgba(1, 1, 192, 1)',
                    backgroundColor: 'rgba(1, 1, 192, 1)',
                    stack: 4,
                },{
                    type: 'line',
                    label: 'เป้าหมาย กฟนม-ธ.',
                    data: data.count_accident,
                    borderColor: 'rgba(75, 1, 1, 1)',
                    backgroundColor: 'rgba(75, 1, 1, 1)',
                    stack: 5,
                }]
            </x-j-s.dashboard-chart>

            /* <x-j-s.dashboard-chart chart-name="tifr">
                labels: data.month_tifr,
                datasets: [
                {
                    type: 'bar',
                    label: 'TIFR',
                    data: data.count_tifr,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                }]
            </x-j-s.dashboard-chart>

            <x-j-s.dashboard-chart chart-name="di">
                labels: data.month_di,
                datasets: [
                {
                    type: 'line',
                    label: 'DI',
                    data: data.count_di,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                }]
            </x-j-s.dashboard-chart>

            <x-j-s.dashboard-chart chart-name="totalloss">
                labels: data.month_di,
                datasets: [
                {
                    type: 'line',
                    label: 'DI',
                    data: data.count_di,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                }]
            </x-j-s.dashboard-chart>

            <x-j-s.dashboard-chart chart-name="checkup">
                labels: data.month_di,
                datasets: [
                {
                    type: 'line',
                    label: 'DI',
                    data: data.count_di,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                }]
            </x-j-s.dashboard-chart>

            <x-j-s.dashboard-chart chart-name="illness">
                labels: data.month_di,
                datasets: [
                {
                    type: 'line',
                    label: 'DI',
                    data: data.count_di,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                }]
            </x-j-s.dashboard-chart>

            <x-j-s.dashboard-chart chart-name="environment">
                labels: data.month_di,
                datasets: [
                {
                    type: 'line',
                    label: 'DI',
                    data: data.count_di,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                }]
            </x-j-s.dashboard-chart> */

            $('#startdate').change(function(){
                startdate = $('#startdate').val();
                ajax_request_accident();
            });

            $('#enddate').change(function(){
                enddate = $('#enddate').val();
                ajax_request_accident();
            });

            $('input[type=radio][name="show_type"]').change(function() {
                showtype = $(this).val();
                ajax_request_accident();
            });
        });
    </script>
@endsection
