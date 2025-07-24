@extends('layouts.print')

@section('title','ISO Weekly Report')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle" style="width:25%"><h4>ISO Weekly Report</h4></td>
            <td colspan="2"> Project : {{ $project->ProjectName }} </td>
        </tr>
        <tr>
            <td style="width:32.5%"> Start Date : {{date('d-m-Y', strtotime($project->StartDate))}}</td>
            <td style="width:32.5%"> Finish Date : {{date('d-m-Y', strtotime($project->FinishDate))}}</td>
        </tr>
    </table>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th class="text-center">หัวข้อการประเมิน</th>
                <th class="text-center">เป้าหมาย</th>
                <th class="text-center">ผลการปฏิบัติ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><u>การประเมินความเสี่ยง (FM-001/QP-PB-029) <br></u>
                    ให้จัดทำก่อนเริ่มงาน และทุกครั้งที่มีการเปลี่ยนแปลง <br>
                    1.	ประเมินแหล่งกำเนินอันตรายที่เกี่ยวข้องใน https://hpddatabase.xyz/item_hazards/xxxx/create <br>
                    2.	พิมพ์แบบฟอร์มการประเมินความเสี่ยงใน https://hpddatabase.xyz/risk/xxxx <br>
                    3.	ลงนามผู้ประเมิน และผู้ทบทวน <br>
                    4.	จัดเก็บในระบบ ECP ใน 01. ก่อนการปฏิบัติงาน\การประเมินความเสี่ยง <br>
                    5.	พิมพ์แบบฟอร์ม มาตรการควบคุมความเสี่ยงในงาน https://hpddatabase.xyz/controlmeasure_project/xxxx <br>
                    6.	ผู้ปฏิบัติงานและผู้ควบคุมงานลงนาม <br>
                    7.	จัดเก็บสำเนาในระบบ ECP ใน 01. ก่อนการปฏิบัติงาน\การประเมินความเสี่ยง <br>
                    8.	ตัวจริงให้ผู้ปฏิบัติงานเก็บไว้เพื่อนำไปปฏิบัติตามมาตรการอย่างเคร่งครัด <br>
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->RiskPlan}}</td>
                    <td class="text-center">{{$value->RiskActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>ใบรับรองความรู้ความสามารถ และใบตรวจสุขภาพสำหรับลักษณะงานพิเศษ<br></u>
                    ให้รวบรวมและตรวจสอบคุณสมบัติของผู้ปฏิบัติงานก่อนเริ่มงานทุกครั้ง <br>
                    1.	จัดเก็บใบรับรองการตรวจสุขภาพลักษณะงานพิเศษในระบบ ECP ใน 01. ก่อนการปฏิบัติงาน\ใบตรวจสุขภาพลักษณะงานพิเศษ <br>
                    2.	จัดเก็บใบรับรองใบรับรองความรู้ความสามารถ ECP ใน 01. ก่อนการปฏิบัติงาน\ใบรับรองความรู้ความสามารถที่จำเป็น
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->ManCertificatePlan}}</td>
                    <td class="text-center">{{$value->ManCertificateActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>ใบรับรองการสอบเทียบเครื่องมือวัดละเอียด<br></u>
                    ให้รวบรวมและตรวจสอบใบรับรองการสอบเทียบเครื่องมือวัดละเอียดก่อนเริ่มงานทุกครั้ง <br>
                    1.	จัดเก็บใบรับรองการตรวจสุขภาพลักษณะงานพิเศษในระบบ ECP ใน 01. ก่อนการปฏิบัติงาน\ใบรับรองเครื่องมือ
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->ToolCertificatePlan}}</td>
                    <td class="text-center">{{$value->ToolCertificateActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>HRPD Check List <br></u>
                    ให้จัดทำทุกงาน <br>
                    1.	ใส่ข้อมูลต่างๆใน https://hpddatabase.xyz/jobs/xxxx <br>
                    2.	พิมพ์แบบฟอร์มใน https://hpddatabase.xyz/checklist/xxxx/xxxx <br>
                    3.	นำเอกสารไปดำเนินการ <br>
                    4.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\Check List (หากมีการปรับปรุงให้ปรับปรุงข้อมูลใน https://hpddatabase.xyz/jobs/xxxx)
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->CheckListPlan}}</td>
                    <td class="text-center">{{$value->CheckListActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>การรับรู้และการมีส่วนร่วม (FM-022/QP-PB-031 และ FM-001/QP-PB- 036) <br></u>
                    ให้จัดทำเมื่อมีการชี้แจงนโยบาย เป้าหมาย ความเสี่ยง และมาตรการการจัดการความเสี่ยงใหม่หรือมีการเปลี่ยนแปลงทุกครั้ง <br>
                    1.	ชี้แจงนโยบาย เป้าหมาย ความเสี่ยง และมาตรการการจัดการความเสี่ยง <br>
                    2.	จัดทำเอกสารแบบฟอร์มการลงชื่อรับทราบ และ แบบฟอร์มชี้แจงและทำความเข้าใจมาตรการความปลอดภัยและกฎระเบียบความปลอดภัยก่อนเริ่มงาน สายงาน รวธ. <br>
                    3.	ผู้เกี่ยวข้องลงนามรับทราบ <br>
                    4.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\การรับรู้และการมีส่วนร่วม
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->ParticipationPlan}}</td>
                    <td class="text-center">{{$value->ParticipationActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>แบบรายงาน การดำเนินงานของเจ้าหน้าที่ความปลอดภัยประจำวัน (Safety Report) <br></u>
                    ให้จัดทำทุกวันจันทร์ พุธ ศุกร์ <br>
                    1.	จัดทำเอกสาร แบบรายงาน การดำเนินงานของเจ้าหน้าที่ความปลอดภัยประจำวัน (Safety Report) <br>
                    2.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\Safety Report
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->SafetyReportPlan}}</td>
                    <td class="text-center">{{$value->SafetyReportActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>แบบบันทึกการสนทนาความปลอดภัย ก่อนเริ่มงาน (Safety Talk Record) <br></u>
                    ให้จัดทำทุกวัน <br>
                    1.	นำ แบบฟอร์มการประเมินความเสี่ยง และ Check List ที่เกี่ยวข้องกับงานในวันนี้มาทบทวนและชี้แจงให้ผู้ปฏิบัติงานทำความเข้าใจและปฏิบัติตามมาตรการ <br>
                    2.	จัดทำเอกสาร แบบบันทึกการสนทนาความปลอดภัย ก่อนเริ่มงาน (Safety Talk Record) <br>
                    3.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\Safety Talk
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->SafetyTalkPlan}}</td>
                    <td class="text-center">{{$value->SafetyTalkActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>Work Permit (FM-010/QP-PB-031) <br></u>
                    ให้จัดทำทุกครั้งที่มีการปฏิบัติงาน <br>
                    1.	จัดทำ แบบฟอร์มอนุญาตให้ปฏิบัติงาน สายงานรองผู้ว่าการธุรกิจเกี่ยวเนื่อง (รวธ.) (หากลูกค้าจะใช้อฟอร์มของลูกค้าเองให้ทำ 2 ฉบับคู่กัน) <br>
                    2.	นำไปเปิดงานกับผู้ที่เกี่ยวข้อง ลงนาม และรายละเอียดในเอกสารให้ครบถ้วน (หากใช้ฟอร์มของลูกค้าด้วยจะต้องตรวจสอบรายละเอียดที่สำคัญให้มีเนื้อหาที่ตรงกัน) <br>
                    3.	ถ่ายสำเนาไปแปะที่หน้าสถานที่ปฏิบัติงาน (หากใช้ฟอร์มของลูกค้าด้วยให้นำของ รวธ. ไปแปะที่หน้าสถานที่ปฏิบัติงาน ส่วนของลูกค้าให้ลูกค้าเก็บไว้) <br>
                    4.	เมื่อปฏิบัติงานแล้วเสร็จให้นำสำเนาที่แปะไว้หน้าสถานที่ปฏิบัติงานไปปิดงานกับผู้ที่เกี่ยวข้อง และรายละเอียดในเอกสารให้ครบถ้วน(หากใช้ฟอร์มของลูกค้าด้วยจะต้องตรวจสอบรายละเอียดที่สำคัญให้มีเนื้อหาที่ตรงกัน) <br>
                    5.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\Work Permit (หากใช้ฟอร์มของลูกค้าด้วยจะจัดเก็บเฉพาะของ รวธ. หรือจัดเก็บฟอร์มของลูกค้าด้วยก็ได้)
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->WorkPermitPlan}}</td>
                    <td class="text-center">{{$value->WorkPermitActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>งานที่ทำให้เกิดความร้อนหรือประกายไฟ (FM-011/QP-PB-031) <br></u>
                    ให้ดำเนินการตรวจสอบก่อนปฏิบัติงานทุกครั้ง <br>
                    1.	แจ้ง Safety และผู้ควบคุมพื้นที่ <br>
                    2.	เพิ่มข้อมูลใน https://hpddatabase.xyz/hotworks/xxxx/create <br>
                    3.	พิมพ์แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานที่คาดว่าอาจทำให้เกิดความร้อนหรือมีประกายไฟใน https://hpddatabase.xyz/hotwork/xxxx <br>
                    4.	นำไปดำเนินการและให้ผู้เกี่ยวข้องลงนาม <br>
                    5.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\ปฏิบัติงานที่ทำให้เกิดความร้อนหรือประกายไฟ
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->HotWorkPlan}}</td>
                    <td class="text-center">{{$value->HotWorkActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>งานในที่อับอากาศ (FM-012/QP-PB-031) <br></u>
                    ให้ดำเนินการตรวจสอบก่อนปฏิบัติงานทุกครั้ง <br>
                    1.	แจ้ง Safety และผู้ควบคุมพื้นที่ <br>
                    2.	เพิ่มข้อมูลใน https://hpddatabase.xyz/confinespaces/xxxx/create <br>
                    3.	พิมพ์แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานในสถานที่อับอากาศ ใน https://hpddatabase.xyz/confinespace/xxxx <br>
                    4.	นำไปดำเนินการและให้ผู้เกี่ยวข้องลงนาม <br>
                    5.	นำเอกสารไปติดไว้ที่หน้าสถานที่ปฏิบัติงาน โดยให้ผู้ที่เข้าไปปฏิบัติงานลงชื่อเข้า-ออกทุกครั้ง และให้หัวหน้างานคอยตรวจสอบผู้ที่จะเข้าไปทำงานในที่อับอากาศว่าผ่านการอบรม และตรวจสุขภาพหรือไม่ <br>
                    6.	เมื่อเลิกงานให้หัวหน้างานตรวจสอบเอกสารและภายในสถานที่อับอากาศว่ามีผู้ปฏิบัติงานตกค้างอยู่หรือไม่ และเก็บเอกสารออกจากหน้าสถานที่ปฏิบัติงานพร้อมทั้งกั้นห้ามเข้าสถานที่อับอากาศ <br>
                    7.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\ปฏิบัติงานในที่อับอากาศ
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->ConfinedSpacePlan}}</td>
                    <td class="text-center">{{$value->ConfinedSpaceActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>งานยกของหนัก (FM-014/QP-PB-031) <br></u>
                    ให้ดำเนินการตรวจสอบก่อนปฏิบัติงานทุกครั้ง <br>
                    1.	แจ้ง Safety และผู้ควบคุมพื้นที่ <br>
                    2.	เพิ่มข้อมูลใน https://hpddatabase.xyz/liftings/xxxx/create <br>
                    3.	พิมพ์แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานยกของด้วยอุปกรณ์ยกของหนักใน https://hpddatabase.xyz/lifting/xxxx <br>
                    4.	นำไปดำเนินการและให้ผู้เกี่ยวข้องลงนาม <br>
                    5.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\ปฏิบัติงานยกของหนัก
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->LiftingPlan}}</td>
                    <td class="text-center">{{$value->LiftingActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>งานบนที่สูง (นั่งร้าน) (FM-015/QP-PB-031) <br></u>
                    ให้ดำเนินการตรวจสอบก่อนปฏิบัติงานทุกครั้ง <br>
                    1.	แจ้ง Safety และผู้ควบคุมพื้นที่ <br>
                    2.	เพิ่มข้อมูลใน https://hpddatabase.xyz/workathights/xxxx/create <br>
                    3.	พิมพ์แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานในสถานที่สูง(นั่งร้าน)https://hpddatabase.xyz/workathight/xxxx <br>
                    4.	นำไปดำเนินการและให้ผู้เกี่ยวข้องลงนาม <br>
                    5.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\ปฏิบัติงานในที่สูง(นั่งร้าน)
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->ScaffoldingPlan}}</td>
                    <td class="text-center">{{$value->ScaffoldingActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>งานบนที่สูง (กังหันลม) (FM-021/QP-PB-031) <br></u>
                    ให้ดำเนินการตรวจสอบก่อนปฏิบัติงานทุกครั้ง <br>
                    1.	แจ้ง Safety และผู้ควบคุมพื้นที่ <br>
                    2.	เพิ่มข้อมูลใน https://hpddatabase.xyz/workathightwinds/xxxx/create <br>
                    3.	พิมพ์แบบฟอร์มการตรวจสอบความปลอดภัยงานวิกฤติ-งานในสถานที่สูง(กังหันลม)https://hpddatabase.xyz/workathightwind/xxxx <br>
                    4.	นำไปดำเนินการและให้ผู้เกี่ยวข้องลงนาม <br>
                    5.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\ปฏิบัติงานในที่สูง(กังหันลม)
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->WindTurbinePlan}}</td>
                    <td class="text-center">{{$value->WindTurbineActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>การควบคุมงานจ้าง (FM-001/QP-PB-027) <br></u>
                    ให้จัดทำเมื่อมีการควบคุมงานจ้างทุกครั้ง <br>
                    1.	จัดทำเอกสารควบคุมงานจ้างเหมางาน <br>
                    2.	นำเข้าใช้งาน <br>
                    3.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\การควบคุมงาน
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->SubcontractorPlan}}</td>
                    <td class="text-center">{{$value->SubcontractorActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>สิ่งที่ไม่เป็นไปตามข้อกำหนด (FM-001/QP-PB-028) <br></u>
                    ให้จัดทำเมื่อเกิดสิ่งที่ไม่เป็นไปตามข้อกำหนด เช่น การเปลี่ยนแปลงเวลาการส่งมอบ การใช้ spare part หรือการตั้งค่าไม่ตรงตาม specification ฯลฯ <br>
                    1.	จัดทำ ใบบันทึกการควบคุมผลิตภัณฑ์หรือการทำงานที่ไม่เป็นไปตามข้อกำหนด <br>
                    2.	ดำเนินการแจ้ง และลงนามรับทราบตามขั้นตอน <br>
                    3.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\การควบคุมสิ่งที่ไม่เป็นไปตามข้อกำหนด
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->NonConformingPlan}}</td>
                    <td class="text-center">{{$value->NonConformingActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>พบความเสียหายของอุปกรณ์ (FM-003/WI-002/QP-OMB-MS-002(MMD)) <br></u>
                    ให้จัดทำเมื่อพบความเสียหายของอุปกรณ์ทุกครั้ง <br>
                    1.	จัดทำเอกสาร แบบตรวจสอบความเสียหายของอุปกรณ์ <br>
                    2.	ทำความเข้าใจ ตกลงกับผู้เกี่ยวข้อง และลงนามรับทราบข้อตกลง <br>
                    3.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\แบบตรวจสอบความเสียหายอุปกรณ์
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->DamagePlan}}</td>
                    <td class="text-center">{{$value->DamageActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>เพิ่มงานในสนาม (FM-001/WI-003 QP-OMB-MS-002) <br></u>
                    ให้จัดทำเมื่อมีการเพิ่มงานในสนามทุกครั้ง <br>
                    1.	จัดทำแบบฟอร์มขอเพิ่มงานในสนาม <br>
                    2.	ผู้ควบคุมงานพิจารณาความพร้อมและลงนาม <br>
                    3.	PM จัดส่งให้ลูกค้า <br>
                    4.	จัดเก็บสำเนาในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\เพิ่มงานในสนาม
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->AdditionalPlan}}</td>
                    <td class="text-center">{{$value->AdditionalActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>การดูแลทรัพย์สินของลูกค้า (FM-001/QP-PB-009) <br></u>
                    ให้จัดทำเมื่อมีการยืมเครื่องมือ หรือเบิก spare part จากลูกค้าทุกครั้ง <br>
                    1.	จัดทำเอกสาร บันทึก การเบิก-ส่งคืน ทรัพย์สินของลูกค้า <br>
                    2.	นำเข้าใช้งานเมื่อมีการเบิก-ส่งคืน อุปกรณ์ เครื่องมือ spare part จากลูกค้า <br>
                    3.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\การดูแลทรัพย์สินของลูกค้า
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->TakeCarePlan}}</td>
                    <td class="text-center">{{$value->TakeCareActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>การสังเกตการทำงาน (FM-024/QP-PB-031) <br></u>
                    ให้จัดทำอย่างน้อยสัปดาห์ละ 1 ครั้ง (สัปดาห์ตามรอบ Time Sheet) <br>
                    1.	ให้ผู้ควบคุมงานจัดทำแบบฟอร์มสังเกตการทำงาน <br>
                    2.	นำไปสังเกตการทำงาน <br>
                    3.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\สังเกตการทำงาน
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->ObservationPlan}}</td>
                    <td class="text-center">{{$value->ObservationActual}}</td>
                @endforeach
            </tr>
            <tr>
                <td><u>รายงานอุบัติการณ์ (QP-PB-032) <br></u>
                    ให้ดำเนินการทุกครั้งเมื่อเกิดอุบัติการณ์ <br>
                    1.	เข้าระงับเหตุ และปฏิบัติตามขั้นตอนแผนฉุกเฉินที่กำหนดไว้ <br>
                    2.	แจ้งข่าวใน Line ให้หัวหน้าแผนกทราบ <br>
                    3.	แจ้งเหตุตามแบบฟอร์มแจ้งอุบัติการณ์ สายงาน รวธ. <br>
                    4.	ค้นหาสาเหตุ และรายงานตามแบบฟอร์มรายงานการค้นหาสาเหตุอุบัติการณ์ สายงาน รวธ. <br>
                    5.	วิเคราะห์อุบัติการณ์ และรายงานตามแบบฟอร์มการวิเคราะห์อุบัติการณ์ สายงาน รวธ. <br>
                    6.	จัดเก็บในระบบ ECP ใน 02. ระหว่างการปฏิบัติงาน\อุบัติการณ์
                </td>
                @foreach ($weeklyreport as $value)
                    <td class="text-center">{{$value->IncidentPlan}}</td>
                    <td class="text-center">{{$value->IncidentActual}}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
@endsection
