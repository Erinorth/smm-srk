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
    เรียน ผู้ควบคุมงาน/หัวหน้างาน/ผู้ปฏิบัติงานที่รับผิดชอบเครื่องมือ/ผู้ปฏิบัติงาน <br><br>
    &emsp;&emsp;โปรดดำเนินการ Upload ใบรับรอง(Certificate) ในส่วนที่เกี่ยวข้อง โดยมีรายการดังนี้ <br><br>
    @if ( count($mail_facility_all) != 0 )
        <u>Facility Request</u><br>
        <table>
            <tr>
                <th>Facility/Tool Name</th>
                <th>Detail</th>
                <th>Use Date</th>
                <th>Remark</th>
            </tr>
            @foreach ($mail_facility_all as $value)
                <tr>
                    <td>{{ $value->ToolName }}</td>
                    <td>{{ $value->Detail }}</td>
                    <td style="text-align: center;">{{ $value->UseDate }}</td>
                    <td>{{ $value->Remark }}</td>
                </tr>
            @endforeach
            <br><br>
        </table>
    @endif

    @if ( count($mail_crane_all) != 0 )
        <u>Man</u><br>
        <table>
            <tr>
                <th>Location</th>
                <th>Crane/Hoist</th>
                <th>Detail</th>
                <th>Max Use Load</th>
                <th>Max Test Load</th>
                <th>Use Date</th>
                <th>Expire Date</th>
                <th>Remark</th>
            </tr>
            @foreach ($mail_crane_all as $value)
                <tr>
                    <td style="text-align: center;">{{ $value->LocationName }}</td>
                    <td style="text-align: center;">{{ $value->MachineName }}</td>
                    <td>{{ $value->Detail }}</td>
                    <td style="text-align: center;">{{ $value->MaxUseLoad }}</td>
                    <td style="text-align: center;">{{ $value->MaxTestLoad }}</td>
                    <td style="text-align: center;">{{ $value->UseDate }}</td>
                    <td style="text-align: center;">{{ $value->ExpireDate }}</td>
                    <td>{{ $value->Remark }}</td>
                </tr>
            @endforeach
            <br><br>
        </table>
    @endif
    โปรดส่งเอกสารให้กับผู้ควบคุมงานเพื่อนำไปเก็บในระบบต่อไป <br><br>
    จึงเรียนมาเพื่อโปรดดำเนินการ <br>
    ระบบบริหารจัดการงานบำรุงรักษา <br>
    Smart Maintenance Management (SMM) <br>
    -------------------------------------------------------------------------------- <br>
    อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบโดยอัตโนมัติ กรุณาอย่าตอบกลับ <br>
    หากพบปัญหาหรือข้อมูลไม่ถูกต้องโปรดแจ้ง Admin 519065@egat.co.th <br>
    --------------------------------------------------------------------------------
</body>
</html>
