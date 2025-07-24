@extends('layouts.print')

@section('title','Expensive Tool')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Expensive Tool</h4></td>
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
                <th class="text-center">Activity</th>
                <th class="text-center">Hour</th>
                <th class="text-center">Remark</th>
            </tr>
        </thead>
        <tbody>
            @php
                $date = '';
                $pmorder = '';
            @endphp
            @foreach ($report as $tool => $tool_list)
                <tr>
                    <th colspan="5"><b>+ {{ $tool }}</b></th>
                </tr>
                @foreach ($tool_list as $value)
                    <tr>
                        @if ( $value->DateCode <> $date )
                            <td rowspan="{{$value->CountOfDate}}" class="text-center"> {{$value->Date }} </td>
                            @php
                                $date = $value->DateCode;
                            @endphp
                        @endif
                        @if ( $value->PMOrderCode <> $pmorder )
                            <td rowspan="{{$value->CountOfp_m_order_id}}" class="text-center"> {{$value->PMOrder }} </td>
                            @php
                                $pmorder = $value->PMOrderCode;
                            @endphp
                        @endif
                        <td class="text-center">
                            @if ( $value->Activity == "Travel" )
                                V{{$value->ActivityType }}
                            @else
                                M{{$value->ActivityType }}
                            @endif
                        </td>
                        <td class="text-center"> {{$value->Hour }} </td>
                        <td> {{$value->Remark }} </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
