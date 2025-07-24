@extends('layouts.printl')

@section('title','History Record')

@section('content')
    <table class="table table-bordered table-sm">
        @foreach ($item as $value)
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>History Record</h4></td>
            <td style="width:32.5%"> Product : {{$value->ProductName}} </td>
            <td style="width:32.5%"> Location : {{ $value->LocationName }} </td>
        </tr>
        <tr>
            <td>Machine : 
                @if ( $value->Remark == "" )
                    {{$value->MachineName}}
                @else
                    {{$value->MachineName}}//{{$value->Remark}}
                @endif
            </td>
            <td> System : {{$value->SystemName}}</td>
        </tr>
        <tr>
            <td colspan="4"> Equipment : {{$value->SpecificName}}</td>
        </tr>
        @endforeach
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td class="text-center">Project Name</td>
                <td class="text-center">Start Date</td>
                <td class="text-center">Finish Date</td>
                <td class="text-center">Scope of Work</td>
                <td class="text-center">Activity</td>
                <td class="text-center">Done</td>
                <td class="text-center">Condition</td>
                <td class="text-center">Countermeasure</td>
                <td class="text-center">Remark</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($history as $value)
                <tr>
                    <td>{{$value->ProjectName}}</td>
                    <td class="text-center">{{date('d-m-Y', strtotime($value->StartDate))}}</td>
                    <td class="text-center">{{date('d-m-Y', strtotime($value->FinishDate))}}</td>
                    <td class="text-center">{{$value->ScopeName}}</td>
                    <td>
                        @if ( $value->ActivityName == NULL )
                            <div class="text-center">N/A</div>
                        @else
                            {{$value->ActivityName}}
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->ActivityName == NULL )
                            N/A
                        @else
                            {{$value->Done}}
                        @endif
                    </td>
                    <td>{{$value->Condition}}</td>
                    <td>{{$value->Countermeasure}}</td>
                    <td>{{$value->Remark}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
