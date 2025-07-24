@extends('layouts.print')

@section('title','Observation')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="8" class="text-center" style="width:100%;"><h5>แบบฟอร์มการสังเกตการทำงาน สายงาน รวธ.</h5></td>
        </tr>
        @foreach ($observation as $value)
            <tr>
                <td colspan="8" style="line-height:200%">
                    ผู้สังเกตการทำงาน <br>
                    ชื่อ - สกุล <u>{{ $value->ThaiName }}</u> หมายเลขประจำตัว <u>{{ $value->WorkID }}</u><br>
                    ตำแหน่ง <u>{{ $value->Position }}</u> แผนก <u>{{ $value->Section }}</u> กอง <u>{{ $value->Department }}</u> ผ่าย <u>{{ $value->Division }}</u>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="line-height:200%">
                    ชื่องานที่สังเกต <u>{{$value->LocationName}}//{{$value->MachineName}}//{{$value->Remark}}//{{$value->ProductName}}//{{$value->SystemName}}//{{$value->SpecificName}}//{{$value->ScopeName}}</u> ** ชื่องานตาม FM-001/QP-PB-029 <br>
                    งานของแผนก <u>หบนม-ธ.</u> กอง <u>กฟนม-ธ.</u> ฝ่าย <u>อบค.</u><br>
                    ผู้ปฏิบัติงาน  <i class="far fa-square"></i> ผู้ปฏิบัติงาน กฟผ.  <i class="far fa-square"></i> ผู้รับเหมา จำนวนผู้ปฏิบัติงานที่ถูกสังเกต <u>&emsp;&emsp;&emsp;&emsp;</u> คน <br>
                    วันที่สังเกต <u>{{ $value->Date }}</u> ช่วงเวลาที่สังเกต <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5">
                1.สังเกต => 2.กล่าวชมเชย => 3.พูดคุย => 4.สรุปร่วมกัน =>5.สอบถามประเด็นอื่น => 6.กล่าวขอบคุณ
            </td>
            <td colspan="3">
                กรอกเครื่องหมาย <i class="fas fa-check"></i> ลงในช่อง <i class="far fa-square"></i>
            </td>
        </tr>
        <tr>
            <td class="bg-green" style="width:26%;">การใช้อุปกรณ์ป้องกันอันตรายส่วนบุคคล</td>
            <td class="bg-green text-center" style="width:8%">ไม่เกี่ยวข้อง</td>
            <td class="bg-green text-center" style="width:8%">ปลอดภัย</td>
            <td class="bg-green text-center" style="width:8%">ไม่ปลอดภัย</td>
            <td colspan="2" class="bg-blue" style="width:34%">กฎความปลอดภัยฯ ที่เกี่ยวข้อง (ระบุ)</td>
            <td class="bg-blue text-center" style="width:8%">ปฏิบัติ</td>
            <td class="bg-blue text-center" style="width:8%">ไม่ปฏิบัติ</td>
        </tr>
        <tr>
            <td>หมวก,รองเท้า,แว่นตา,อุปกรณ์ป้องกันใบหน้า</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">1</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>อุปกรณ์ป้องกันการได้ยิน</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">2</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>อุปกรณ์ป้องกันทางเดินหายใจ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">3</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>ชุดปฏิบัติงาน, ชุดป้องกันสารเคมี, ถุงมือ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">4</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>อุปกรณ์ป้องกันการตกจากที่สูง</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">5</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>อื่นๆ <u></u></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">6</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td class="bg-green">ตำแหน่งและท่าทางการทำงาน</td>
            <td class="bg-green text-center">ไม่เกี่ยวข้อง</td>
            <td class="bg-green text-center">ปลอดภัย</td>
            <td class="bg-green text-center">ไม่ปลอดภัย</td>
            <td colspan="2" class="bg-blue">คู่มือ/วิธีปฏิบัติงาน ที่เกี่ยวข้อง (ระบุ)</td>
            <td class="bg-blue text-center">ปฏิบัติ</td>
            <td class="bg-blue text-center">ไม่ปฏิบัติ</td>
        </tr>
        <tr>
            <td>การกระทบกับวัตถุ  หรือ ถูกวัตถุมากระทบ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">1</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>การติดอยู่ด้านใน บน หรือระหว่างวัตถุ(หนีบ)</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">2</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>การตกจากที่สูง/ ต่างระดับ / ลื่น</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">3</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>การสัมผัสกระแสไฟฟ้า</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="2">4</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>การสัมผัสอุณหภูมิที่สูง หรือต่ำเกินไป</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td rowspan="4" class="bg-yellow" style="width:26%">กรณีงานที่สังเกตการทำงานเป็นงานวิกฤตตามกฎหมาย และเป็นงานที่มีความเสี่ยงในระดับปานกลาง ต้องมีใบรับรองการตรวจสอบความปลอดภัย</td>
            <td rowspan="4" class="bg-yellow text-center" style="width:8%">ไม่เกี่ยวข้อง</td>
            <td rowspan="4" class="bg-yellow text-center">ปฏิบัติ</td>
            <td rowspan="4" class="bg-yellow text-center">ไม่ปฏิบัติ</td>
        </tr>
        <tr>
            <td>การสัมผัส สูดดม สารเคมี</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>ท่าทางฝืนธรรมชาติ และการเคลื่อนไหวซ้ำๆ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>สายตาอยู่ที่ชิ้นงานตลอดเวลา ไม่เหม่อลอย</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td class="bg-green">อุปกรณ์และเครื่องมือ</td>
            <td class="bg-green text-center">ไม่เกี่ยวข้อง</td>
            <td class="bg-green text-center">ปลอดภัย</td>
            <td class="bg-green text-center">ไม่ปลอดภัย</td>
            <td>1. งานที่ทำให้เกิดความร้อนหรือประกายไฟ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>อุปกรณ์และเครื่องมือเหมาะกับงาน</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>2. งานในสถานที่อับอากาศ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>การปฏิบัติตามขั้นตอนการใช้</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>3. งานเกี่ยกับสารเคมีอันตราย</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>สภาพของอุปกรณ์และเครื่องมือ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>4. งานยกของด้วยอุปกรณ์ยกของหนัก</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>อุปกรณ์ความปลอดภัยของอุปกรณ์</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>5. งานในสถานที่สูง(นั่งร้าน)</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>ปิด/ตัดแหล่งจ่ายไฟ เมื่อไม่ใช้งาน</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>6. งานเกี่ยวกับไฟฟ้า</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td class="bg-green">สภาพแวดล้อม/พื้นที่ ปฏิบัติงาน</td>
            <td class="bg-green text-center">ไม่เกี่ยวข้อง</td>
            <td class="bg-green text-center">ปลอดภัย</td>
            <td class="bg-green text-center">ไม่ปลอดภัย</td>
            <td>7. ปฏิบัตงานเกี่ยวกับอุปกรณ์ไฟฟ้าแรงสูง</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>พื้นปฏิบัติงานสะอาด ไม่ลื่น ไม่เสี่ยงพลัดตก</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>8. งานที่ต้องมีการขุดหรือเจาะ พื้นดินฯ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>กั้นพื้นที่,ป้ายเตือน บริเวณทำงานที่อันตราย</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>9. ปฏิบัติงานเกี่ยวกับกัมตภาพรังสี</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>แสง เสียง ความร้อน ฝุ่น สารเคมี เหมาะสม</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>10.งานประดาน้ำ</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>ความพร้อมของอุปกรณ์ดับเพลิงเคลื่อนที่</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>11.</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>ปราศจากจุดแหลม,คม,ผิวร้อน,หนีบ,กระแทก</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td>12.</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td class="bg-green">ยานพาหนะและอุปกรณ์เคลื่อนที่</td>
            <td class="bg-green text-center">ไม่เกี่ยวข้อง</td>
            <td class="bg-green text-center">ปลอดภัย</td>
            <td class="bg-green text-center">ไม่ปลอดภัย</td>
            <td colspan="2" rowspan="2" class="bg-red">สรุปผลการสังเกตการทำงาน (หลังจากพูดคุยและให้ผู้ปฏบัติงานดำเนินการแก้ไขตามที่แนะนำแล้วเสร็จ)</td>
            <td class="bg-red text-center">ปลอดภัย</td>
            <td class="bg-red text-center">ไม่ปลอดภัย</td>
        </tr>
        <tr>
            <td>สภาพความพร้อมและการบำรุงรักษา</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>ความปลอดภัยในการขับขี่ / เคลื่อนที่</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td colspan="4" rowspan="3" style="line-height:200%; width:50%;">
                สิ่งที่ต้องดำเนินการออก CAR/PAR ตาม QP-PB-018 <br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
        <tr>
            <td>การปฏิบัติตามขั้นตอนการใช้</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td>คาดเข็มขัดนิรภัย</td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
            <td class="text-center"><i class="far fa-square"></i></td>
        </tr>
        <tr>
            <td colspan="8" style="line-height:200%">
                ข้อเสนอแนะจากการสังเกตุการทำงานเพื่อปรับปรุง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
            </td>
        </tr>
        <tr>
            <td colspan="8">
                ข้อแนะนำ 1. ให้ใช้เวลาในการทำ พื้นที่ละอย่างน้อย 30 นาที &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; 2. พูดคุยกับผู้ปฏิบัติงานอย่างน้อย 5 นาที <br>
                &emsp;&emsp;&emsp;&emsp;&nbsp;3. รายการสังเกตงานใดที่ไม่เกี่ยวข้องใช้เช็คในช่อง "ไม่เกี่ยวข้อง" &emsp;&emsp; 4. โปรดใช้ 1 แบบฟอร์มต่อการสังเกตงาน 1 ครั้งต่อ 1 งาน/พื้นที่
            </td>
        </tr>
        <tr>
            <td colspan="8">
                ต้นฉบับ : พื้นที่/งาน ในสำนักงานและอาคารปฏิบัติการ นำส่ง Site manager หรือผู้บังคับบัญชาสูงสุดของหน่วยงานที่ไปปฏิบัติงาน เพื่อคัดแยกส่งไปยังหัวหน้าแผนกของ พื้นที่/งาน <br>
                &emsp;&emsp;&emsp;&ensp;&nbsp;ที่ถูกสังเกตการทำงาน <br>
                &emsp;&emsp;&emsp;&nbsp;: พื้นที่/งาน ในสำนักงานและอาคารปฏิบัติการนำส่งหัวหน้าแผนกของ พื้นที่/งาน ที่ถูกสังเกตการทำงาน
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:33%">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td class="text-center" style="width:34%">รหัสเอกสาร FM-024/QP-PB-031</td>
            <td class="text-center" style="width:33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
@endsection
