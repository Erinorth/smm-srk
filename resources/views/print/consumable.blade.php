@extends('layouts.print')

@section('title','Consumable List')

@section('content')
    <table class="table table-bordered table-sm">
        @foreach ($project as $value)
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Consumable List</h4></td>
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
                <td class="text-center">No.</td>
                <td class="text-center">รหัสวัสดุสิ้นเปลือง</td>
                <td class="text-center">รหัสจัดซื้อ</td>
                <td class="text-center">Consumable Name</td>
                <td class="text-center">Detail</td>
                <td class="text-center">Quantity</td>
                <td class="text-center">Unit</td>
                <td class="text-center">Remark</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($consumable as $value)
                <tr>
                    <td class="text-center">{{$i}}</td>
                    <td class="text-center">{{$value->ConsumableCode}}</td>
                    <td class="text-center">{{$value->PurchaseCode}}</td>
                    <td>{{$value->ConsumableName}}</td>
                    <td>{{$value->Detail}}</td>
                    <td class="text-center">{{$value->SumOfQuantity}}</td>
                    <td class="text-center">{{$value->Unit}}</td>
                    <td>{{$value->Remark}}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
@endsection
