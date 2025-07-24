@extends('layouts.print')

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
                <td class="text-center">No.</td>
                <td class="text-center">Tool Name</td>
                <td class="text-center">Quantity</td>
                <td class="text-center">Unit</td>
                <td class="text-center">Remark</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($tool as $value)
                <tr>
                    <td class="text-center">{{$i}}</td>
                    <td>{{$value->CatagoryName}}</td>
                    <td class="text-center">{{$value->SumOfQuantity}}</td>
                    <td class="text-center">{{$value->Unit}}</td>
                    <td class="text-center">{{$value->Remark}}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
@endsection

