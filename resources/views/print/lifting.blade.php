@extends('layouts.print')

@section('title','Lifting')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานยกของด้วยอุปกรณ์ยกของหนัก</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 1 / 1</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$lifting->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$lifting->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$lifting->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$lifting->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($lifting->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$lifting->Reference}}</td>
        </tr>
        <tr>
            <td><h6>วันที่ปฏิบัติงานจริง</h6></td>
            <td></td>
            <td colspan="2"></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle"><h6>ลำดับที่</h6></td>
            <td rowspan="2" class="text-center align-middle"><h6>มาตรการควบคุมความปลอดภัยของแต่ละงานวิกฤติ</h6></td>
            <td colspan="2" class="text-center align-middle"><h6>ผลการตรวจสอบมาตรการความปลอดภัย</h6></td>
            <td rowspan="2" class="text-center align-middle" style="width:12%"><h6>สิ่งที่พบ</h6></td>
        </tr>
        <tr>
            <td class="text-center align-middle" style="width:8%"><h6>ปฏิบัติ</h6></td>
            <td class="text-center align-middle" style="width:8%"><h6>ไม่ปฏิบัติ</h6></td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>มีบุคคลาการครบ คือ ผู้ควบคุม ผู้ให้สัญญาณ ผู้ผูกมัดยึดโยง ผู้ควบคุมการใช้ เครน / ปั้นจั่น</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>ผู้ให้สัญญาณ ผู้ยึดเกาะวัสดุ ผู้ควบคุมการใช้ เครน / ปั้นจั่น จะต้องผ่านการอบรม</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>เครน / ปั้นจั่น ต้องติดป้ายบอกกัดน้ำหนักยกชัดเจน </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>ก่อนทำการยกต้องตรวจสอบและ ผูกมัดสิ่งของให้มั่นคงเสมอ มีการยึดพอเพียงที่จะไม่ทำให้เกิดการเอียง แกว่ง หรือหมุน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>ขณะที่ยกขึ้นหาวัสดุที่มีความทนทานและอ่อนตัวมารองรับบริเวณจุดที่มีการสัมผัสระหว่างอุปกรณ์ที่ใช้ในการผูก มัดหรือยึดโยง และวัสดุที่ทำการยกเคลื่อนย้าย</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>มีการกำหนด พื้นที่ที่จะวางของและบริเวณการยกอย่างชัดเจน โดยกั้นบริเวณ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>ไม่ยกของข้ามศีรษะคน หรือไม่ให้คนอยู่ใต้สิ่งของที่กำลังทำการยก</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td>ผู้ให้สัญญาณเครน / ปั้นจั่นต้อง สวมใส่เสื้อที่มีแถบสะท้อนแสง พร้อมนกหวีด แสดงสถานะอย่างชัดเจน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>ต้องจัดให้มีวิทยุสื่อสารระหว่างผู้ควบคุมเครนและผู้ให้สัญญาณเครน ในกรณีที่มีการยกของขึ้นที่สูงหรืออยู่ในจุดที่ไม่สามารถมองเห็นจุดที่ทำงานได้</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">เครนและปั้นจั่นชนิดเคลื่อนที่ไม่ได้</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>ตรวจสอบรายงานการตรวจสอบตามกฎหมาย (คป.1) ก่อนเริ่มงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>มีการกำหนด พื้นที่ที่จะวางของและบริเวณการยกอย่างชัดเจน โดยกั้นบริเวณ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>ผู้ควบคุมเครนไม่ยกของเกินพิกัดน้ำหนักยกของเครนและปั้นจั่น</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>ผู้ควบคุมเครน ต้องผ่านการตรวจร่างกาย (ผู้ขับเครื่องจักรกล) ผ่านการอบรมในเรื่องของการควบคุม และมีใบอนุญาตตามกฎหมาย</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>ท่าทางการใช้สัญญาณมือสื่อสารระหว่างผู้ให้สัญญาณกับผู้ควบคุมเป็นไปตามาตรฐานการให้สัญญาณเครนและปั้นจั่นชนิดเคลื่อนที่ไม่ได้</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">เครนและปั้นจั่นชนิดเคลื่อนที่ได้</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>ตรวจสอบรายงานการตรวจสอบตามกฎหมาย (คป.2) ก่อนเริ่มงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>ก่อนนำรถเครนเข้ามาทำงานจะต้องผ่านการตรวจสอบสภาพของรถโดยโรงไฟฟ้าเจ้าของพื้นที่</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>ผู้ควบคุมรถเครน ต้องผ่านการอบรมในเรื่องของการควบคุม และมีใบอนุญาตตามกฎหมาย</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>ขาหยั่งเครน จะต้องกางให้สุดทุกครั้ง และต้องมีแผ่นเหล็กหรือแผ่นวัสดุที่รับน้ำหนักได้ ปู รองขาหยั่งทุกครั้งที่มีการยกของ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>ท่าทางการใช้สัญญาณมือสื่อสารระหว่างผู้ให้สัญญาณกับผู้ควบคุมเป็นไปตามาตรฐานการให้สัญญาณเครนและปั้นจั่นชนิดเคลื่อนที่ได้</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">ผู้ควบคุมปั้นจั่น : {{$lifting->Operator}}</td>
        </tr>
        <tr>
            <td colspan="5">ผู้ให้สัญญาณ และควบคุมการผูกมัด ยึดโยง : {{$lifting->Foreman}}</td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br>
                ( {{$lifting->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$lifting->Supervisor}} )<br>
                หัวหน้างาน/ผู้ควบคุมงาน
            </td>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br>
                (.....................................................)<br>
                ผู้ควบคุมพื้นที่ (เฉพาะงานภายในพื้นที่สำนักงานและอาคารปฏิบัติการ)
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-014/QP-PB-031</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 02</td>
        </tr>
    </table>
@endsection