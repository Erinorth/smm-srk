@extends('layouts.printl')

@section('title','Product')

@section('content')
    <h3 class="text-center">บัญชี ภารกิจ ผลิตภัณฑ์และบริการ ของหน่วยงาน</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <tbody>
                @foreach ($department as $value)
                    <tr>
                        <td>สายงาน <u>{{$value->Business}}</u> ฝ่าย <u>{{$value->Division}}</u> กอง <u>{{$value->Department}}</u> แผนก <u>{{$value->Section}}</u> รหัสหน่วยงาน <u>{{$value->Code}}</u></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">รหัสผลิตภัณฑ์</th>
                    <th class="text-center align-middle">ภารกิจ/ผลิตภัณฑ์และบริการ</th>
                    <th class="text-center align-middle">ลูกค้า/ผู้มีส่วนเกี่ยวข้อง</th>
                    <th class="text-center align-middle">ความต้องการ/ความคาดหวัง</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $productcode = '';
                    $stakeholder = '';
                @endphp
                @foreach ($product as $value)
                    <tr>
                        @if ( $value->ProductCode <> $productcode )
                            <td rowspan="{{$value->count_productcode}}" class="text-center"> {{$value->ProductCode }} </td>
                            <td rowspan="{{$value->count_productcode}}" class="text-center"> {{$value->ProductName}} / {{$value->Service}} / {{ $project->ProjectName }}</td>
                            @php
                                $productcode = $value->ProductCode;
                            @endphp
                        @endif
                        @if ( $value->code_stakeholdername <> $stakeholder )
                            <td rowspan="{{$value->count_stakeholdername}}" class="text-center"> {{$value->StakeholderName }} </td>
                            @php
                                $stakeholder = $value->code_stakeholdername;
                            @endphp
                        @endif
                        <td>{!! nl2br($value->MoreDetail) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-sm">
            <tbody>
                <tr>
                    <td class="text-right">ผู้จัดทำ</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-center">(................................................................)</td>
                    <td class="text-right">ตำแหน่ง</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-right">วันที่</td>
                    <td class="text-center">................................................................</td>
                </tr>
                <tr>
                    <td class="text-right">ผู้รับรอง</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-center">(................................................................)</td>
                    <td class="text-right">ตำแหน่ง</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-right">วันที่</td>
                    <td class="text-center">................................................................</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="text-right">FM-001/QP-PB-038 Rev.01</p>
@endsection
