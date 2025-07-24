@extends('layouts.printl')

@section('title','WFHWFA')

@section('content')
    <table class="table table-bordered table-sm">
        @foreach ($week as $value)
            <tr>
                <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
                <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>WFH/WFA Plan</h4></td>
                <td> ID : {{ $value->WorkID }} </td>
                <td> Name : {{ $value->ThaiName }} </td>
            </tr>
            <tr>
                <td style="width:32.5%"> Start Date : {{date('d-m-Y', strtotime($value->StartOfWeek))}}</td>
                <td style="width:32.5%"> Finish Date : {{date('d-m-Y', strtotime($value->EndOfWeek))}}</td>
            </tr>
        @endforeach
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center">งานที่ได้รับมอบหมาย</th>
                <th class="text-center">ตัวชี้วัด//คะแนน</th>
                <th class="text-center">รายละเอียด</th>
                <th class="text-center">คะแนนรวม</th>
                <th class="text-center">ผู้มอบหมายงาน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $value)
                <tr>
                    <td> {{$value->RoutineJobName }} </td>
                    <td> {{$value->KPI }} // {{$value->Point }} </td>
                    <td> {!! nl2br($value->Detail) !!} </td>
                    <td class="text-center"> {{$value->TargetPoint }} </td>
                    <td class="text-center"> {{$value->Assignor }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection