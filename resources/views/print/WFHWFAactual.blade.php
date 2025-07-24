@extends('layouts.printl')

@section('title','WFHWFA')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>WFH/WFA Report</h4></td>
            <td colspan="2"> Start Date : {{date('d-m-Y', strtotime($week->StartOfWeek))}} </td>
            <td colspan="2"> Finish Date : {{date('d-m-Y', strtotime($week->EndOfWeek))}} </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center">งานที่มอบหมาย/งานที่ได้รับมอบหมาย</th>
                <th class="text-center">ตัวชี้วัด // คะแนนต่อตัวชี้วัด</th>
                <th class="text-center">รายละเอียดงาน</th>
                <th class="text-center">คะแนนเป้าหมาย</th>
                <th class="text-center">คะแนนที่ได้</th>
                <th class="text-center">ผู้มอบหมายงาน/ผู้รับมอบหมายงาน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $job => $job_list)
                <tr>
                    <th colspan="6"><b>+ {{ $job }}</b></th>
                </tr>
                @foreach ($job_list as $value)
                    <tr>
                        @if ( $value->RoutineJobName == Null)
                            <td class="text-center"> ไม่มีงานที่ได้รับมอบหมาย </td>
                        @else
                            <td> {{$value->RoutineJobName }} </td>
                        @endif
                        @if ( $value->KPI == Null)
                            <td class="text-center"> N/A </td>
                        @else
                            <td> {{$value->KPI }} // {{$value->Point }} </td>
                        @endif
                        @if ( $value->Detail == Null)
                            <td class="text-center"> N/A </td>
                        @else
                            <td> {!! nl2br($value->Detail) !!} </td>
                        @endif
                        @if ( $value->TargetPoint == Null)
                            <td class="text-center"> N/A </td>
                        @else
                            <td class="text-center"> {{$value->TargetPoint }} </td>
                        @endif
                        @if ( $value->AcceptPoint == Null)
                            <td class="text-center"> N/A </td>
                        @else
                            <td class="text-center"> {{$value->AcceptPoint }} </td>
                        @endif
                        @if ( $value->Assignor == Null)
                            <td class="text-center"> N/A </td>
                        @else
                            <td class="text-center"> {{$value->Assignor }} </td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection