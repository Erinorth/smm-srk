@extends('layouts.print')

@section('title','Safety Check List')

@section('content')
    <div class="border-top border-left border-right border-bottom">
        <div class="row">
            <div class="col-4 border-left">
                <div class="row">
                    <div class="col-3 text-center border-left">
                        <br>
                        <img src="/img/EGAT.png" height="60">
                    </div>
                    <div class="col text-center">
                        <br>
                        <h5>การไฟฟ้าฝ่ายผลิตแห่งประเทศไทย <br>
                            รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</h5> <br>
                    </div>
                </div>
                <div class="row border-left">
                    <div class="col border-left">
                        ฝ่าย : <u>&emsp;&emsp;&emsp;อบค.&emsp;&emsp;&emsp;</u> <br>
                        กอง : <u>&emsp;&emsp;&emsp;กฟนม-ธ.&emsp;&emsp;&emsp;</u> <br>
                        แผนก : <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
                    </div>
                </div>
            </div>
            <div class="col-4 border-left">
                <div class="row">
                    <div class="col text-center border-bottom">
                        <br>
                        <h6>SAFETY CHECK LIST</h6>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <br>
                        Plant Name : <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br>
                        Equipment Name : <u>&emsp;&emsp;&emsp;-&emsp;&emsp;&emsp;</u><br>
                        Task : <u>&emsp;&emsp;&emsp;-&emsp;&emsp;&emsp;</u>
                    </div>
                </div>
            </div>
            <div class="col border-left">
                <br>
                Date : <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> to <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                PM Order : <u>&emsp;&emsp;&emsp;-&emsp;&emsp;&emsp;</u> <br>
                Plant-Unit : <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                Main. Type : <i class="far fa-square"></i> MO &emsp;<i class="far fa-square"></i> MI <br>
                &emsp;&emsp;&emsp;&emsp;&emsp;<i class="far fa-square"></i> CI &emsp;<i class="far fa-square"></i> WI &emsp;<i class="far fa-square"></i>Other
            </div>
        </div>
    </div>
    <br>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th colspan="2" rowspan="2" class="text-center">Check Items</th>
                <th rowspan="2" class="text-center">Normal Status</th>
                <th colspan="2" class="text-center">Check activities</th>
                <th rowspan="2" class="text-center" style="width: 30%">Remark</th>
            </tr>
            <tr>
                <th class="text-center">Do/ปกติ</th>
                <th class="text-center">Don't/ผิดปกติ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>1</th>
                <th>เปิดงาน/ Safety</th>
                <td style="width: 15%"></td>
                <td style="width: 11%"></td>
                <td style="width: 11%"></td>
                <td></td>
            </tr>
            <tr>
                <td>1.1</td>
                <td>แจ้งแรงงานจังหวัด</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.2</td>
                <td>ประเมินความเสี่ยง (FM-001/QP-PB-029)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.3</td>
                <td>แผนรองรับเหตุฉุกเฉิน</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.4</td>
                <td>ผลการประเมินสุขภาพลักษณะงานพิเศษ/ใบรับรองแพทย์</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.5</td>
                <td>ใบแต่งตั้ง/รับรองลักษณะงานพิเศษ</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.6</td>
                <td>กฎความปลอดภัยเฉพาะงาน/พื้นที่</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.7</td>
                <td>SMM Check List</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.8</td>
                <td>การรับรู้และการมีส่วนร่วม (FM-022/QP-PB)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.9</td>
                <td>แขวน Tag</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.10</td>
                <td>Work Permit (FM-010/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>1.11</td>
                <td>การควบคุมงานจ้าง (FM-001/QP-PB-027)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>2</th>
                <th>ตรวจสอบความพร้อมก่อนการปฏิบัติงาน</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2.1</td>
                <td>ตรวจสอบความพร้อมของร่างกาย</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>2.2</td>
                <td>ตรวจสอบ PPE</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>2.3</td>
                <td>ตรวจสอบเครื่องมือ, เครื่องมือพิเศษ</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>2.4</td>
                <td>ตรวจสอบวัสดุสิ้นเปลือง</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>3</th>
                <th>ปฏิบัติงาน</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3.1</td>
                <td>Safety Talk</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.2</td>
                <td>Safety Self Check</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.3</td>
                <td>งานที่ทำให้เกิดความร้อนหรือประกายไฟ (FM-011/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.4</td>
                <td>งานในที่อับอากาศ (FM-012/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.5</td>
                <td>งานยกของหนัก (FM-014/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.6</td>
                <td>งานบนที่สูง (นั่งร้าน) (FM-015/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.7</td>
                <td>งานบนที่สูง (กังหันลม) (FM-021/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.8</td>
                <td>งานประดาน้ำ (FM-020/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.9</td>
                <td>งานอื่นๆที่มีความเสี่ยงตั้งแต่ปานกลางขึ้นไป (FM-021/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>3.10</td>
                <td>การสังเกตการทำงาน (FM-024/QP-PB-031)</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>4</th>
                <th>ปิดงาน</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4.1</td>
                <td>ปิด Work Permit</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
            <tr>
                <td>4.2</td>
                <td>ปลด Tag</td>
                <td></td>
                <td><i class="far fa-square"></i> Done</td>
                <td><i class="far fa-square"></i> Not related</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="border-top border-left border-bottom border-right">
        <div class="row">
            <div class="col text-center">
                Checked  By : <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br><br>
                วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u>
            </div>
            <div class="col text-center border-left">
                Approved  By : <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br><br>
                วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u>
            </div>
            <div class="col text-center border-left">
                Witness By: <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br><br>
                วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u> / <u>&emsp;&emsp;&emsp;&emsp;</u>
            </div>
        </div>
    </div>
    <br>
    <div class="border-top border-left border-bottom border-right">
        <div class="row">
            <div class="col text-center">
                รองผู้ว่าการธุรกิจเกี่ยวเนื่อง
            </div>
            <div class="col text-center border-left">
                รหัสเอกสาร FM-026/QP-PB-031
            </div>
            <div class="col text-center border-left">
                แก้ไขครั้งที่ 00
            </div>
        </div>
    </div>
@endsection
