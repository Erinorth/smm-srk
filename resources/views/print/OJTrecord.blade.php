@extends('layouts.printl')

@section('title')
    Knowledge-Skilled
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Job</h1>
@stop

@section('content')
    <h2 class="text-center">ใบบันทึกรายการความรู้ และทักษะในงานของผู้ปฏิบัติงาน</h2>
    <div class="table-responsive">
        <table class="table table-borderless table-sm">
            <tr>
                <td class="text-center" style="width:20%">ชื่อ - สกุล</td>
                <td class="text-center border-bottom" style="width:30%">{{$employee->ThaiName}}</td>
                <td class="text-center" style="width:20%">หมายเลขประจำตัว</td>
                <td class="text-center border-bottom" style="width:30%">{{$employee->WorkID}}</td>
            </tr>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center">ลำดับที่</th>
                    <th class="text-center">ปฎิบัติงานในตำแหน่ง</th>
                    <th class="text-center">ลักษณะงานที่ปฏิบัติ</th>
                    <th class="text-center">ความรู้และทักษะที่มีในงาน</th>
                    <th class="text-center">ผู้บันทึก</th>
                    <th class="text-center">ผู้รับรองข้อมูล</th>
                    <th class="text-center">วันที่รับรองข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ojtrecord as $value)
                    <tr>
                        <td class="text-center">{{$i}}</td>
                        <td class="text-center"> @if ($value->JobPositionName == "") N/A @else {{$value->JobPositionName}} @endif </td>
                        <td>
                            @if ($value->TypeofJob != "")
                                {{$value->TypeofJob}}
                                @if ($value->ProjectName != "")
                                    / {{$value->ProjectName}}
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">{{$value->CourseName}}</td>
                        <td class="text-center">{{$value->Recorder}}</td>
                        <td class="text-center">{{$value->Approver}}</td>
                        <td class="text-center">{{$value->ApprovedDate}}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <tr>
                <td class="text-center" style="width:33%">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
                <td class="text-center">รหัสเอกสาร FM-004/QP-PB-023</td>
                <td class="text-center" style="width:33%">แก้ไขครั้งที่ 02</td>
            </tr>
        </table>
    </div>
@endsection
