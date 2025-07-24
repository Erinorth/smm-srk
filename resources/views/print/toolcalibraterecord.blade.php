@extends('layouts.print')

@section('title','Tool Calibrate Record')

@section('content')
    <h5 class="text-center">ประวัติสอบเทียบเครื่องมือวัด </h5>
    @foreach ($tool as $value)
        <div class="row">
            <div class="col">ชื่อเครื่องมือวัด : <u>{{ $value->CatagoryName }} {{ $value->RangeCapacity }}</u></div>
            <div class="w-100"></div>
            <div class="col">Manufacturer : <u>{{ $value->Brand }}</u></div>
            <div class="col">Serial No. : <u>{{ $value->SerialNumber }}</u></div>
            <div class="w-100"></div>
            <div class="col">Model : <u>{{ $value->Model }}</u></div>
            <div class="col">รหัส : @if ( $value->LocalCode <> "" )
                    Local Code : &nbsp; <u>{{ $value->LocalCode }}</u>
                @endif
                @if ( $value->DurableSupplieCode <> "" )
                    &nbsp; รหัสครุภัณฑ์/รหัสพัสดุ : &nbsp; <u>{{ $value->DurableSupplieCode }}</u>
                @endif
                @if ( $value->AssetToolCode <> "" )
                    &nbsp; รหัสสินทรัพย์/รหัสเครื่องมือ : &nbsp; <u>{{ $value->AssetToolCode }}</u>
                @endif
            </div>
        </div>
    @endforeach
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td rowspan="2" class="text-center">ลำดับที่</td>
                <td rowspan="2" class="text-center">วัน-เดือน-ปี สอบเทียบ</td>
                <td rowspan="2" class="text-center">วันที่สอบเทียบครั้งต่อไป</td>
                <td rowspan="2" class="text-center">หน่วยงานสอบเทียบ</td>
                <td colspan="2" class="text-center">ผลการดำเนินงาน</td>
                <td rowspan="2" class="text-center">รายละเอียด</td>
                <td rowspan="2" class="text-center">ผู้ดูแลเครื่องมือ</td>
            </tr>
            <tr>
                <td class="text-center">ผ่าน</td>
                <td class="text-center">ไม่ผ่าน</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($record as $value)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($value->CalibrateDate)) }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($value->ExpireDate)) }}</td>
                    <td class="text-center">{{ $value->Calibrator }}</td>
                    <td class="text-center">
                        @if ( $value->Result == "Pass" )
                            /
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->Result <> "Pass" )
                            /
                        @endif
                    </td>
                    <td>
                        Certificate No. : <u>{{ $value->Certificate }}</u> <br>
                        Accuracy : <u>{{ $value->Accuracy }}</u> <br>
                        ค่าความผิดพลาดที่ยอมรับได้ : <u>{{ $value->AcceptError }}</u>
                    </td>
                    <td class="text-center">{{ $value->Responsible }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width: 33.33%"><h6>รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</h6></td>
            <td class="text-center" style="width: 33.34%">รหัสเอกสาร FM-004/QP-PB-017</td>
            <td class="text-center" style="width: 33.33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
@endsection
