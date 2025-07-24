@extends('layouts.printl')

@section('title','Work List')

@section('content')
    <table class="table table-bordered table-sm">
        @foreach ($project as $value)
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Work List</h4></td>
            <td colspan="2"> Project : {{ $value->ProjectName }} </td>
        </tr>
        <tr>
            <td style="width:32.5%"> Start Date : {{date('d-m-Y', strtotime($value->StartDate))}}</td>
            <td style="width:32.5%"> Finish Date : {{date('d-m-Y', strtotime($value->FinishDate))}}</td>
        </tr>
        @endforeach
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center">System</th>
                <th class="text-center">Equipment</th>
                <th class="text-center">Activity</th>
                <th class="text-center">Detail</th>
                <th class="text-center">Remark</th>
            </tr>
        </thead>
        <tbody>
            @php
                $system = '';
                $equipment = '';
            @endphp
            @foreach ($worklist as $location => $location_list)
                <tr>
                    <th colspan="5"><b>+ Location Name : {{ $location }}</b></th>
                </tr>
                @foreach ($location_list as $machine => $machine_list)
                    <tr>
                        <th colspan="5"><b>&emsp;+ Machine Name : {{ $machine }}</b></th>
                    </tr>
                    @foreach ($machine_list as $product => $product_list)
                        <tr>
                            <th colspan="5"><b>&emsp;&emsp;+ Product Name : {{ $product }}</b></th>
                        </tr>
                        @foreach ($product_list as $value)
                            <tr>
                                @if ( $value->SystemCode <> $system )
                                    <td rowspan="{{$value->CountOfSystemName}}"> {{$value->SystemName }} </td>
                                    @php
                                        $system = $value->SystemCode;
                                    @endphp
                                @endif
                                @if ( $value->EquipmentCode <> $equipment )
                                    <td rowspan="{{$value->CountOfEquipmentName}}"> {{$value->SpecificName }} </td>
                                    @php
                                        $equipment = $value->EquipmentCode;
                                    @endphp
                                @endif
                                <td> {{$value->ActivityName }} </td>
                                <td> {{$value->Detail }} </td>
                                <td>  </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        @foreach ($project as $value)
            <tr>
                @if ( $value->Planner != "")
                    <td class="text-center" style="width:33%">
                        <br>
                        <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br><br>
                        ( <u>{{$value->Planner}}</u> )<br>
                        ผู้จัดทำ / Planner
                    </td>
                @else
                    <td class="text-center" style="width:33%">
                        <br>
                        <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br><br>
                        ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> )<br>
                        ผู้จัดทำ / Planner
                    </td>
                @endif
                <td class="text-center" style="width:34%">
                    <br>
                    <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br><br>
                    ( <u>{{$value->AreaManager}}</u> )<br>
                    ผู้ควบคุมงาน / Area Manager
                </td>
                <td class="text-center" style="width:33%">
                    <br>
                    <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br><br>
                    ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> )<br>
                    Project Manager หรือ ลูกค้า
                </td>
            </tr>
        @endforeach
    </table>
@endsection