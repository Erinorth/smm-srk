@extends('layouts.print')

@section('title','Work at Hight')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-ตรวจสอบความเสียหายด้วยอากาศยานไร้คนขับ</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 1 / 1</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$drone->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$drone->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$drone->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$drone->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($drone->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$drone->Reference}}</td>
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
            <td colspan="5">ก่อนการขึ้นบิน (Before the flignt)</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>ตรวจสอบสภาพอากาศ ต้องไม่มีฝนฟ้าคะนอง กระแสลม ณ.ตำแหน่งขึ้นบิน ไม่เกิน 10 เมตร/วินาที</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>แจ้งผู้ควบคุมพื้นที่ และเปิด Work permit ขออนุญาติปฏิบัติงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>ตรวจสอบ Version ของ Fireware และ  Software ต้อง Update ล่าสุด และทำงานได้ปกติ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>ระดับของ Battery ก่อนขึ้นบินต้องเต็มและสภาพพร้อมใช้งาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>ตรวจสอบพื้นที่เก็บข้อมูลของ memory card ไม่น้อยกว่า 1 GB</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>ตรวจสอบสภาพของ Remote control ต้องใช้งาน และเชื่อมต่อกับตัว Drone ได้ปกติ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>วางแผนและกำหนดเป้าหมายการเก็บข้อมูลและตำแหน่งที่จะตรวจสอบให้ชัดเจน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td>ตรวจสอบสภาพและความเสียหายของตัว Drone ก่อนบิน ต้องไม่มีความเสียหายของอุปกรณ์</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>ตรวจสอบระดับของ Battery อยู่เสมอ และต้องไม่น้อยกว่า 20% </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">10</td>
            <td>ในระหว่างการบินให้ตรวจสอบสัญญานเตือนต่างๆอยู่เสมอ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">ระหว่างการบิน (During the flight)</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>เปิด Remote control และ Drone ให้เชื่อมต่อกันก่อน </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>เปิดการควบคุมที่ Remote control ก่อน Aircraft</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>ทดสอบการบินและการบังคับ Drone ตาม function ต่างๆให้ครบถ้วน ก่อนขึ้นปฏิบัติงานจริง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>เปิดการควบคุม Aircraft และสัญญาณไฟ indicator</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>Drone ต้องเชื่อมต่อกับดาวเทียม ไม่น้อยกว่า 13 ตำแหน่ง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>Calibrate compass และ ทดสอบทิศทางการบิน ต้องตรงกันกับการปรับตั้ง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>เปิด Mode ควบคุมให้อยู่ในตำแหน่ง P mode</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td>แจ้งบอกหน่วยงานหรือผู้ปฏิบัติงาน ที่ปฏิบัติงานอยู่ในพื้นที่ปฏิบัติงานให้ทราบก่อนการขึ้นบิน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>ตรวจสอบระดับของ Battery อยู่เสมอ และต้องไม่น้อยกว่า 20% </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">10</td>
            <td>ในระหว่างการบินให้ตรวจสอบสัญญานเตือนต่างๆอยู่เสมอ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">หลังการปฏิบัติงานแล้วเสร็จ (After the filght)</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>แจ้งผู้ควบคุมพื้นที่ และปิด Work permit</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>แจ้งบอกหน่วยงานหรือผู้ปฏิบัติงาน ที่ปฏิบัติงานอยู่ในพื้นที่ปฏิบัติงานให้ทราบว่าปฏิบัติงานแล้วเสร็จ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>ปริมาณไฟของ Battery เพื่อเก็บเข้าคลัง ไม่เกินกว่า 50%</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>ตรวจสอบสภาพของตัว Drone ต้องไม่มีจุดบกพร่องหรือเสียหาย</td>
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
                ( {{$drone->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$drone->Supervisor}} )<br>
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
