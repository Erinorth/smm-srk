@extends('layouts.printl')

@section('title','Maintenance Report')

@section('content')
    <table class="table table-bordered table-sm">
        @foreach ($job as $value)
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Maintenance Report</h4></td>
            <td style="width:32.5%"> Project : {{ $value->ProjectName }} </td>
            <td style="width:32.5%"> Location : {{ $value->LocationName }} </td>
        </tr>
        <tr>
            <td> Start Date : {{date('d-m-Y', strtotime($value->StartDate))}}</td>
            <td> Finish Date : {{date('d-m-Y', strtotime($value->FinishDate))}}</td>
        </tr>
        <tr>
            <td colspan="2"> Product : {{$value->ProductName}}</td>
            <td>Machine : 
                @if ( $value->Remark == "" )
                    {{$value->MachineName}}
                @else
                    {{$value->MachineName}}//{{$value->Remark}}
                @endif
            </td>
            <td>System : {{$value->SystemName}}</td>
        </tr>
        <tr>
            <td colspan="2"> Equipment : {{$value->SpecificName}}</td>
            <td colspan="2">Scope of Work : {{$value->ScopeName}}</td>
        </tr>
        @endforeach
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td class="text-center">Done</td>
                <td class="text-center">Activity</td>
                <td class="text-center">Detail</td>
                <td class="text-center">Condition</td>
                <td class="text-center">Countermeasure</td>
                <td class="text-center">Remark</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $value)
                <tr>
                    <td class="text-center">
                        @if ( $value->Done == "Yes")
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td>{{$value->ActivityName }} </td>
                    <td>{{$value->Detail }} </td>
                    <td>{!! nl2br($value->Condition) !!}</td>
                    <td>{!! nl2br($value->Countermeasure) !!}</td>
                    <td>{{$value->Remark}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br><br>
                (....................................................)<br>
                Foreman
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br><br>
                (....................................................)<br>
                Area Manager
            </td>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br><br>
                (....................................................)<br>
                Inspector
            </td>
        </tr>
    </table>
@endsection
