@extends('layouts.print')

@section('title','Work at Hight')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานในสถานที่สูง(กังหันลม)</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 1 / 2</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$workathightwind->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$workathightwind->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$workathightwind->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$workathightwind->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($workathightwind->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$workathightwind->Reference}}</td>
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
            <td>การปฏิบัติงานภายนอก Nacell จะต้องสวม Safety Harness ชนิด นิรภัยแบบเต็มตัว (full body harness) เท่านั้น และอุปกรณ์ที่นำมาใช้ ต้องมีมาตรฐานรับรอง เช่น ANSI A10.14-1991, Standard for Construction and Demolition Operations-,Requirements for Safety Belts, Harnesses, Lanyards and Lifelines for Construction and Demolition Use.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>การปฏิบัติงานด้านบนหลังคา Nacell จะต้องติดตั้ง เชือกช่วยชีวิตแบบหดกลับอัตโนมัติ (Retractable lifelines) ด้วย</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>การเข้าปฏิบัติงานใน hub ที่ไม่มีการ์ดป้องกัน จะต้องติดตั้ง electric winc ด้วย</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>ผู้ปฏิบัติงานที่ขึ้นกังหันลมผลิตไฟฟ้าที่มีระดับความสูงเกิน 4 เมตร ต้องผ่านการอบรมการทำงานบนที่สูง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>ในขณะที่มีพายุฝนตก ห้ามมิให้มีการทำงาน บนกังหันลมผลิตไฟฟ้า</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>ก่อนที่จะปฏิบัติงานบนกังหันลมผลิตไฟฟ้า จะต้องผ่านการตรวจสอบและอนุญาตจากเจ้าหน้าที่โรงไฟฟ้าเจ้าของพื้นที่</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>จำนวนผู้ปฏิบัติงานที่ขึ้นโดยสารลิฟต์ไปปฏิบัติงานไม่เกินความสามารถของนั่งลิฟต์ที่รับได้</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td>อุปกรณ์ที่นำขึ้นทางลิฟต์ต้องมีน้ำหนักไม่เกินความสามารถของนั่งลิฟต์ที่รับได้</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>ก่อนที่จะปฏิบัติงานบนกังหันลมผลิตไฟฟ้า จะต้องผ่านการตรวจสอบความดันโลหิตก่อน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">รายการตรวจสอบก่อนปีนขึ้นบันไดและลิฟต์เพื่อปฏิบัติงานระหว่าง tower และ nacel</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>หากพบจุดยึดบันไดมีรอยแตกร้าวใหยุดการขึ้นทันทีและแจ้งซ่อมแซมก่อน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>หากพบน้อตยึดบันไดมีการคลายให้หุดการขึ้นทันทีและแก้ไข</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>Safety Harness ชนิด นิรภัยแบบเต็มตัว (full  body harness) ไม่มีรอยฉีกขาด แตกหรือตำหนิที่มีผลต่อการใช้งาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>Safety Harness ชนิด นิรภัยแบบเต็มตัว (full  body harness) ไม่เคยผ่านการตกกระชากขณะใช้งานมาก่อน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>สวมใส่ Safety Harness ชนิด นิรภัยแบบเต็มตัว (full  body harness) ถูกวิธี</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>ทดสอบ Safety Harness ที่สวมใส่โดยการทิ้งตัวลงจากบันไดขั้นที่ 2-3</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>ไม่ปีนออกจากลิฟต์มาขึ้นบันไดถ้าไม่จำเป็น</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td>ตรวจสอบระบบเบรกของลิฟต์ก่อนเริ่มงานโดยการปลดเบรกลงในระยะขึ้น 1 เมตร</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>ตรวจสอบระบบควบคุมของลิฟต์ก่อนเริ่มงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">10</td>
            <td>ผู้ปฏิบัติงานต้องอบรมการใช้งานลิฟต์ก่อนทุกครั้ง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">รายการตรวจสอบก่อนเข้าปฏิบัติงานใน Hub ที่ไม่มีการ์ดป้องกัน</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>มีการล็อกใบกังหันก่อนทุกครั้ง และปิดล้อกการสั่งงานระบบ pitch อย่างเคร่งครัด</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>เตรียมอุปกรณ์สื่อสารที่ชัดเจน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>Safety Harness ชนิด นิรภัยแบบเต็มตัว (full  body harness) ไม่มีรอยฉีกขาด แตก หรือตำหนิที่มีผลต่อการใช้งาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>Safety Harness ชนิด นิรภัยแบบเต็มตัว (full  body harness) ไม่เคยผ่านการตกกระชากขณะใช้งานมาก่อน</td>
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
                ( {{$workathightwind->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$workathightwind->Supervisor}} )<br>
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
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-021/QP-PB-031</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานในสถานที่สูง(กังหันลม)</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 2 / 2</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$workathightwind->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$workathightwind->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$workathightwind->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$workathightwind->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($workathightwind->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$workathightwind->Reference}}</td>
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
            <td colspan="5">รายการตรวจสอบก่อนเข้าปฏิบัติงานใน Hub ที่ไม่มีการ์ดป้องกัน (ต่อ)</td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>สวมใส่ Safety Harness ชนิด นิรภัยแบบเต็มตัว (full  body harness) ถูกวิธี</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>จุดยึดสำหรับติดตั้ง electric winc หรือ เชือกช่วยชีวิตแบบหดกลับอัตโนมัติ (Retractablelifelines) ต้องรับน้ำหนักได้ไม่น้อยกว่า 200 kg.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>เชือกสำหรับใช้งานร่วมกับ electric winc ต้องไม่พบรอยขาด</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td>ก่อนทิ้งน้ำหนักตัวลงบนราวรับน้ำหนักเพื่อยืนเปิด man hole จะต้องมั่นคงแข็งแรง ไม่รู้สึกถึงการหลุด หลวมคลอน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>การส่งลำเลียงอุปกรณ์เข้าสู่ hub มีการผูกเชือกให้แน่นหนาทุกครั้ง</td>
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
                ( {{$workathightwind->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$workathightwind->Supervisor}} )<br>
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
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-021/QP-PB-031</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
@endsection
