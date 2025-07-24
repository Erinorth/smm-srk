@extends('adminlte::page')

@section('title', 'Risk Schedule')

@section('content_header')
    <h1 class="m-0 text-dark">Risk Schedule</h1>
@stop

@section('content')
    <x-card.default-card color="" collapse-card="" title="Risk Schedule" collapse-button="minus">
        <x-slot name="tool"></x-slot>
        <div class="container">
            <div id="calendar"></div>
        </div>
    </x-card.default-card>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Yesterday" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <table class="table table-striped table-bordered table-sm display">
            <thead>
                <tr>
                    <th class="text-center align-middle">Project Name</th>
                    <th class="text-center align-middle">กิจกรรม</th>
                    <th class="text-center align-middle">ลักษณะความเสี่ยง</th>
                    <th class="text-center align-middle">ผลกระทบ</th>
                    <th class="text-center align-middle">มาตรการควบคุม</th>
                </tr>
            </thead>
            <tbody>
                @foreach($yesterday as $value)
                    <tr>
                        <td>{{$value->ProjectName }}</td>
                        <td>{{$value->Activity}}</td>
                        <td>{{$value->TypeOfRisk}}</td>
                        <td>{{$value->Effect}}</td>
                        <td>{{$value->CounterMeasure}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card.default-card>

    <x-card.default-card color="" collapse-card="" title="Today : {{NOW()}}" collapse-button="minus">
        <x-slot name="tool"></x-slot>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Project Name</th>
                    <th class="text-center align-middle">กิจกรรม</th>
                    <th class="text-center align-middle">ลักษณะความเสี่ยง</th>
                    <th class="text-center align-middle">ผลกระทบ</th>
                    <th class="text-center align-middle">มาตรการควบคุม</th>
                </tr>
            </thead>
            <tbody>
                @foreach($today as $value)
                    <tr>
                        <td>{{$value->ProjectName }}</td>
                        <td>{{$value->Activity}}</td>
                        <td>{{$value->TypeOfRisk}}</td>
                        <td>{{$value->Effect}}</td>
                        <td>{{$value->CounterMeasure}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card.default-card>

    <x-card.default-card color="" collapse-card="collapsed-card" title="Tomorrow" collapse-button="plus">
        <x-slot name="tool"></x-slot>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Project Name</th>
                    <th class="text-center align-middle">กิจกรรม</th>
                    <th class="text-center align-middle">ลักษณะความเสี่ยง</th>
                    <th class="text-center align-middle">ผลกระทบ</th>
                    <th class="text-center align-middle">มาตรการควบคุม</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tomorrow as $value)
                    <tr>
                        <td>{{$value->ProjectName }}</td>
                        <td>{{$value->Activity}}</td>
                        <td>{{$value->TypeOfRisk}}</td>
                        <td>{{$value->Effect}}</td>
                        <td>{{$value->CounterMeasure}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card.default-card>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            var calendar = $('#calendar').fullCalendar({
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                header:{
                    left:'prev,next',
                    center:'title',
                    right:'today'
                },
                events:'/QSH_schedules',
                eventAfterRender: function(event, element) {
                    $(element).tooltip({
                        title: event.description,
                        container: "body"
                    });
                }
            });
        });
    </script>
@endsection
