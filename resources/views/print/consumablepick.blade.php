@extends('layouts.printl')

@section('title','Consumable List')

@section('content')
    <table class="table table-bordered table-sm">
        @if ( $x == 1 )
            @foreach ($project as $value)
                <tr>
                    <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
                    <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Consumable List</h4></td>
                    <td> Project : {{ $value->ProjectName }} </td>
                    <td> PM Order : {{ $pmorder->PMOrder }} / {{ $pmorder->PMOrderName }} </td>
                </tr>
                <tr>
                    <td> Start Date : {{date('d-m-Y', strtotime($value->StartDate))}}</td>
                    <td> Finish Date : {{date('d-m-Y', strtotime($value->FinishDate))}}</td>
                </tr>
            @endforeach
        @else
            @foreach ($project as $value)
                <tr>
                    <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
                    <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>Consumable List</h4></td>
                    <td> Project : {{ $value->ProjectName }} </td>
                    <td> PM Order : All </td>
                </tr>
                <tr>
                    <td> Start Date : {{date('d-m-Y', strtotime($value->StartDate))}}</td>
                    <td> Finish Date : {{date('d-m-Y', strtotime($value->FinishDate))}}</td>
                </tr>
            @endforeach
        @endif
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td class="text-center">No.</td>
                <td class="text-center">รหัสวัสดุสิ้นเปลือง</td>
                <td class="text-center">รหัสจัดซื้อ</td>
                <td class="text-center">Consumable Name</td>
                <td class="text-center">Detail</td>
                <td class="text-center">Unit</td>
                <td class="text-center">Pick</td>
                <td class="text-center">Return</td>
                <td class="text-center">Price/Unit</td>
                <td class="text-center">Price</td>
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
                    <td class="text-center">{{$value->Unit}}</td>
                    <td class="text-center">{{$value->Pick}}</td>
                    <td class="text-center">{{$value->Return}}</td>
                    <td class="text-center">{{number_format($value->Cost,2)}}</td>
                    <td class="text-center">{{number_format($value->Price,2)}}</td>
                    <td>{{$value->Remark}}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            @foreach ($sum as $value)
                <tr>
                    <td colspan="9" class="text-center">Total</td>
                    <td class="text-center">{{number_format($value->Price,2)}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
