@extends('layouts.print')

@section('title','Participation')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="5" class="text-center"><h5>แบบฟอร์มการลงชื่อรับทราบ</h5></td>
        </tr>
        <tr>
            <td colspan="5" style="line-height:200%; width:100%;">
                หน่วยงาน หบนม-ธ. กฟนม-ธ. อบค. รวธ. <br>
                &emsp;&emsp;ข้าพเจ้าได้ทำความเข้าใจการดำเนินการ กิจกรรมด้านคุณภาพอาชีวอนามัยและความปลอดภัย และข้อมูลที่เกี่ยงข้อง เรื่อง <br>
                &emsp;&emsp;1.	นโยบายคุณภาพ อาชีวอนามัยและความปลอดภัย <br>
                &emsp;&emsp;2.	เป้าหมายคุณภาพ อาชีวอนามัยและความปลอดภัย <br>
                &emsp;&emsp;3. <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                &emsp;&emsp;4. <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                &emsp;&emsp;5. <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
        <tr>
            <td class="text-center" style="width:5%">ลำดับที่</td>
            <td class="text-center" style="width:40%">ชื่อ-สกุล</td>
            <td class="text-center" style="width:20%">ลายมือชื่อ</td>
            <td class="text-center" style="width:10%">วันที่รับทราบ</td>
            <td class="text-center" style="width:25%">ข้อเสนอแนะ</td>
        </tr>
        @for ($i = 0; $i < 33; $i++)
            <tr>
                <td style="height:30px"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endfor
        <tr>
            <td colspan="3" style="width:65%">ต้นฉบับ: เก็บที่หน่วยงาน</td>
            <td colspan="2" class="text-center" style="width:35%">
                <br>
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                @foreach ($employee as $value)
                    ( <u>{{ $value->ThaiName }}</u> ) <br>
                @endforeach
                ตำแหน่ง <u>ผู้ควบคุมงาน</u> <br>
                วันที่ <u>{{ date('d-m-Y', strtotime($participation->Date)) }}</u> <br>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-001/QP-PB-036</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
@endsection