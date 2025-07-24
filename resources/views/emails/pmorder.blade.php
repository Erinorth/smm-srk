<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail</title>
    <style>
        html, body {
            font-family: 'THSarabunNew';
            color: black;
            font-size: 22px;
            font-style: normal;
            font-weight: normal;
        }
        table {
            width: 100%;
            color: black;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    เรียน หัวหน้ากอง/หัวหน้าแผนกของแผนงาน/ผู้ปฏิบัติงานแผนงาน/ธุรการ <br><br>
    &emsp;&emsp;โปรดดำเนินงานปิด PM Order หลังจากงานแล้วเสร็จ โดยมีรายการดังนี้ <br><br>
    @if ( count($mail_all_NC) != 0 )
        <u>PM Oreder ที่ยังไม่ได้ปิด</u> <br>
        <table>
            <tr>
                <th>Project Name</th>
                <th>PM Order</th>
                <th>PM Order Name</th>
                <th>Remark</th>
            </tr>
            @foreach ($mail_all_NC as $value)
                <tr>
                    <td><a href="http://smm.egat.co.th/pmorders/{{ $value->project_id }}">{{ $value->ProjectName }}</a></td>
                    <td style="text-align: center;">{{ $value->PMOrder }}</td>
                    <td style="text-align: center;">{{ $value->PMOrderName }}</td>
                    <td style="text-align: center;">{{ $value->Remark }}</td>
                </tr>
            @endforeach
        </table>
        <br><br>
    @endif
    @if ( count($mail_all_C_last_week) != 0 )
        <u>PM Order ที่แจ้งปิด(SMM)ในสัปดาห์ที่ผ่านมา</u> <br>
        <table>
            <tr>
                <th>Project Name</th>
                <th>PM Order</th>
                <th>PM Order Name</th>
                <th>Remark</th>
            </tr>
            @foreach ($mail_all_C_last_week as $value)
                <tr>
                    <td><a href="http://smm.egat.co.th/pmorders/{{ $value->project_id }}">{{ $value->ProjectName }}</a></td>
                    <td style="text-align: center;">{{ $value->PMOrder }}</td>
                    <td style="text-align: center;">{{ $value->PMOrderName }}</td>
                    <td style="text-align: center;">{{ $value->Remark }}</td>
                </tr>
            @endforeach
        </table>
        <br><br>
    @endif
    <h3><a href="http://smm.egat.co.th/pmorders/1/index">รายการ PM Order ทั้งหมด</a></h3>
    <br><br>
    จึงเรียนมาเพื่อโปรดดำเนินการ <br>
    ระบบบริหารจัดการงานบำรุงรักษา <br>
    Smart Maintenance Management (SMM) <br>
    -------------------------------------------------------------------------------- <br>
    อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบโดยอัตโนมัติ กรุณาอย่าตอบกลับ <br>
    หากพบปัญหาหรือข้อมูลไม่ถูกต้องโปรดแจ้ง Admin 519065@egat.co.th <br>
    --------------------------------------------------------------------------------
</body>
</html>
