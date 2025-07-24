@extends('layouts.printl')

@section('title','Check List')

@section('content')
    <h3 class="text-center">ตารางการอบรมในงาน (On the Job Training) <br> หน่วยงาน {{$department->DepartmentName}} <br> ประจำปี {{$year}}</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">งาน</th>
                    <th rowspan="2" class="text-center align-middle">กลุ่มเป้าหมาย <br> (ตำแหน่ง/ระดับ)</th>
                    <th colspan="2" class="text-center">จำนวน</th>
                    <th colspan="3" class="text-center">หลักสูตร/หัวข้อที่จำเป็นในการอบรม</th>
                </tr>
                <tr>
                    <th class="text-center">คน</th>
                    <th class="text-center">Man-Day</th>
                    <th class="text-center">QP</th>
                    <th class="text-center">WI</th>
                    <th class="text-center">อื่นๆ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plan as $value)
                    <tr>
                        <td>{{$value->ProjectName}}</td>
                        <td>{{$value->JobPositionName}}</td>
                        <td class="text-center">{{$value->CountOfJobPositionName}}</td>
                        <td class="text-center">{{$value->MD}}</td>
                        <td>
                            @if ($value->Type == 'QP')
                                {{$value->CourseName}}
                            @endif
                        </td>
                        <td>
                            @if ($value->Type == 'WI')
                                {{$value->CourseName}}
                            @endif
                        </td>
                        <td>
                            @if ($value->Type == 'Other')
                                {{$value->CourseName}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-sm">
            <tbody>
                <tr>
                    <td class="text-center" style="width:50%">......................................................... <br> (หัวหน้าแผนก/ผู้ที่ได้รับมอบหมายในกลุ่มงานหรือส่วนกลางฝ่ายหรือเทียบเท่าขึ้นไป)</td>
                    <td class="text-center">......................................................... <br> (หัวหน้ากอง/ผู้ที่ได้รับมอบหมายในกลุ่มงานหรือส่วนกลางฝ่ายหรือเทียบเท่าขึ้นไป)</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td class="text-center" style="width:33%">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
                    <td class="text-center">รหัสเอกสาร FM-003/QP-PB-023</td>
                    <td class="text-center" style="width:33%">แก้ไขครั้งที่ 01</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection