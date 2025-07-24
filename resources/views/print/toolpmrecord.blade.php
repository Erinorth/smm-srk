@extends('layouts.print')

@section('title','Tool Record')

@section('content')
    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="2" class="text-center">
                <h5>ประวัติเครื่องมือ/อุปกรณ์</h5>
            </td>
        </tr>
        @foreach ($tool as $value)
            <tr>
                <td>
                    ชื่อเครื่องมืออุปกรณ์ <u>{{ $value->CatagoryName }}  {{ $value->RangeCapacity }}</u>
                </td>
                <td>
                    รหัส <u>{{ $value->LocalCode }} // {{ $value->DurableSupplieCode }} // {{ $value->AssetToolCode }}</u>
                </td>
            </tr>
            <tr>
                <td>
                    ยี่ห้อ <u>{{ $value->Brand }}</u>
                </td>
                <td>
                    วัน-เดือน-ปี <u>{{ $value->RegisterDate }}</u>
                </td>
            </tr>
            <tr>
                <td>
                    รุ่น <u>{{ $value->Model }}</u>
                </td>
                <td>
                    ผู้รับผิดชอบ <u>{{ $value->Responsible }}</u>
                </td>
            </tr>
            <tr>
                <td>
                    หมายเลขเครื่อง <u>{{ $value->SerialNumber }}</u>
                </td>
                <td>
                    
                </td>
            </tr>
        @endforeach
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td class="text-center">ลำดับที่</td>
                <td class="text-center">วัน-เดือน-ปี</td>
                <td class="text-center">บำรุงรักษา / ซ่อม</td>
                <td class="text-center">หน่วยงาน / ผู้ดำเนินการ</td>
                <td class="text-center">ผลการดำเนินการ</td>
                <td class="text-center">รายละเอียดเพิ่มเติม</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($record as $value)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($value->PMDate)) }}</td>
                    <td>{!! nl2br($value->Activity) !!}</td>
                    <td class="text-center">{{ $value->Operator }}</td>
                    <td>{!! nl2br($value->Result) !!}</td>
                    <td>{!! nl2br($value->Remark) !!}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td class="text-center">รหัสเอกสาร FM-007/QP-PB-013</td>
            <td class="text-center">แก้ไขครั้งที่   02</td>
        </tr>
    </table>
@endsection
