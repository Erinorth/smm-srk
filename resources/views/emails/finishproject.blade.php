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
    เรียน หัวหน้าแผนงาน/ผู้ปฏิบัติงานแผนงาน <br><br>
    &emsp;&emsp;โปรดตรวจสอบและขยายเวลาหากต้องมีการดำเนินงานหลังจากวันสิ้นสุด โดยมีรายการดังนี้ <br><br>
    @if ( count($near_finish) != 0 )
        <table>
            <tr>
                <th>Project Name</th>
                <th>Type Name</th>
                <th>Start Date</th>
                <th>Finish Date</th>
            </tr>
            @foreach ($near_finish as $value)
                <tr>
                    <td>{{ $value->ProjectName }}</td>
                    <td style="text-align: center;">{{ $value->TypeName }}</td>
                    <td style="text-align: center;">{{ $value->StartDate }}</td>
                    <td style="text-align: center;">{{ $value->FinishDate }}</td>
                </tr>
            @endforeach
            <br><br>
        </table>
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
