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
    เรียน หัวหน้ากอง/หัวหน้าแผนกของผู้ควบคุมงาน/หัวหน้าแผนกของผู้ปฏิบัติงาน/ผู้ควบคุมงาน/ผู้ปฏิบัติงาน/ธุรการ <br><br>
    &emsp;&emsp;โปรดดำเนินการขออนุมัติปฏิบัติงานล่วงเวลาเพิ่มเติมตามแผน โดยมีรายละเอียดดังนี้ <br><br>
    @if ( count($noti_this) != 0 )
        <u>เดือนปัจจุบัน</u><br>
        <table>
            <tr>
                <th>หมายเลขประจำตัว</th>
                <th>ชื่อ - สกุล</th>
                <th>ล่วงเวลาสะสม <br> (วันที่)</th>
                <th>วันที่จะมีล่วงเวลาเกินกรอบที่ขออนุมัติ</th>
                <th>กรอบล่วงเวลาที่ได้รับการอนุมัติแล้ว</th>
            </tr>
            @foreach ($noti_this as $value)
                <tr>
                    <td style="text-align: center;">{{ $value->WorkID }}</td>
                    <td style="text-align: center;">{{ $value->ThaiName }}</td>
                    <td style="text-align: center;">{{ $value->Actual }} <br> ({{ $value->ActualDate }})</td>
                    <td style="text-align: center;">{{ $value->OTDate }}</td>
                    <td style="text-align: center;">{{ $value->Frame }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    @if ( count($noti_next) != 0 )
        <br><br>
        <u>เดือนถัดไป</u><br>
        <table>
            <tr>
                <th>หมายเลขประจำตัว</th>
                <th>ชื่อ - สกุล</th>
                <th>วันที่จะมีล่วงเวลาเกินกรอบที่ขออนุมัติ</th>
                <th>ล่วงเวลาที่จะเกิดขึ้นตามแผน</th>
                <th>กรอบล่วงเวลาที่ได้รับการอนุมัติแล้ว</th>
            </tr>
            @foreach ($noti_next as $value)
                <tr>
                    <td style="text-align: center;">{{ $value->WorkID }}</td>
                    <td style="text-align: center;">{{ $value->ThaiName }}</td>
                    <td style="text-align: center;">{{ $value->OTDate }}</td>
                    <td style="text-align: center;">{{ $value->cumulative_sum }}</td>
                    <td style="text-align: center;">{{ $value->Frame }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    @if ( count($noti_year) != 0 )
        <br><br>
        <u>เดือนถัดไป</u><br>
        <table>
            <tr>
                <th>หมายเลขประจำตัว</th>
                <th>ชื่อ - สกุล</th>
                <th>วันที่จะมีล่วงเวลาเกินกรอบที่ขออนุมัติ</th>
                <th>ล่วงเวลาที่จะเกิดขึ้นตามแผน</th>
                <th>กรอบล่วงเวลาที่ได้รับการอนุมัติแล้ว</th>
            </tr>
            @foreach ($noti_next as $value)
                <tr>
                    <td style="text-align: center;">{{ $value->WorkID }}</td>
                    <td style="text-align: center;">{{ $value->ThaiName }}</td>
                    <td style="text-align: center;">{{ $value->OTDate }}</td>
                    <td style="text-align: center;">{{ $value->cumulative_sum }}</td>
                    <td style="text-align: center;">{{ $value->Frame }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    <br><br>
    <h3><a href="http://smm.egat.co.th/otframe">Update กรอบล่วงเวลา</a></h3>
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
