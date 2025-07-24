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
    @if ( count($mail_measuring_all) != 0 )
        <u>Measuring Tool</u><br>
        <table>
            <tr>
                <th>Catagory Name</th>
                <th>Range/Capacity</th>
                <th>Unit</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Local Code</th>
                <th>Durable Supplie Code</th>
                <th>Asset Tool Code</th>
                <th>Expire Date</th>
            </tr>
            @foreach ($mail_measuring_all as $value)
                <tr>
                    <td>{{ $value->CatagoryName }}</td>
                    <td style="text-align: center;">{{ $value->RangeCapacity }}</td>
                    <td style="text-align: center;">{{ $value->Unit }}</td>
                    <td style="text-align: center;">{{ $value->Brand }}</td>
                    <td style="text-align: center;">{{ $value->Model }}</td>
                    <td style="text-align: center;">{{ $value->SerialNumber }}</td>
                    <td style="text-align: center;">{{ $value->LocalCode }}</td>
                    <td style="text-align: center;">{{ $value->DurableSupplieCode }}</td>
                    <td style="text-align: center;">{{ $value->AssetToolCode }}</td>
                    <td style="text-align: center;">{{ $value->ExpireDate }}</td>
                </tr>
            @endforeach
            <br><br>
        </table>
    @endif

    @if ( count($mail_man_cer_all) != 0 )
        <u>Man</u><br>
        <table>
            <tr>
                <th>WorkID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Expire Date</th>
            </tr>
            @foreach ($mail_man_cer_all as $value)
                <tr>
                    <td style="text-align: center;">{{ $value->WorkID }}</td>
                    <td>{{ $value->ThaiName }}</td>
                    <td>{{ $value->TypeName }}</td>
                    <td style="text-align: center;">{{ $value->ExpireDate }}</td>
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
