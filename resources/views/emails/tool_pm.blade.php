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
    เรียน หัวหน้าผู้รับผิดชอบเครื่องมือ/ผู้ปฏิบัติงานที่รับผิดชอบเครื่องมือ <br><br>
    &emsp;&emsp;โปรดดำเนินการบำรุงรักษาเครื่องมือตามกำหนด โดยมีรายการดังนี้ <br><br>
    @if ( count($pm) != 0 )
        <table>
            <tr>
                <th>Catagory Name</th>
                <th>Range/Capacity</th>
                <th>Local code</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>กิจกรรม</th>
                <th>สถานะ</th>
                <th>วันที่ครบกำหนด</th>
            </tr>
            @foreach ($pm as $value)
                <tr>
                    <td>{{ $value->CatagoryName }}</td>
                    <td style="text-align: center;">{{ $value->RangeCapacity }}</td>
                    <td style="text-align: center;">{{ $value->LocalCode }}</td>
                    <td style="text-align: center;">{{ $value->Brand }}</td>
                    <td style="text-align: center;">{{ $value->Model }}</td>
                    <td style="text-align: center;">{{ $value->SerialNumber }}</td>
                    <td>{{ $value->Activity }}</td>
                    <td style="text-align: center;">{{ $value->Status }}</td>
                    <td style="text-align: center;">{{ $value->DueDate }}</td>
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
