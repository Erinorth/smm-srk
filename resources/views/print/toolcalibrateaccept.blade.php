@extends('layouts.print')

@section('title','Tool Calibrate Accept')

@section('content')
    <h5 class="text-center">วิเคราะห์และสรุปผลการสอบเทียบเครื่องมือวัด</h5>
    @foreach ($calibrate as $value)
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
            <div class="w-100"></div>
            <div class="col">Certificate No. : <u>{{ $value->Certificate }}</u></div>
            <div class="col">Calibrated Date : <u>{{ $value->CalibrateDate }}</u></div>
        </div>
    @endforeach
    วิเคราะห์ผลการสอบเทียบ
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td class="text-center" style="width: 25%">ค่ามาตรฐาน</td>
                <td class="text-center" style="width: 25%">ค่าที่วัดได้</td>
                <td class="text-center" style="width: 25%">ค่าที่เบี่ยงเบน + Uncertainty</td>
                <td class="text-center" style="width: 25%">ค่าผิดพลาดที่ยอมรับได้</td>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 20; $i++)
                <tr>
                    <td style="height: 40px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>
    สรุปผล
    @foreach ($calibrate as $value)
        @if ( $value->Result == "Pass" )
            <i class="far fa-lg fa-fw fa-check-square"></i> ผ่าน <i class="far fa-lg fa-fw fa-square"></i> ไม่ผ่าน <br>
        @else
            <i class="far fa-lg fa-fw fa-square"></i> ผ่าน <i class="far fa-lg fa-fw fa-check-square"></i> ไม่ผ่าน <br>
        @endif
        หมายเหตุ
        @if ( $value->Remark == "" )
            <u>-</u> <br>
        @else
            <u>{{ $value->Remark }}</u> <br>
        @endif
        กำหนดวันที่สอบเทียบครั้งต่อไป <u>{{ $value->ExpireDate }}</u>
    @endforeach
    <div class="row">
        <div class="col-6 text-center"></div>
        <div class="col-6 text-center">
            ผู้วิเคราะห์ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> หัวหน้าหน่วยงาน <br><br>
            ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br><br>
            วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
        </div>
    </div>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width: 33.33%"><h6>รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</h6></td>
            <td class="text-center" style="width: 33.34%">รหัสเอกสาร FM-003/QP-PB-017</td>
            <td class="text-center" style="width: 33.33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
@endsection