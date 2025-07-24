@extends('layouts.print')

@section('title','Confined Space')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานในสถานที่อับอากาศ</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 1 / 2</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$confinedspace->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$confinedspace->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$confinedspace->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$confinedspace->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($confinedspace->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$confinedspace->Reference}}</td>
        </tr>
        <tr>
            <td><h6>วันที่ปฏิบัติงานจริง</h6></td>
            <td></td>
            <td colspan="2"></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:4%"><h6>ลำดับที่</h6></td>
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
            <td>ตัดแยกสถานที่อับอากาศจาก ระบบจ่ายเชื้อเพลิง/สารเคมี ระบบไฟฟ้าและ ไฮดรอริก ก่อนปฏิบัติงาน</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td>ทางเข้า - ออก มีความกว้างเพียงพอ และไม่มีสิ่งกีดขวาง</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td>มีการกั้นเขตปฏิบัติงานพร้อมทั้งป้ายเตือน "ที่อับอากาศ อันตรายห้ามเข้า"</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">4</td>
            <td>บุคลากรการทำงานในสถานที่อับอากาศต้องได้รับการอบรมหลักสูตร ความปลอดภัยในการทำงานในสถานที่อับอากาศ ตามตำแหน่งที่รับผิดชอบ และมีใบรับรองสามารถทำงานในสถานที่อับอากาศจากแพทย์</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">5</td>
            <td>ผู้ปฏิบัติงานสวมใส่หรือใช้อุปกรณ์คุ้มครองความปลอดภัยส่วนบุคคล ที่ถูกต้องและเหมาะสม</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">6</td>
            <td>จัดอุปกรณ์ช่วยชีวิต เพียงพอและเหมาะสม (มีสายรัดตัว/เชือกช่วยชีวิต/อุปกรณ์ปฐมพยาบาล)</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">7</td>
            <td>แสงสว่างDC≤24V. เพียงพอ ซึ่งมีสภาพสมบูรณ์ / ปลอดภัย(กรณีมีสารไวไฟ ต้องป้องกันระเบิด)</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">8</td>
            <td colspan="4">
                มีบุคลากรการทำงานในสถานที่อับอากาศครบถ้วน(ผู้อนุญาต,ผู้ควบคุม,ผู้ปฏิบัติงาน,ผู้ช่วยเหลือ) : <br>
                ผู้อนุญาต <u>{{$confinedspace->Warrantor}}</u> <br>
                ผู้ควบคุมงาน <u>{{$confinedspace->Foreman}}</u> <br>
                <table class="table table-bordered table-sm">
                    <thead>
                        <th colspan="2" class="text-center">รายชื่อผู้ปฏิบัติงาน</th>
                        <th class="text-center">รายชื่อผู้เฝ้าระวังเหตุ</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:33%">1)</td>
                            <td style="width:34%">7)</td>
                            <td style="width:33%">1)</td>
                        </tr>
                        <tr>
                            <td>2)</td>
                            <td>8)</td>
                            <td>2)</td>
                        </tr>
                        <tr>
                            <td>3)</td>
                            <td>9)</td>
                            <td>3)</td>
                        </tr>
                        <tr>
                            <td>4)</td>
                            <td>10)</td>
                            <td>4)</td>
                        </tr>
                        <tr>
                            <td>5)</td>
                            <td>11)</td>
                            <td>5)</td>
                        </tr>
                        <tr>
                            <td>6)</td>
                            <td>12)</td>
                            <td>6)</td>
                        </tr>
                    </tbody>
                </table>
                บุคลากรการทำงานในสถานที่อับอากาศต้องได้รับการอบรมหลักสูตร ความปลอดภัยในการทำงานในสถานที่อับอากาศ ตามตำแหน่งที่รับผิดชอบ และตำแหน่งผู้ควบคุมงาน ผู้ปฏิบัติงาน และ ผู้ช่วยเหลือ ต้องมีสุขภาพแข็งแรงสมบูรณ์ มีใบรับรองสามารถทำงานในสถานที่อับอากาศจากแพทย์
            </td>
        </tr>
        <tr>
            <td class="text-center">9</td>
            <td colspan="4">
                ทำการตรวจวัดอากาศก่อนการเข้าทำงานทุกครั้ง (ตรวจวัดซ้ำเป็นระยะๆตามเจ้าของพื้นที่กำหนด) : ทำการตรวจวัดและระบุลงในช่องว่าง
                <table class="table table-bordered table-sm">
                    <thead>
                        <th class="text-center align-middle" style="width:14%">วัน/เดือน/ปี</th>
                        <th class="text-center align-middle" style="width:14%">เวลา</th>
                        <th class="text-center align-middle" style="width:14%">% อ๊อกซิเจน 19.5-23.5%</th>
                        <th class="text-center align-middle" style="width:14%">% ก๊าซไอละอองที่ติดไฟหรือระเบิดได้(HC)</th>
                        <th class="text-center align-middle" style="width:14%">ปริมาณฝุ่นที่ติดไฟหรื่อระเบิดได้ (ถ้าเกี่ยวข้อง) มิลลิกรัม/ลบ.เมตร</th>
                        <th class="text-center align-middle" style="width:14%">ปริมาณสารเคมีที่เป็นอันตรายต่อสุขภาพอื่นๆ (ถ้าเกี่ยวข้อง) PPM.</th>
                        <th class="text-center align-middle" style="width:16%">ลงชื่อผู้ตรวจสอบ</th>
                    </thead>
                    <tbody>
                        @while ($i<5)
                            <tr>
                                <td style="height:30px"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endwhile
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br>
                ( {{$confinedspace->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$confinedspace->Supervisor}} )<br>
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
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:66.4%"><h5>แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานในสถานที่อับอากาศ</h5></td>
            <td class="text-center align-middle" style="width:33%"><h6>หน้าที่ 2 / 2</h6></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td style="width:20%"><h6>หน่วยงาน/บริษัทที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$confinedspace->CompanyName}}</td>
            <td style="width:20%"><h6>พื้นที่ปฏิบัติงาน</h6></td>
            <td style="width:30%">{{$confinedspace->WorkingArea}}</td>
        </tr>
        <tr>
            <td><h6>ชื่องาน</h6></td>
            <td>{{$confinedspace->JobName}}</td>
            <td><h6>จำนวนผู้ปฏิบัติงาน</h6></td>
            <td>{{$confinedspace->Amount}}</td>
        </tr>
        <tr>
            <td><h6>วันที่เริ่มงานตามแผน</h6></td>
            <td>{{date('d-m-Y', strtotime($confinedspace->PlanedDate))}}</td>
            <td><h6>เอกสารอ้างอิงการปฏิบัติ</h6></td>
            <td>{{$confinedspace->Reference}}</td>
        </tr>
        <tr>
            <td><h6>วันที่ปฏิบัติงานจริง</h6></td>
            <td></td>
            <td colspan="2"></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:4%"><h6>ลำดับที่</h6></td>
            <td rowspan="2" class="text-center align-middle"><h6>มาตรการควบคุมความปลอดภัยของแต่ละงานวิกฤติ</h6></td>
            <td colspan="2" class="text-center align-middle"><h6>ผลการตรวจสอบมาตรการความปลอดภัย</h6></td>
            <td rowspan="2" class="text-center align-middle" style="width:12%"><h6>สิ่งที่พบ</h6></td>
        </tr>
        <tr>
            <td class="text-center align-middle" style="width:8%"><h6>ปฏิบัติ</h6></td>
            <td class="text-center align-middle" style="width:8%"><h6>ไม่ปฏิบัติ</h6></td>
        </tr>
        <tr>
            <td class="text-center">10</td>
            <td colspan="4">
                ผู้ปฏิบัติงานทุกคนที่เข้าไปในสถานที่อับอากาศต้องลงชื่อเข้าออกทุกครั้ง
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle" style="width:20%">ชื่อ - สกุล</th>
                            <th colspan="10" class="text-center align-middle">เวลา</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="width:8%">เข้า</th>
                            <th class="text-center" style="width:8%">ออก</th>
                            <th class="text-center" style="width:8%">เข้า</th>
                            <th class="text-center" style="width:8%">ออก</th>
                            <th class="text-center" style="width:8%">เข้า</th>
                            <th class="text-center" style="width:8%">ออก</th>
                            <th class="text-center" style="width:8%">เข้า</th>
                            <th class="text-center" style="width:8%">ออก</th>
                            <th class="text-center" style="width:8%">เข้า</th>
                            <th class="text-center" style="width:8%">ออก</th>
                        </tr>
                    </thead>
                    <tbody>
                        @while ($j<20)
                            <tr>
                                <td style="height:30px"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php
                                $j++;
                            @endphp
                        @endwhile
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td class="text-center" style="height:240px">11</td>
            <td colspan="4">แนวทางปฏิบัติในกรณีฉุกเฉิน</td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">
                <br>
                ....................................................<br>
                ( {{$confinedspace->Applicant}} )<br>
                ผู้ขออนุญาต
            </td>
            <td class="text-center" style="width:34%">
                <br>
                ....................................................<br>
                ( {{$confinedspace->Supervisor}} )<br>
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
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-012/QP-PB-031</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
@endsection