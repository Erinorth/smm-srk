@extends('layouts.print')

@section('title','Dangerous Zone')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-การปฏิบัติงานในพื้นที่อันตราย(3 จังหวัดชายแดนภาคใต้)</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 1 / 1</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$dangerouszone->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$dangerouszone->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$dangerouszone->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$dangerouszone->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($dangerouszone->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$dangerouszone->Reference}}</td>
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
            <td>รวมพลก่อนไปปฏิบัติงาน ณ จุดรวมพล</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>ตรวจสอบความพร้อมของ รปภ. ที่จะทำการคุ้มครองระหว่างการทำงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>จะต้องมีรถ รปภ. นำขบวนขณะเดินทาง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>ออกเดินทางไปพร้อมกันทั้งหมด</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>ตรวจสอบช่องทางการสื่อสาร หากมีเหตุฉุกเฉิน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>จะต้องมีรถพยาบาล Stand by ในบริเวณสถานที่ปฏิบัติงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>เมื่อมีเหตุจำเป็นต้องการออกจากพื้นที่ปฏิบัติงานในระหว่างการปฏิบัติงาน ต้องแจ้ง Commander หรือ ผู้ที่ควบคุมพื้นที่เท่านั้น</td>
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
                ( {{$dangerouszone->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$dangerouszone->Supervisor}} )<br>
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
