@extends('layouts.print')

@section('title','Work at Hight')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานในสถานที่สูง(นั่งร้าน)</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 1 / 1</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$workathight->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$workathight->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$workathight->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$workathight->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($workathight->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$workathight->Reference}}</td>
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
            <td>การปฏิบัติงาน ที่สูงจากพื้นดิน 2 เมตรขึ้นไป โดยที่ไม่มีโครงสร้างที่แข็งแรง เพียงพอ รองรับ จะต้องมีการติดตั้ง นั่งร้าน เพื่อใช้งาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>วัสดุที่เอามาเป็นโครงสร้างเพื่อประกอบในการติดตั้งนั่งร้าน ต้องมีมาตรฐานรับรอง ยกเว้น พื้นไม้สำหรับปฏิบัติงาน และฐานรองเสานั่งร้าน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>ในขณะที่มีพายุฝนตก ห้ามมิให้มีการทำงาน บนนั่งร้าน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>ก่อนที่จะปฏิบัติงานบนนั่งร้าน นั่งร้านนั้นจะต้องผ่านการตรวจสอบและอนุญาตจากเจ้าหน้าที่ที่โรงไฟฟ้าเจ้าของพื้นที่กำหนด และต้องผ่านการตรวจตามระยะเวลาที่โรงไฟฟ้าเจ้าของพื้นที่กำหนด</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>หากมีการแก้ไขดัดแปลงเพิ่มเติมจะต้องมี การตรวจสอบนั่งร้านใหม่ทุกครั้ง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>จำนวนผู้ปฏิบัติงานที่ขึ้นไปปฏิบัติงานไม่เกินความสามารถของนั่งร้านที่รับได้</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">รายการตรวจสอบนั่งร้าน</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>ระยะห่างระหว่างขาของนั่งร้าน ต้องไม่เกิน 2.0 เมตร ความสูงแต่ละชั้นไม่เกิน 2.00 เมตร</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>ระยะคานตัวแรกห่างจากพื้นติดตั้งนั่งร้านไม่เกิน 30 cm.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>ราวกันตก สูงจากพื้นนั่งร้าน ชั้นกลางสูง 45-55 cm.  ชั้นบนสูง 90-110 cm.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>นั่งร้านต้องมีแผ่นกันของตกด้านข้าง( toe board )สูงไม่น้อยกว่า 10 cm.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>ท่อนั่งร้านยื่นออกจากตัวนั่งร้านต้องไม่น้อยกว่า 10 cm.และไม่เกินกว่า 20 cm.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>Clamp จับยึดระหว่างเสานั่งร้านมีความมั่นคงแข็งแรง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>การตั้งเสานั่งร้านต้องตั้งตรงได้ฉากกับพื้น</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td>การติดตั้งบันได แต่ละช่วงสูงต้องไม่เกิน 3 เมตร การติดตั้งบันไดฐานต้องติดที่พื้น ส่วนปลายบันไดต้องสูงเกินพื้นนั่งร้านอย่างน้อย 60 cm.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>การปูไม้กระดานบนนั่งร้าน ปูเต็มพื้นที่  ปูแบบปลายชนกัน และห้ามวางซ้อนกัน พื้นนั่งร้าน จะต้องปูติดต่อกันมีความกว้างไม่น้อยกว่า 35 เซนติเมตร มีพื้นไม้ที่ปูยื่นออกมาจากตงต้องไม่น้อยกว่า 10 cm.และไม่เกินกว่า 20 cm.  แผ่นไม้ที่ปูต้องมีการผูกลวดที่หัวและท้ายกันกระดก โดยผูกที่ละ 1 แผ่น</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">10</td>
            <td>นั่งร้านที่สูงเกิน 3 เท่าของฐาน ต้องมีการยึดให้มั่นคงแข็งแรงป้องกัน นั่งร้านล้มตรงชั้นที่ 2และทุก ๆ 4 เมตร และนั่งร้านที่สูงเกิน 6 เมตร ต้องมีค้ำยัน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">11</td>
            <td>ระยะนั่งร้านต้องห่างจากสายไฟฟ้า ไม่น้อยกว่าตามข้อกำหนด</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">12</td>
            <td>นั่งร้านมีฐานรองขาปรับระดับ ระยะเกลียวอยู่ในท่อ 3/4</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">13</td>
            <td>มีตาข่ายหรือผ้าใบปิดคลุมส่วนที่กำหนดเป็นช่องทางเดินใต้นั่งร้าน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">14</td>
            <td>โครงสร้างนั่งร้านอยู่ในสภาพสมบูรณ์</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br>
                ( {{$workathight->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$workathight->Supervisor}} )<br>
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
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-015/QP-PB-031</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
@endsection