@extends('layouts.printl')

@section('title','On the Job Training Evaluation')

@section('content')
    <h3 class="text-center">ใบประเมินผลในการฝึกอบรม <br> หลักสูตร/หัวข้อ <u>{{$course->CourseName}}</u> <br> วันที่ <u>{{$evaluationdate}}</u> <br> สถานที่ <u>{{$location->LocationThaiName}}</u></h3>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">ลำดับที่</th>
                    <th rowspan="2" class="text-center align-middle">หมายเลขประจำตัว</th>
                    <th rowspan="2" class="text-center align-middle">ชื่อ - สกุล</th>
                    <th rowspan="2" class="text-center align-middle">ตำเแหน่ง</th>
                    <th rowspan="2" class="text-center align-middle">สังกัด</th>
                    <th colspan="2" class="text-center">ลายเซ็นต์ผู้เข้าอบรม</th>
                    <th colspan="2" class="text-center">ผลการอบรม/ระยะเวลา</th>
                </tr>
                <tr>
                    <th class="text-center">เช้า</th>
                    <th class="text-center">บ่าย</th>
                    <th class="text-center">ผ่าน</th>
                    <th class="text-center">ไม่ผ่าน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evaluation as $value)
                    <tr>
                        <td class="text-center">{{$i}}</td>
                        <td class="text-center">{{$value->WorkID}}</td>
                        <td class="text-center">{{$value->ThaiName}}</td>
                        <td class="text-center">{{$value->Position}}</td>
                        <td class="text-center">{{$value->DepartmentName}}</td>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            @if ($value->Result == 'ผ่าน')
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->Result == 'ไม่ผ่าน')
                                X
                            @endif
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-sm">
            <tbody>
                <tr>
                    <td>หมายเหตุ</td>
                    <td>เกณฑ์การประเมินผล<br> - การประเมินผลจากระยะเวลาการเข้ารับการฝึกอบรมไม่น้อยกว่า 80%<br> - ใบรายงานผลการฝึกอบรมภายใน กฟผ. ที่ผ่านการพิจารณาจากผู้บังคับบัญชา<br>กรณีการฝึกอบรมในงาน (OJT) ให้ประเมินผลจากความรู้ความเข้าใจด้วยการสอบถามหรือให้ทดลองปฏิบัติ</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center">............................................................</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center"><u>{{$coach->ThaiName}}</u><br>วิทยากร/ผู้รับผิดชอบหลักสูตร</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td class="text-center" style="width:33%">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
                    <td class="text-center">รหัสเอกสาร FM-002/QP-PB-023</td>
                    <td class="text-center" style="width:33%">แก้ไขครั้งที่ 02</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection