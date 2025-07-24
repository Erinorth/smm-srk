@extends('layouts.print')

@section('title','Tool Accept')

@section('content')
    <h5 class="text-center"><u>รายงานการตรวจสอบ/ทดสอบและการรับรองเครื่องมืออุปกรณ์</u></h5> <br>
    วันที่ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> เดือน <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ปี <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
    แผนก <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> กอง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ฝ่าย <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
    อ้างถึงบันทึก <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
    <table class="table table-borderless table-sm">
        <tr>
            <td style="width:20%">เครื่องมือ อุปกรณ์ที่รับมอบ</td>
            <td>
                @foreach ($tool as $value)
                    <u>
                        {{ $value->CatagoryName }} {{ $value->RangeCapacity }}
                        @if ( $value->Brand <> "" )
                            &ensp;//&ensp;ยี่ห้อ&nbsp;{{ $value->Brand }}
                        @endif
                        @if ( $value->Model <> "" )
                            &ensp;//&ensp;รุ่น&nbsp;{{ $value->Model }}
                        @endif
                        @if ( $value->SerialNumber <> "" )
                            &ensp;//&ensp;รหัส&nbsp;{{ $value->SerialNumber }}
                        @endif
                        @if ( $value->SerialNumber <> "" )
                            &ensp;//&ensp;รหัสครุภัณฑ์หรือรหัสพัสดุ&nbsp;{{ $value->DurableSupplieCode }}
                        @endif
                        @if ( $value->SerialNumber <> "" )
                            &ensp;//&ensp;รหัสสินทรัพย์หรือรหัสเครื่องมือเครื่องใช้&nbsp;{{ $value->AssetToolCode }}
                        @endif
                    </u> 
                @endforeach
            </td>
        </tr>
        <tr>
            <td>อุปกรณ์ประกอบ</td>
            <td><u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br><br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u></td>
        </tr>
        <tr>
            <td> <br> คู่มือและเอกสารประกอบ</td>
            <td> <br><u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br><br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u></td>
        </tr>
        <tr>
            <td><br> วิธีการตรวจสอบ/ทดสอบ</td>
            <td><br><u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br><br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u></td>
        </tr>
        <tr>
            <td><br> ผู้ตรวจสอบ/ทดสอบ</td>
            <td><br><u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">
                <br><br>
                ผู้สั่งงาน <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br>
                ตำแหน่ง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border-top">
                <br>
                รายงานการตรวจสอบและทดสอบ &emsp;&emsp;&emsp;&emsp; วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u> เดือน <u>&emsp;&emsp;&emsp;&emsp;</u> ปี <u>&emsp;&emsp;&emsp;&emsp;</u> <br>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                ได้ทำการตรวจสอบ/ทดสอบเครื่องมือและอุปกรณ์ตามข้อกำหนดแล้ว
            </td>
        </tr>
        <tr>
            <td>
                <i class="far fa-square"> ถูกต้องตามข้อกำหนด
            </td>
            <td>
                <i class="far fa-square"> ไม่ถูกต้อง รายละเอียด <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br><br>
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                </u>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                ได้ทำการตรวจสอบ/ทดสอบเครื่องมือและอุปกรณ์แล้ว
            </td>
        </tr>
        <tr>
            <td>
                <i class="far fa-square"> ผ่าน
            </td>
            <td>
                <i class="far fa-square"> ไม่ผ่าน รายละเอียด <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br><br>
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                </u>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                เห็นควรดำเนินการ
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <i class="far fa-square"> แจ้งผู้ส่งมอบเพื่อดำเนินการ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <i class="far fa-square"> อนุมัติผลตรวจสอบ/ทดสอบและขออนุมัติรับรองเครื่องมือและขึ้นทะเบียน
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <i class="far fa-square"> อนุมัติผลตรวจสอบ/ทดสอบและแจ้งผู้ส่งมอบแก้ไข/รับเครื่องมือคืน
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">
                <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br>
                ผู้ตรวจสอบ/ทดสอบ
            </td>
        </tr>
    </table>
    <table class="table table-borderless table-sm">
        <tr>
            <td class="text-center border-top border-left border-bottom">
                อนุมัติ/รับรอง <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br>
                ตำแหน่ง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
            <td class="text-center border-top border-bottom align-bottom">
                วันที่ <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
            </td>
            <td class="text-center border-top border-left border-bottom">
                อนุมัติขึ้นทะเบียน <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br>
                ตำแหน่ง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
            <td class="text-center border-top border-bottom border-right align-bottom">
                วันที่ <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td class="text-center">รหัสเอกสาร FM-001/QP-PB-013</td>
            <td class="text-center">แก้ไขครั้งที่ 02</td>
        </tr>
    </table>
@endsection
