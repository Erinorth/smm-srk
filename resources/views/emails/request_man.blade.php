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
    เรียน หัวหน้าแผนกผู้ควบคุมงาน/ผู้ควบคุมงาน <br><br>
    &emsp;&emsp;โปรดดำเนินการติดตามการขอสนับสนุนผู้ปฏิบัติงาน โดยมีรายการดังนี้ <br><br>
    @if ( count($request_man) != 0 )
        <table>
            <tr>
                <th>ชื่องาน</th>
                <th>ขอสนับสนุนผู้ปฏิบัติงานจากหน่วยงาน</th>
                <th>จำนวนขอสนับสนุน</th>
                <th>จำนวนที่ได้รับการสนับสนุนแล้ว</th>
                <th>วันที่ต้องการให้ถึง Site</th>
            </tr>
            @foreach ($request_man as $value)
                <tr>
                    <td>{{ $value->ProjectName }}</td>
                    <td style="text-align: center;">{{ $value->DepartmentName }}</td>
                    <td style="text-align: center;">{{ $value->Amount }}</td>
                    <td style="text-align: center;">{{ $value->count_man }}</td>
                    <td style="text-align: center;">{{ $value->AtSite }}</td>
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
