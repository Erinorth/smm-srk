@extends('layouts.print')

@section('title','Tool Breakdown')

@section('content')
    <h6 class="text-center">แบบรายงานความผิดปกติ & EQUIPMENT BREAKDOWN ของเครื่องมือ / อุปกรณ์ <br>
    การดำเนินการแก้ไข และ นำเข้าใช้งาน</h6><br>
    เรียน <u>กฟนม-ธ.</u>
    <table class="table table-bordered table-sm">
        <tr>
            <td>1. เครื่องมือ / อุปกรณ์</td>
        </tr>
        <tr>
            <td>
                @foreach ($tool as $value)
                    <u>{{ $value->CatagoryName }} {{ $value->RangeCapacity }}
                    @if ( $value->LocalCode <> "" )
                        &nbsp; Local Code : &nbsp; {{ $value->LocalCode }}
                    @endif
                    @if ( $value->DurableSupplieCode <> "" )
                        &nbsp; รหัสครุภัณฑ์/รหัสพัสดุ : &nbsp; {{ $value->DurableSupplieCode }}
                    @endif
                    @if ( $value->AssetToolCode <> "" )
                        &nbsp; รหัสสินทรัพย์/รหัสเครื่องมือ : &nbsp; {{ $value->AssetToolCode }}
                    @endif
                    @if ( $value->Brand <> "" )
                        &nbsp; ยี่ห้อ : &nbsp; {{ $value->Brand }}
                    @endif
                    @if ( $value->Model <> "" )
                        &nbsp; รุ่น : &nbsp;{{ $value->Model }}
                    @endif
                    @if ( $value->SerialNumber <> "" )
                        &nbsp; S/N : &nbsp;{{ $value->SerialNumber }}
                    @endif </u><br>
                    รายงานข้อขัดข้องเสียหาย - <u>{!! nl2br($value->Report) !!}</u><br>
                    สาเหตุหลัก - <u>{!! nl2br($value->Cause) !!}</u><br>
                    มูลค่าความเสียหาย - <u>{{ $value->Value }}</u><br>
                    แนวทางการแก้ไข - <u>{!! nl2br($value->Guideline) !!}</u><br><br>
                @endforeach
                <div class="row">
                    <div class="col" style="width: 70%"></div>
                    <div class="col text-right" style="width: 30%">
                        ผู้รายงาน <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br><br>
                        วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>2. การดำเนินการส่งซ่อม / จ้างซ่อม</td>
        </tr>
        <tr>
            <td>
                @foreach ($tool as $value)
                    <u>{!! nl2br($value->Operation) !!}</u><br>
                    หน่วยงาน/ผู้ดำเนินการ - <u>{!! nl2br($value->Operator) !!}</u><br><br>
                @endforeach
                <div class="row">
                    <div class="col" style="width: 70%"></div>
                    <div class="col text-right" style="width: 30%">
                        ผู้ส่งซ่อม <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br><br>
                        วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>3. แจ้งผลการซ่อม</td>
        </tr>
        <tr>
            <td>
                @foreach ($tool as $value)
                    <u>{!! nl2br($value->Result) !!}</u><br><br>
                @endforeach
                <div class="row">
                    <div class="col" style="width: 70%"></div>
                    <div class="col text-right" style="width: 30%">
                        ผู้ติดตามผลการแก้ไข <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br><br>
                        วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>4. รับรองนำเข้าใช้งาน</td>
        </tr>
        <tr>
            <td>
                <div class="row">
                    <div class="col" style="width: 70%"></div>
                    <div class="col text-right" style="width: 30%">
                        <br><br>
                        ผู้อนุมัติ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> หน. แผนก<br><br>
                        วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    ต้นฉบับ : หน่วยงาน
    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="2" class="text-center">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td colspan="7" class="text-center">รหัสเอกสาร  FM-002/QP-PB-013</td>
            <td colspan="3" class="text-center">แก้ไขครั้งที่   02</td>
        </tr>
    </table>
@endsection
