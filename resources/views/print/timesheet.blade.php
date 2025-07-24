@extends('layouts.print')

@section('title','Time Sheet')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Time Sheet</h4></td>
            <td colspan="2"> Project : {{ $project->ProjectName }} </td>
        </tr>
        <tr>
            <td style="width:32.5%"> Start Date : {{date('d-m-Y', strtotime($project->StartDate))}}</td>
            <td style="width:32.5%"> Finish Date : {{date('d-m-Y', strtotime($project->FinishDate))}}</td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center">PM Order</th>
                <th class="text-center">PM Order Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pmorder as $value)
                <tr>
                    <td class="text-center">{{ $value->PMOrder }}</td>
                    <td>{{ $value->PMOrderName }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">PM Order</th>
                <th class="text-center">Craft</th>
                <th class="text-center">Normal</th>
                <th class="text-center">OT From</th>
                <th class="text-center">OT To</th>
                <th class="text-center">OT 1</th>
                <th class="text-center">OT 1.5</th>
                <th class="text-center">OT 2</th>
                <th class="text-center">OT 3</th>
                <th class="text-center">Remark</th>
            </tr>
        </thead>
        <tbody>
            @php
                $date = '';
                $pmorder = '';
                $craft = '';
            @endphp
            @foreach ($timesheet as $employee => $employee_list)
                <tr>
                    <th colspan="11"><b>+ {{ $employee }}</b></th>
                </tr>
                @foreach ($employee_list as $value)
                    <tr>
                        @if ( $value->WorkingDateCode <> $date )
                            <td rowspan="{{$value->CountOfWorkingDate}}" class="text-center"> {{$value->WorkingDate }} </td>
                            @php
                                $date = $value->WorkingDateCode;
                            @endphp
                        @endif
                        @if ( $value->PMOrderCode <> $pmorder )
                            <td rowspan="{{$value->CountOfPMOrder}}" class="text-center"> {{$value->PMOrder }} </td>
                            @php
                                $pmorder = $value->PMOrderCode;
                            @endphp
                        @endif
                        @if ( $value->CraftNameCode <> $craft )
                            <td rowspan="{{$value->CountOfCraftName}}" class="text-center"> {{$value->CraftName }} </td>
                            @php
                                $craft = $value->CraftNameCode;
                            @endphp
                        @endif
                        <td class="text-center"> {{number_format($value->Normal,1)}} </td>
                        <td class="text-center"> {{$value->OTfrom}} </td>
                        <td class="text-center"> {{$value->OTto}} </td>
                        <td class="text-center"> {{number_format($value->OT1,1)}} </td>
                        <td class="text-center"> {{number_format($value->OT15,1)}} </td>
                        <td class="text-center"> {{number_format($value->OT2,1)}} </td>
                        <td class="text-center"> {{number_format($value->OT3,1)}} </td>
                        <td> {{$value->Remark }} </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br><br>
                (....................................................)<br>
                ผู้จัดทำ
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br><br>
                (....................................................)<br>
                ผู้ควบคุมงาน/ผู้ตรวจสอบงาน
            </td>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br><br>
                (....................................................)<br>
                หัวหน้าแผนกที่ควบคุมงาน/ผู้รับรอง
            </td>
        </tr>
    </table>
@endsection
