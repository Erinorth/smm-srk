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
    เรียน หัวหน้าแผนกแผนงาน/ผู้ปฏิบัติงาน <br><br>
    &emsp;&emsp;โปรดดำเนินการ Confirmed งานก่อนเริ่มงาน 90 วัน โดยมีรายการดังนี้ <br><br>
    @if ( count($plan) != 0 )
        <table>
            <tr>
                <th>ชื่องาน</th>
                <th>วันเริ่มต้น</th>
                <th>วันสิ้นสุด</th>
                <th>สถานะ</th>
            </tr>
            @foreach ($plan as $value)
                <tr>
                    <td>{{ $value->ProjectName }}</td>
                    <td style="text-align: center;">{{ $value->StartDate }}</td>
                    <td style="text-align: center;">{{ $value->FinishDate }}</td>
                    <td style="text-align: center;">{{ $value->Status }}</td>
                </tr>
            @endforeach
        </table>
        <br><br>
    @endif
    จึงเรียนมาเพื่อโปรดดำเนินการ <br>
    ระบบบริหารจัดการงานบำรุงรักษา <br>
    Smart Maintenance Management (SMM) <br>
    -------------------------------------------------------------------------------- <br>
    อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบโดยอัตโนมัติ กรุณาอย่าตอบกลับ <br>
    หากพบปัญหาหรือข้อมูลไม่ถูกต้องโปรดแจ้ง Admin 519065@egat.co.th <br>
    --------------------------------------------------------------------------------
</body>
</html>
