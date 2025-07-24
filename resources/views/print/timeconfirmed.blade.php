@extends('layouts.print')

@section('title','Time Sheet')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td class="text-center align-middle" style="width:25%"><h4>Time Confirmed</h4></td>
            <td class="align-middle" style="width:32.5%"> Start Date : {{date('d-m-Y', strtotime($startdate))}}</td>
            <td class="align-middle" style="width:32.5%"> End Date : {{date('d-m-Y', strtotime($enddate))}}</td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center">Project</th>
                <th class="text-center">Normal</th>
                <th class="text-center">OT 1</th>
                <th class="text-center">OT 1.5</th>
                <th class="text-center">OT 2</th>
                <th class="text-center">OT 3</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timeconfirmed as $employee => $employee_list)
                <tr>
                    <th colspan="6"><b>+ {{ $employee }}</b></th>
                </tr>
                @foreach ($employee_list as $value)
                    <tr>
                        <td> {{$value->ProjectName }} </td>
                        <td class="text-center"> {{$value->Normal }} </td>
                        <td class="text-center"> {{$value->OT1 }} </td>
                        <td class="text-center"> {{$value->OT15 }} </td>
                        <td class="text-center"> {{$value->OT2 }} </td>
                        <td class="text-center"> {{$value->OT3 }} </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection