@extends('layouts.print')

@section('title','Maintenance Report')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Maintenance Report</h4></td>
            <td colspan="2"> Project : {{ $project->ProjectName }} </td>
        </tr>
        <tr>
            <td> Start Date : {{date('d-m-Y', strtotime($project->StartDate))}}</td>
            <td> Finish Date : {{date('d-m-Y', strtotime($project->FinishDate))}}</td>
        </tr>
    </table>

    <table class="table table-bordered table-sm">
        @php
            $i = 1;
        @endphp
        @foreach ($report as $value)
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Crane Type</th>
                <th class="text-center">Crane Detail</th>
                <th class="text-center">Serial Number</th>
                <th class="text-center">Test Date</th>
            </tr>
            <tr>
                <td class="text-center">{{ $i }}</td>
                <td class="text-center">{{ $value->MachineName }}</td>
                <td>{{ $value->Remark }}</td>
                <td class="text-center">{{ $value->SerialNumber }}</td>
                <td class="text-center">{{ $value->TestDate }}</td>
            </tr>
            <tr>
                <td colspan="5"> <b>Result</b> <br> {!! nl2br($value->Result) !!}</td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
    </table>

    <table class="table table-borderless table-sm">
        <tr>
            <td></td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br><br>
                (....................................................)<br>
                Area Manager/ผู้ควบคุมงาน
            </td>
        </tr>
    </table>
@endsection
