@extends('layouts.print')

@section('title','Performance Report')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Performance Report</h4></td>
            <td colspan="2"> Project : {{ $project->ProjectName }} </td>
        </tr>
        <tr>
            <td style="width:32.5%"> Start Date : {{date('d-m-Y', strtotime($project->StartDate))}}</td>
            <td style="width:32.5%"> Finish Date : {{date('d-m-Y', strtotime($project->FinishDate))}}</td>
        </tr>
    </table>

    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Job Position</th>
                            <th class="text-center">Craft</th>
                            <th class="text-center">Normal</th>
                            <th class="text-center">OT 1</th>
                            <th class="text-center">OT 1.5</th>
                            <th class="text-center">OT 2</th>
                            <th class="text-center">OT 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($manhourx as $value)
                            <tr>
                                <td>{{ $value->JobPositionName }}</td>
                                <td class="text-center">{{ $value->CraftName }}</td>
                                <td class="text-center">{{ number_format($value->SumOfNormal,2) }}</td>
                                <td class="text-center">{{ number_format($value->SumOfOT1,2) }}</td>
                                <td class="text-center">{{ number_format($value->SumOfOT15,2) }}</td>
                                <td class="text-center">{{ number_format($value->SumOfOT2,2) }}</td>
                                <td class="text-center">{{ number_format($value->SumOfOT3,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center">Sum</td>
                            <td class="text-center">@foreach($allmanhour as $value){{ number_format($value->All,2) }}@endforeach</td>
                            @foreach ($summanhourx as $value)
                                <td class="text-center">{{ number_format($value->SumOfNormal,2) }}</td>
                                <td class="text-center">{{ number_format($value->SumOfOT1,2) }}</td>
                                <td class="text-center">{{ number_format($value->SumOfOT15,2) }}</td>
                                <td class="text-center">{{ number_format($value->SumOfOT2,2) }}</td>
                                <td class="text-center">{{ number_format($value->SumOfOT3,2) }}</td>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h6>Work</h6>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Job ID</th>
                            <th class="text-center">Plan</th>
                            <th class="text-center">AVG</th>
                            <th class="text-center">Actual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($work as $value)
                            <tr>
                                <td class="text-center">{{ $value->id }}</td>
                                <td class="text-center">{{ number_format($value->Plan,2) }}</td>
                                <td class="text-center">{{ number_format($value->AvgOfPastManHour,2) }}</td>
                                <td class="text-center">{{ number_format($value->ActualWork,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <h6>Support</h6>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Job ID</th>
                                    <th class="text-center">Actual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($support as $value)
                                    <tr>
                                        <td class="text-center">{{ $value->id }}</td>
                                        <td class="text-center">{{ number_format($value->Support,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6>Waiting/Idle</h6>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Job ID</th>
                                    <th class="text-center">Actual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($waiting as $value)
                                    <tr>
                                        <td class="text-center">{{ $value->id }}</td>
                                        <td class="text-center">{{ number_format($value->Waiting,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h6>ตารางปันส่วน</h6>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">หมายเลขประจำตัว</th>
                            <th class="text-center">ชื่อ - สกุล</th>
                            <th class="text-center">PM Order</th>
                            <th class="text-center">Specific PM Order</th>
                            <th class="text-center">ชั่วโมงทำงาน</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perperson as $value)
                            <tr>
                                <td class="text-center">{{ $value->WorkID }}</td>
                                <td>{{ $value->ThaiName }}</td>
                                <td class="text-center">{{ $value->JobPM }}</td>
                                <td class="text-center">{{ $value->SpecificPM }}</td>
                                <td class="text-center">{{ number_format($value->ManHour,2) }}</td>
                                <td class="text-center">{{ number_format(100 * $value->ManHour / $value->TotalManHour,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
