@extends('layouts.printl')

@section('title','Tool List')

@section('content')
    <table class="table table-bordered table-sm">
            <tr>
                <td class="text-center">บัญชีรายชื่อเครื่องมืออุปกรณ์</td>
            </tr>
            <tr>
                <td>หน่วยงาน <u>กฟนม-ธ. อบค.</u></td>
            </tr>
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td rowspan="2" class="text-center">ลำดับที่</td>
                <td rowspan="2" class="text-center">ชื่อเครื่องมืออุปกรณ์</td>
                <td rowspan="2" class="text-center">ยี่ห้อ</td>
                <td rowspan="2" class="text-center">รุ่น</td>
                <td rowspan="2" class="text-center">หมายเลขเครื่อง</td>
                <td rowspan="2" class="text-center">รหัส</td>
                <td rowspan="2" class="text-center">วัน-เดือน-ปีขึ้นทะเบียน</td>
                <td rowspan="2" class="text-center">วัน-เดือน-ปีตัดบัญชี</td>
                <td colspan="3" class="text-center">การควบคุมเครื่องมืออุปกรณ์</td>
                <td rowspan="2" class="text-center">ผู้รับผิดชอบ</td>
            </tr>
            <tr>
                <td class="text-center">PM</td>
                <td class="text-center">Pre-Use</td>
                <td class="text-center">สอบเทียบ</td>
            </tr>
        </thead>
        @php
            $i = 1;
        @endphp
        <tbody>
            @foreach ($tool as $value)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td>
                        {{ $value->CatagoryName }}
                        @if ( $value->RangeCapacity <> "" )
                            // {{ $value->RangeCapacity }}
                        @endif
                    </td>
                    <td class="text-center">{{ $value->Brand }}</td>
                    <td class="text-center">{{ $value->Model }}</td>
                    <td class="text-center">{{ $value->SerialNumber }}</td>
                    <td class="text-center">
                        @if ( $value->DurableSupplieCode == "" AND $value->AssetToolCode == "")
                            N/A
                        @else
                            {{ $value->DurableSupplieCode }}/{{ $value->AssetToolCode }}
                        @endif
                    </td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($value->RegisterDate)) }}</td>
                    <td class="text-center"></td>
                    <td class="text-center">
                        @if ( $value->PM > 0 )
                            /
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PreUse > 0 )
                            /
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->MeasuringTool == "Yes" )
                            /
                        @endif
                    </td>
                    <td class="text-center">{{ $value->Responsible }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
            <tr>
                <td>
                    <div class="container">
                        <div class="row">
                            <div class="col-5"></div>
                            <div class="col-7">
                                <br>
                                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br><br>
                                ตำแหน่ง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td class="text-center">รหัสเอกสาร  FM-002/QP-PB-013</td>
            <td class="text-center">แก้ไขครั้งที่   02</td>
        </tr>
</table>
@endsection
