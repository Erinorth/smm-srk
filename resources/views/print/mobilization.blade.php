@extends('layouts.print')

@section('title','Mobilization')

@section('content')
    <div class="container col-12">
        <div class="row">
            <div class="col text-center border-top border-left border-right border-bottom">
                <h4>แบบฟอร์มขอออกคำสั่งเดินทาง</h4>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br>
                วันที่ <u>{{ date('d-m-Y', strtotime(NOW())) }}</u> <br>
                &emsp;&emsp;&emsp;&emsp;ด้วยแผนก <u>{{ $department->DepartmentName }}</u> มีความประสงค์จะส่งผู้ปฏิบัติงานเดินทางไปปฏิบัติงาน <u>{{ $project->ProjectName }}</u> ที่ <u>
                @foreach ($location as $value)
                    {{ $value->LocationThaiName }} 
                @endforeach
                </u> 
                @if ( count($otherdepartment) > 0 )
                    พร้อม
                    @foreach ($otherdepartment as $value)
                        @if ( $value->Section != "Other")
                            ผู้ปฏิบัติงานแผนก <u>{{ $value->Section }}</u> จำนวน <u>{{ $value->CountOfSection }}</u> คน                            
                        @endif
                    @endforeach
                @endif
                ดังมีรายชื่อต่อไปนี้
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-borderless table-sm">
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($mobilization as $value)
                        <tr>
                            <td class="text-center">{{ $i }}.</td>
                            <td><u>{{ $value->ThaiName }}</u></td>
                            <td>สังกัด <u>{{ $value->DepartmentName }}</u></td>
                            <td>หมายเหตุ : <u>{{ date('d-m-Y', strtotime($value->StartDate)) }} - {{ date('d-m-Y', strtotime($value->EndDate)) }} {{ $value->Remark }}</u></td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                &emsp;&emsp;&emsp;&emsp;ทั้งนี้ตั้งแต่วันที่ <u>{{ date_format($startdate,'d-m-Y') }}</u> ถึงวันที่ <u>{{ date_format($enddate,'d-m-Y') }}</u> เป็นเวลา <u>{{ $datediff->days + 1 }}</u> วัน (รวมวันเดินทางไป - กลับ) โดยใช้ PM order <u>{{ $pmorder->PMOrder }}</u><br>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br>
                หมายเหตุ :
            </div>
            <div class="col">
                <br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </div>
        </div>
        <div class="row">
            <div class="col text-center border-top border-left border-right border-bottom">
                <h4>การขอใช้รถยนต์</h4>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td rowspan="3">มีความประสงค์ขอใช้</td>
                        <td><i class="far fa-square"></i> รถตู้ <u>&emsp;&emsp;&emsp;&emsp;</u> คัน</td>
                        <td><i class="far fa-square"></i> รถ Pick up 2 ประตู <u>&emsp;&emsp;&emsp;&emsp;</u> คัน</td>
                    </tr>
                    <tr>
                        <td> <i class="far fa-square"></i> รถบรรทุก <u>&emsp;&emsp;&emsp;&emsp;</u> คัน</td>
                        <td> <i class="far fa-square"></i> รถ Pick up 4 ประตู <u>&emsp;&emsp;&emsp;&emsp;</u> คัน</td>
                    </tr>
                    <tr>
                        <td colspan="2"> <i class="far fa-square"></i> อื่นๆ ระบุ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> คัน</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                ทั้งนี้ให้อยู่ในความควบคุมของ <u>{{ $controller->ThaiName }}</u> เลขประจำตัว <u>{{ $controller->WorkID }}</u> ตำแหน่ง <u>{{ $controller->Position }}</u> <br>
                <i class="far fa-square"></i> ผู้ควบคุมเดินทางไปกับรถ <i class="far fa-square"></i> ผู้ควบคุมไม่ได้เดินทางไปกับรถ โทรศัพท์ <u>{{ $controller->Telephone }}</u> <br><br>
                จำนวนผู้โดยสาร <u>&emsp;&emsp;&emsp;&emsp;</u> คน และ/หรือบรรทุกสิ่งของมีรายละเอียดดังนี้
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <td class="text-center" style="width: 5%">ลำดับ</td>
                            <td class="text-center">รายการ</td>
                            <td class="text-center" style="width: 20%">ขนาด (กว้างXยาวXสูง)</td>
                            <td class="text-center" style="width: 10%">น้ำหนัก</td>
                            <td class="text-center" style="width: 10%">จำนวน</td>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td style="height: 30px"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br>
                ระหว่างวันที่ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ถึงวันที่ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> รวม <u>&emsp;&emsp;&emsp;&emsp;</u> วัน <br><br>
                กำหนดนัดหมาย สถานที่ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> เวลา <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> น.
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br>
                รายละเอียดอื่นๆ
            </div>
            <div class="col">
                <br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br>
                หมายเหตุ :
            </div>
            <div class="col">
                <br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br><br>
                <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </div>
        </div>
        <div class="row">
            <div class="col text-right">
                <br><br>
                ผู้จัดทำ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </div>
        </div>
    </div>
@endsection