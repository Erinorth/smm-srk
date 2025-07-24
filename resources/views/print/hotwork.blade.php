@extends('layouts.print')

@section('title','Hot Work')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานที่คาดว่าอาจทำให้เกิดความร้อนหรือมีประกายไฟ</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 1 / 1</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$hotwork->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$hotwork->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$hotwork->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$hotwork->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($hotwork->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$hotwork->Reference}}</td>
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
            <td>ผู้ปฏิบัติงานต้องสวมเสื้อผ้า ไม่เปื้อนน้ำมันหรือจาระบี และห้ามพับแขนเสื้อในขณะทำงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>ผู้ปฏิบัติงานสวมใส่อุปกรณ์ความปลอดภัยส่วนบุคคลเพิ่มเติมตามลักษณะของงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>การเชื่อมหรือตัดภาชนะบรรจุสารไวไฟทุกครั้ง ต้องถ่ายและล้างทำความสะอาดสารไวไฟที่ตกค้างอยู่ในภาชนะแล้วระบายอากาศภายในภาชนะจนแน่ใจว่าไม่มีสารไวไฟ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>จัดเตรียมเครื่องดับเพลิงประเภท Multi Purpose (A,B,C) ตามขนาดไม่ต่ำกว่า 15lb/ 6A 20B หรือตามที่โรงไฟฟ้าเจ้าของพื้นที่กำหนดประจำแต่ละจุดที่มีงานก่อให้เกิดประกายไฟ</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>จะต้องมีการบ่งบอกพื้นที่ทำงานให้เห็นชัดเจน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>ตรวจสอบสภาพพื้นที่ปฏิบัติงาน และ พื้นที่ด้านล่าง ต้องไม่มีวัสดุที่ติดไฟได้จะกระเด็นไปถึง โดยให้ทำการเคลื่อนย้ายวัสดุที่ติดไฟออก หรือต้องการป้องกันสะเก็ดไฟจากงานเชื่อมและตัดแก๊ส โดยวิธี</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td> - กั้นเป็นคอกโดยใช้ผ้ากันไฟกั้น</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td> - ป้องกันโดยการใช้น้ำฉีดเลี้ยง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td>มีการระบายอากาศ กรณีทำงานเชื่อม/งานตัด ในที่อับอากาศ อย่างเหมาะสม</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">10</td>
            <td>สายไฟฟ้าเชื่อมจากเครื่องเชื่อม สายออกซิเจน หรือโพรเพน หรืออะซิทีลีน ถ้าต่อไกลผ่านทางถนนต้องมีไม้วางพาดสองข้างกันรถหรือเครื่องจักรทับหรือยกสายขึ้นสูงเหนือสิ่งที่วิ่งรอดผ่าน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">เชื่อมแก๊ส ตัดแก๊ส,เผา และถังแก๊ส (สำหรับเครื่องมือ เครื่องใช้)</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>ห้ามเก็บถังก๊าซไว้ใกล้อุปกรณ์ที่ร้อนหรือในที่ๆ มีอุณหภูมิสูงหรือไปสัมผัสกับวงจรไฟฟ้าหรือใกล้ของคนอื่นที่อาจตกลงมาทับได้</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>ต้องตั้งถังแก๊สและมีเข็มขัด หรือเชือกผูกมัดให้มั่นคงระหว่างการใช้งานและต้องใส่ฝา Safety Cap ครอบไว้เมื่อไม่ได้ต่อสายใช้</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>ห้ามเคลื่อนย้ายถังก่อนถอดหัวปรับความดันออก (Pressure regulator) เว้นแต่ลำเลียงขึ้นบนรถที่ออกแบบเป็นพิเศษโดยเฉพาะและให้ใส่ฝาครอบทันทีที่ถอดหัวปรับความดันออก</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5">เครื่องเชื่อมแบบไฟฟ้า (Arc welding equipment)</td>
        </tr>
        <tr>
            <td class="text-center">1</td>
            <td>สายเชื่อมที่เป็นสายดินจากเครื่องเชื่อมต้องต่อให้แน่นบนชิ้นงานที่เชื่อม ห้ามอาศัยโครงสร้าง เหล็กท่อร้อยสายไฟฟ้า สายเดินระบบไฟฟ้า,มอเตอร์เป็นส่วนของทางเดินไฟฟ้า</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>การต่อและตัดตู้เชื่อมเข้ากับแหล่งจ่ายไฟ ต้องตัดกระแสไฟที่จ่ายออกมาก่อน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>เวลาที่หยุดการเชื่อม/ตัดหรือเวลาหยุดพัก ต้องตัดกระแสไฟฟ้าหรือดับเครื่องก่อน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>เมื่อมีการหยุดงานชั่วคราวจะต้องปลดหัวขั้วเชื่อมออกเสมอและปลด Cut-Out ลงทุก</td>
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
                ( {{$hotwork->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$hotwork->Supervisor}} )<br>
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
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-011/QP-PB-031</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 00</td>
        </tr>
    </table>
@endsection