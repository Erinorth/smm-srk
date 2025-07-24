@extends('layouts.print')

@section('title','Work Permit')

@section('content')
    <table class="table table-borderless table-sm">
        <tr class="border-top border-left border-right">
            <td colspan="13" class="text-center" style="width:100%"><h5>แบบฟอร์มอนุญาตให้ปฏิบัติงาน สายงาน รองผู้ว่าการธุรกิจเกี่ยวเนื่อง (รวธ.)</h5></td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="13" class="text-right" style="line-height:200%">
                เลขที่ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                (ออกโดย หน่วยงานเจ้าของพื้นที่)
            </td>
        </tr>
        <tr class="border-top border-left border-right">
            <td colspan="13">
                @if ( $workpermit->HotWork == 1 or $workpermit->ConfinedSpace == 1 or $workpermit->Chemical == 1 or $workpermit->Lifting == 1 or $workpermit->Scaffloding == 1 or $workpermit->Electrical == 1 or $workpermit->HighVoltage == 1 or $workpermit->Drilling == 1 or $workpermit->Radio == 1 or $workpermit->Diving == 1 or $workpermit->Other !== Null )
                    <i class="far fa-square"></i> การขอนุญาตปฏิบัติงานทั่วไป <br>
                    <i class="far fa-check-square"></i> การขอนุญาตปฏิบัติงานวิกฤติ (ต้องตรวจสอบมาตรการความปลอดภัยตามแบบฟอร์มการตรวจสอบความปลอดภัยของแต่ละงานวิกฤติ)
                @else
                    <i class="far fa-check-square"></i> การขอนุญาตปฏิบัติงานทั่วไป <br>
                    <i class="far fa-square"></i> การขอนุญาตปฏิบัติงานวิกฤติ (ต้องตรวจสอบมาตรการความปลอดภัยตามแบบฟอร์มการตรวจสอบความปลอดภัยของแต่ละงานวิกฤติ)
                @endif
            </td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="5" style="width:38.5%">
                @if ( $workpermit->HotWork == 1 )
                    <i class="far fa-check-circle"></i> งานที่คาดว่าอาจทำให้เกิดความร้อนหรือมีประกายไฟ <br>
                @else
                    <i class="far fa-circle"></i> งานที่คาดว่าอาจทำให้เกิดความร้อนหรือมีประกายไฟ <br>
                @endif
                @if ( $workpermit->ConfinedSpace == 1 )
                    <i class="far fa-check-circle"></i> งานในสถานที่อับอากาศ <br>
                @else
                    <i class="far fa-circle"></i> งานในสถานที่อับอากาศ <br>
                @endif
                @if ( $workpermit->Chemical == 1 )
                    <i class="far fa-check-circle"></i> งานเกี่ยวกับสารเคมีอันตราย <br>
                @else
                    <i class="far fa-circle"></i> งานเกี่ยวกับสารเคมีอันตราย <br>
                @endif
                @if ( $workpermit->Lifting == 1 )
                    <i class="far fa-check-circle"></i> งานยกของด้วยอุปกรณ์ยกของหนัก <br>
                @else
                    <i class="far fa-circle"></i> งานยกของด้วยอุปกรณ์ยกของหนัก <br>
                @endif
            </td>
            <td colspan="4" style="width:30.8%">
                @if ( $workpermit->Scaffloding == 1 )
                    <i class="far fa-check-circle"></i> งานในสถานที่สูง(นั่งร้าน) <br>
                @else
                    <i class="far fa-circle"></i> งานในสถานที่สูง(นั่งร้าน) <br>
                @endif
                @if ( $workpermit->Electrical == 1 )
                    <i class="far fa-check-circle"></i> งานเกี่ยวกับไฟฟ้า <br>
                @else
                    <i class="far fa-circle"></i> งานเกี่ยวกับไฟฟ้า <br>
                @endif
                @if ( $workpermit->HighVoltage == 1 )
                    <i class="far fa-check-circle"></i> งานเกี่ยวกับอุปกรณ์ไฟฟ้าแรงสูง <br>
                @else
                    <i class="far fa-circle"></i> งานเกี่ยวกับอุปกรณ์ไฟฟ้าแรงสูง <br>
                @endif
                @if ( $workpermit->Drilling == 1 )
                    <i class="far fa-check-circle"></i> งานเกี่ยวกับงานขุดเจาะ <br>
                @else
                    <i class="far fa-circle"></i> งานเกี่ยวกับงานขุดเจาะ <br>
                @endif
            </td>
            <td colspan="4" style="width:30.7%">
                @if ( $workpermit->Radio == 1 )
                    <i class="far fa-check-circle"></i> งานเกี่ยวกับกัมมันตภาพรังสี <br>
                @else
                    <i class="far fa-circle"></i> งานเกี่ยวกับกัมมันตภาพรังสี <br>
                @endif
                @if ( $workpermit->Diving == 1 )
                    <i class="far fa-check-circle"></i> งานประดาน้ำ <br>
                @else
                    <i class="far fa-circle"></i> งานประดาน้ำ <br>
                @endif
                @if ( $workpermit->Other !== Null )
                    <i class="far fa-check-circle"></i> งานอื่นๆ <u>{{ $workpermit->Other }}</u> <br>
                @else
                    <i class="far fa-circle"></i> งานอื่นๆ <u>&emsp;&emsp;&emsp;&emsp;</u> <br>
                @endif
            </td>
        </tr>
        <tr class="border-top border-left border-right">
            <td colspan="13" style="line-height:200%">ใบแจ้งงานบำรุงรักษา  เลขที่ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ชื่ออุปกรณ์ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> สถานที่ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> </td>
        </tr>
        <tr class="border-top border-left border-right">
            <td colspan="13" style="line-height:200%">
                ใบอนุญาตเริ่มใช้วันที่ <u>{{ date('d', strtotime($workpermit->Date)) }} / {{ date('m', strtotime($workpermit->Date)) }} / {{ date('y', strtotime($workpermit->Date)) }}</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;</u> : <u>&emsp;&emsp;&emsp;&emsp;</u> น. สิ้นสุดวันที่ <u>{{ date('d', strtotime($workpermit->Date)) }} / {{ date('m', strtotime($workpermit->Date)) }} / {{ date('y', strtotime($workpermit->Date)) }}</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;</u> : <u>&emsp;&emsp;&emsp;&emsp;</u> น. <br>
                ผู้ขออนุญาตชื่อ <u>{{ $requester->ThaiName }}</u> หน่วยงาน <u>{{ $department->Section }} {{ $department->Department }} {{ $department->Division }}</u> บริษัท (ถ้ามี) <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                สถานที่ปฏิบัติงาน <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ชื่อบริษัทผู้รับเหมา(ถ้ามี) <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> จำนวน <u>&emsp;&emsp;&emsp;&emsp;</u> คน <br>
                ขณะปฏิบัติงาน ข้าพเจ้าได้มอบหมายให้ พนักงาน (ชื่อ) <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผุ้รับเหมา (ชื่อ) <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> เป็นควบคุมการทำงาน <br>
                งานที่ปฏิบัติ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> (ตามแผนผังโดยสังเขปหลังแบบฟอร์ม)
            </td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="3" style="width:23.1%">
                <i class="far fa-square"></i> อุปกรณ์เครื่องมือที่ใช้ <br>
                <i class="far fa-square"></i> อุปกรณ์ยกของหนัก
            </td>
            <td colspan="3" style="width:23.1%">
                <i class="far fa-square"></i> เครื่องเชื่อมไฟฟ้า แก๊ส <br>
                <i class="far fa-square"></i> บันได นั่งร้าน รถกระเช้า
            </td>
            <td colspan="3" style="width:23.1%">
                <i class="far fa-square"></i> เครื่องตัดแก๊ส <br>
                <i class="far fa-square"></i> อุปกรณ์ไฟฟ้าแรงสูง
            </td>
            <td colspan="4">
                <i class="far fa-square"></i> หินเจียร สว่านไฟฟ้า <br>
                <i class="far fa-square"></i> อื่นๆ ระบุ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="13" style="line-height:200%">
                อันตรายที่อาจได้รับ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                วิธีการช่วยเหลือออกจากที่อับอากาศ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                มาตรการ/อุปกรณ์ป้องกันอันตรายส่วนบุคคลที่ต้องใช้ (กำหนดโดยพนักงานผู้ขออนุญาต)
            </td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="2" style="width:15.4%">
                <i class="far fa-square"></i> ร้องเท้านิรภัย <br>
                <i class="far fa-square"></i> หมวกนิรภัย <br>
                <i class="far fa-square"></i> อุปกรณ์ช่วยหายใจ
            </td>
            <td colspan="3" style="width:23.1%">
                <i class="far fa-square"></i> หน้ากากกรองสารเคมี <br>
                <i class="far fa-square"></i> หน้ากากเชื่อม <br>
                <i class="far fa-square"></i> อุปกรณ์ลดเสียง
            </td>
            <td colspan="2" style="width:15.4%">
                <i class="far fa-square"></i> แว่นตา <br>
                <i class="far fa-square"></i> ถุงมือหนัง <br>
                <i class="far fa-square"></i> ถุงมือผ้า
            </td>
            <td colspan="3" style="width:23.1%">
                <i class="far fa-square"></i> ถุงมือยาง <br>
                <i class="far fa-square"></i> หน้ากากป้องกันหน้า <br>
                <i class="far fa-square"></i> รองเท้ายาง
            </td>
            <td colspan="3" colspan="4" style="width:23%">
                <i class="far fa-square"></i> Satety Harness <br>
                <i class="far fa-square"></i> ถุงมือสำหรับไฟฟ้าแรงสูง <br>
                <i class="far fa-square"></i> อุปกรณ์ช่วยชีวิต <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="13" style="line-height:200%">
                ข้าพเจ้าได้เตรียมอุปกรณ์ป้องกันอันตรายครบแล้ว และจะปฏิบัติตามมาตรการความปลอดภัยที่กำหนดไว้อย่างเคร่งครัด <br>
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผู้ขออนุญาตทำงาน เบอร์โทร <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> วันที่ <u>{{ date('d', strtotime($workpermit->Date)) }} / {{ date('m', strtotime($workpermit->Date)) }} / {{ date('y', strtotime($workpermit->Date)) }}</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;</u> : <u>&emsp;&emsp;&emsp;&emsp;</u> น.
            </td>
        </tr>
        <tr class="border-top border-left border-right">
            <td colspan="13">
                มาตรการความปลอดภัย (กำหนดโดยผู้อนุมัติ) <br>
                งานทั่วไป / มาตรการอื่นๆ เพิ่มเติม  ( สำหรับงานวิกฤติต้องปฏิบัติตามมาตรการที่กำหนดไว้ในแบบฟอร์มรับการตรวจสอบความปลอดภัยของแต่ละงาน)
            </td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="4" style="width:30.8%">
                <i class="far fa-square"></i> 1 ตัดแยกระบบ <br>
                <i class="far fa-square"></i> 2 ลดความดัน <br>
                <i class="far fa-square"></i> 3 ระบายทิ้ง <br>
                <i class="far fa-square"></i> 4 ไล่ด้วย  N2  /  O2  /  CO2 <br>
                <i class="far fa-square"></i> 5 แขวน TAG ที่อุปกรณ์ <br>
                <i class="far fa-square"></i> 6 ปิดท่อด้วยหน้าแปลนทึบ
            </td>
            <td colspan="5">
                <i class="far fa-square"></i> 7 ตัดแหล่งไฟฟ้าและแขวนป้ายเตือน <br>
                <i class="far fa-square"></i> 8 เตรียมอุปกรณ์ดับเพลิง <br>
                <i class="far fa-square"></i> 9 ปิดกั้นบริเวณพร้อมป้ายเตือน <br>
                <i class="far fa-square"></i> 10 จัดพนักงานช่วยเหลือพร้อมอุปกรณ์ <br>
                <i class="far fa-square"></i> 11 ควบคุมการทำงานตลอดเวลาโดยจ้าหน้าที่ความปลอดภัย <br>
                <i class="far fa-square"></i> 12 ตรวจสอบพื้นที่ปฏิบัติงานโดยผู้ขออนุญาติ
            </td>
            <td colspan="4">
                <i class="far fa-square"></i> 13 ตรวจวัดก๊าซก่อนปฏิบัติงาน <br>
                <i class="far fa-square"></i> 14 ตรวจวัดก๊าซระหว่างปฏิบัติงานทุก <u>&emsp;&emsp;&emsp;&emsp;</u> ชั่วโมง     <br>
                <i class="far fa-square"></i> 15 อื่นๆ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                <i class="far fa-square"></i> 16 อื่นๆ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                <i class="far fa-square"></i> 17 อื่นๆ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                <i class="far fa-square"></i> 18 อื่นๆ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="13">
                ผลการประเมินสภาพอันตราย/บรรยากาศอันตราย <i class="far fa-square"></i> ปลอดภัย <i class="far fa-square"></i> ไม่ปลอดภัย
            </td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="9" style="width:50%; line-height:200%;">
                ข้าพเจ้าได้กำหนดมาตรการความปลอดภัยตามความเหมาะสมเรียบร้อยแล้ว และอนุญาตให้ปฏิบัติงานได้ <br>
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผู้อนุมัติ วันที่ <u>{{ date('d', strtotime($workpermit->Date)) }} / {{ date('m', strtotime($workpermit->Date)) }} / {{ date('y', strtotime($workpermit->Date)) }}</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;</u> : <u>&emsp;&emsp;&emsp;&emsp;</u> น.
            </td>
            <td colspan="4" style="width:50%; line-height:200%;">
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> (ผู้ช่วยเหลือ) <br>
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> (ผู้ควบคุมงาน)
            </td>
        </tr>
        <tr class="border-top border-left border-right">
            <td colspan="13" style="line-height:200%">
                การตรวจสอบก่อนการปฏิบัติงาน <br>
                ผู้ขออนุญาตได้อธิบายมาตรการความปลอดภัยแก่ผู้ปฏิบัติงานเป็นที่เข้าใจแล้วและตรวจสอบอุปกรณ์ที่ใช้งานแล้วว่าอยู่ในสภาพที่ปลอดภัยในการปฏิบัติงาน <br>
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผู้ขออนุญาต วันที่ <u>{{ date('d', strtotime($workpermit->Date)) }} / {{ date('m', strtotime($workpermit->Date)) }} / {{ date('y', strtotime($workpermit->Date)) }}</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;</u> : <u>&emsp;&emsp;&emsp;&emsp;</u> น. <br>
                ข้าพเจ้าได้ตรวจสอบแล้วปรากฎว่าเป็นไปตามเงื่อนไขที่ระบุขั้นต้นทุกประการ และอนุญาตให้เริ่มปฏิบัติงานได้ <br>
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผู้ควบคุมอุปกรณ์/พื้นที่(ตรวจสอบก่อนเริ่มงาน) วันที่ <u>{{ date('d', strtotime($workpermit->Date)) }} / {{ date('m', strtotime($workpermit->Date)) }} / {{ date('y', strtotime($workpermit->Date)) }}</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;</u> : <u>&emsp;&emsp;&emsp;&emsp;</u> น.
            </td>
        </tr>
        <tr class="border-top border-left border-right">
            <td colspan="13">
                การต่ออายุใบอนุญาต (  ผู้ควบคุมอุปกรณ์/พื้นที่ ต้องตรวจสอบความปลอดภัยก่อนอนุมัติต่อ Work )
            </td>
        </tr>
        <tr>
            <td rowspan="2" class="text-center align-middle border-top border-left" style="width:7.7%">ครั้งที่</td>
            <td colspan="4" class="text-center border-top border-left">เริ่มต้น</td>
            <td colspan="4" class="text-center border-top border-left">เริ่มต้น</td>
            <td colspan="2" rowspan="2" class="align-middle text-center border-top border-left" style="width:15.4%">ผู้ควบคุมอุปกรณ์/พื้นที่</td>
            <td colspan="2" rowspan="4" class="border-top border-left border-right">หมายเหตุ การต่อใบอนุญาตต้องทำการต่อโดยผู้ขออนุญาตเท่านั้น</td>
        </tr>
        <tr>
            <td colspan="2" class="text-center border-top border-left">วันที่</td>
            <td colspan="2" class="text-center border-top border-left">เวลา</td>
            <td colspan="2" class="text-center border-top border-left">วันที่</td>
            <td colspan="2" class="text-center border-top border-left" style="width:12.5%">เวลา</td>
        </tr>
        <tr>
            <td class="text-center border-top border-left">1</td>
            <td colspan="2" class="border-top border-left"></td>
            <td colspan="2" class="border-top border-left"></td>
            <td colspan="2" class="border-top border-left"></td>
            <td colspan="2" class="border-top border-left"></td>
            <td colspan="2" class="border-top border-left"></td>
        </tr>
        <tr>
            <td class="text-center border-top border-left">2</td>
            <td colspan="2" class="border-top border-left"></td>
            <td colspan="2" class="border-top border-left"></td>
            <td colspan="2" class="border-top border-left"></td>
            <td colspan="2" class="border-top border-left"></td>
            <td colspan="2" class="border-top border-left"></td>
        </tr>
        <tr class="border-top border-left border-right">
            <td colspan="13">การปิดใบอนุญาต</td>
        </tr>
        <tr class="border-left border-right">
            <td colspan="9" style="line-height:200%">
                <i class="far fa-square"></i> งานเสร็จสมบูรณ์และเก็บอุปกรณ์เครื่องมือและทำความสะอาดพื้นที่เรียบร้อย <br>
                <i class="far fa-square"></i> ยกเลิกเนื่องจาก <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                <i class="far fa-square"></i> สภาพการทำงานไม่ปลอดภัย <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
            </td>
            <td colspan="4">** หมายเหตุ  เมื่อเกิดเหตุฉุกเฉินใบอนุญาตนี้จะถูกยกเลิกโดยอัตโนมัติและปฏิบัติตามแผนฉุกเฉินของพื้นที่</td>
        </tr>
        <tr class="border-left border-right border-bottom">
            <td colspan="13" style="line-height:200%">
                ลงชื่อผู้ขอปิดงาน <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> (ผู้ขออนุญาต) วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;</u> : <u>&emsp;&emsp;&emsp;&emsp;</u> น.<br>
                ลงชื่อผู้ตรวจสอบ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> (ผู้ควบคุมพื้นที่) วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;</u> : <u>&emsp;&emsp;&emsp;&emsp;</u> น.
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-010/QP-PB-031</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
    <table class="table table-borderless table-sm">
        <tr>
            <td>
                ต้นฉบับ <i class="far fa-square"></i> ผู้ขออนุญาต <br>
                สำเนา <i class="far fa-square"></i> ผู้อนุญาต <i class="far fa-square"></i> ผู้ควบคุมโครงการ
            </td>
        </tr>
    </table>
@endsection