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
    เรียน ผู้ปฏิบัติงาน <br><br>
    &emsp;&emsp;โปรดดำเนินงานตาม Mile Stone ภายในวันที่กำหนด โดยมีรายการดังนี้ <br><br>
    @if ( count($milestone) != 0 )
        <table>
            <tr>
                <th>ประเภทงาน</th>
                <th>ชื่องาน</th>
                <th>กิจกรรม</th>
                <th>สถานะ</th>
                <th>วันที่ครบกำหนด</th>
            </tr>
            @foreach ($milestone as $value)
                <tr>
                    <td style="text-align: center;">{{ $value->TypeName }}</td>
                    <td style="text-align: center;">
                        <a href="http://smm.egat.co.th/projects_milestone/{{ $value->project_id }}">{{ $value->ProjectName }}</a>
                    </td>
                    <td>
                        @if ( $value->Link == "" )
                            {{ $value->Activity }}
                        @else
                            @if ( $value->Dynamic == "Yes" )
                                <a href="http://smm.egat.co.th/{{ $value->Link }}/{{ $value->project_id }}">{{ $value->Activity }}</a>
                            @else
                                <a href="{{ $value->Link }}">{{ $value->Activity }}</a>
                            @endif
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $value->Status }}</td>
                    <td style="text-align: center;">{{ date('d-m-Y',strtotime($value->DueDate)) }}</td>
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
