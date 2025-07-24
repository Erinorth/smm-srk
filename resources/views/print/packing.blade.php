@extends('layouts.printl')

@section('title','Consumable List')

@section('content')
    <table class="table table-bordered table-sm">
        @foreach ($project as $value)
            <tr>
                <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
                <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Packing List</h4></td>
                <td> Project : {{ $value->ProjectName }} </td>
                <td> Packing Name : {{ $packingid }}</td>
            </tr>
            <tr>
                <td> Start Date : {{date('d-m-Y', strtotime($value->StartDate))}}</td>
                <td> Finish Date : {{date('d-m-Y', strtotime($value->FinishDate))}}</td>
            </tr>
        @endforeach
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td class="text-center">No.</td>
                <td class="text-center">Name</td>
                <td class="text-center">Detail</td>
                <td class="text-center">Quantity</td>
                <td class="text-center">Unit</td>
                <td class="text-center">Price</td>
                <td class="text-center">Weight (kg.)</td>
                <td class="text-center">Remark</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($packing as $value)
                <tr>
                    <td class="text-center">{{$i}}</td>
                    <td class="text-center">{{$value->Name}}</td>
                    <td class="text-center">{{$value->Detail}}</td>
                    <td class="text-center">{{$value->Amount}}</td>
                    <td class="text-center">{{$value->Unit}}</td>
                    <td class="text-center">{{number_format($value->Price,2)}}</td>
                    <td class="text-center">{{number_format($value->Weight,2)}}</td>
                    <td>{{$value->Remark}}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            @foreach ($sum as $value)
                <tr>
                    <td colspan="5" class="text-center">Total</td>
                    <td class="text-center">{{number_format($value->SumOfPrice,2)}}</td>
                    <td class="text-center">{{number_format($value->SumOfWeight,2)}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
