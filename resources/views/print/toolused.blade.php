@extends('layouts.printl')

@section('title','Tool List')

@section('content')
    <table class="table table-bordered table-sm">
        @foreach ($project as $value)
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Tool List</h4></td>
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
                <td rowspan="2" class="text-center">No.</td>
                <td rowspan="2" class="text-center">Catagory Name</td>
                <td rowspan="2" class="text-center">Range/Capacity</td>
                <td rowspan="2" class="text-center">Brand</td>
                <td rowspan="2" class="text-center">Model</td>
                <td rowspan="2" class="text-center">SerialNumber</td>
                <td rowspan="2" class="text-center">LocalCode</td>
                <td rowspan="2" class="text-center">DurableSupplieCode</td>
                <td rowspan="2" class="text-center">AssetToolCode</td>
                <td rowspan="2" class="text-center">Unit</td>
                <td colspan="4" class="text-center">Status</td>
                <td rowspan="2" class="text-center">Remark</td>
            </tr>
            <tr>
                <td class="text-center">On Site</td>
                <td class="text-center">Returned</td>
                <td class="text-center">Lost</td>
                <td class="text-center">Broken</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($tool as $value)
                <tr>
                    <td class="text-center">{{$i}}</td>
                    <td>{{$value->CatagoryName}}</td>
                    <td class="text-center">{{$value->RangeCapacity}}</td>
                    <td class="text-center">{{$value->Brand}}</td>
                    <td class="text-center">{{$value->Model}}</td>
                    <td class="text-center">{{$value->SerialNumber}}</td>
                    <td class="text-center">{{$value->LocalCode}}</td>
                    <td class="text-center">{{$value->DurableSupplieCode}}</td>
                    <td class="text-center">{{$value->AssetToolCode}}</td>
                    <td class="text-center">{{$value->Unit}}</td>
                    <td class="text-center">@if ($value->OnSite == 1) X @endif</td>
                    <td class="text-center">@if ($value->Returned == 1) X @endif</td>
                    <td class="text-center">@if ($value->Lost == 1) X @endif</td>
                    <td class="text-center">@if ($value->Broken == 1) X @endif</td>
                    <td></td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
                <tr>
                    <td colspan="10" class="text-center">Total</td>
                    <td class="text-center"> {{ count($onsite) }} </td>
                    <td class="text-center"> {{ count($return) }}</td>
                    <td class="text-center"> {{ count($lost) }}</td>
                    <td class="text-center"> {{ count($broken) }}</td>
                    <td></td>
                </tr>
        </tbody>
    </table>
@endsection
