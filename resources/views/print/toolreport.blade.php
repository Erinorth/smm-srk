@extends('layouts.printl')

@section('title','Tool Monthly Report')

@section('content')
    <h5 class="text-center">รายงานการบำรุงรักษาเชิงป้องกันและการดำเนินการแก้ไขประจำ เดือน <u>{{ thaiFullMonth($month) }}</u></h5><br>
    เรียน <u>กฟนม-ธ.</u> แผนก <u>หบนม-ธ.</u> กอง <u>กฟนม-ธ.</u> ฝ่าย <u>อบค.</u>
    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="6">ผลการตรวจสอบตามโปรแกรมการบำรุงรักษาป้องกัน
                @if ( COUNT($PM) > 0 )
                    <i class="far fa-lg fa-fw fa-square"></i>
                @else
                    <i class="far fa-lg fa-fw fa-check-square"></i>
                @endif ดำเนินการเสร็จเรียบร้อย
                @if ( COUNT($breakdown) == 0 )
                    <i class="far fa-lg fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-lg fa-fw fa-square"></i>
                @endif ไม่พบการเกิด Equipment Breakdown
            </td>
        </tr>
        <tr>
            <td colspan="6">
                @if ( COUNT($PM) > 0 )
                    <i class="far fa-lg fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-lg fa-fw fa-square"></i>
                @endif ดำเนินการยังไม่แล้วเสร็จ
            </td>
        </tr>
        <tr>
            <td class="text-center" style="width: 5%">ลำดับที่</td>
            <td class="text-center" style="width: 20%">รายชื่อเครื่องมือ/อุปกรณ์</td>
            <td colspan="4" class="text-center">สาเหตุ</td>
        </tr>
        @if ( COUNT($PM) > 0 )
            @php
                $i = 1;
            @endphp
            @foreach ($PM as $value)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td>
                        {{ $value->CatagoryName }} {{ $value->RangeCapacity }}
                        @if ( $value->LocalCode <> "" )
                            &nbsp; Local Code : &nbsp; {{ $value->LocalCode }}
                        @endif
                        @if ( $value->DurableSupplieCode <> "" )
                            &nbsp; รหัสครุภัณฑ์/รหัสพัสดุ : &nbsp; {{ $value->DurableSupplieCode }}
                        @endif
                        @if ( $value->AssetToolCode <> "" )
                            &nbsp; รหัสสินทรัพย์/รหัสเครื่องมือ : &nbsp; {{ $value->AssetToolCode }}
                        @endif
                        @if ( $value->Brand <> "" )
                            &nbsp; ยี่ห้อ : &nbsp; {{ $value->Brand }}
                        @endif
                        @if ( $value->Model <> "" )
                            &nbsp; รุ่น : &nbsp;{{ $value->Model }}
                        @endif
                        @if ( $value->SerialNumber <> "" )
                            &nbsp; S/N : &nbsp;{{ $value->SerialNumber }}
                        @endif <br>
                    </td>
                    <td colspan="4"></td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        @else
            <tr>
                <td style="height: 35px">-</td>
                <td>-</td>
                <td colspan="4">-</td>
            </tr>
        @endif
        <tr>
            <td colspan="6">
                @if ( COUNT($breakdown) == 0 )
                    <i class="far fa-lg fa-fw fa-square"></i>
                @else
                    <i class="far fa-lg fa-fw fa-check-square"></i>
                @endif เกิด Equipment Breakdown
            </td>
        </tr>
        <tr>
            <td class="text-center">ลำดับที่</td>
            <td class="text-center">รายชื่อเครื่องมือ/อุปกรณ์</td>
            <td class="text-center" style="width: 20%">รายงานข้อขัดข้องเสียหาย</td>
            <td class="text-center" style="width: 20%">สาเหตุหลัก</td>
            <td class="text-center" style="width: 15%">มูลค่าความเสียหาย</td>
            <td class="text-center" style="width: 20%">แนวทางการแก้ไข</td>
        </tr>
        @if ( COUNT($breakdown) > 0 )
            @php
                $j = 1;
            @endphp
            @foreach ($breakdown as $value)
                <tr>
                    <td class="text-center">{{ $j }}</td>
                    <td>
                        {{ $value->CatagoryName }} {{ $value->RangeCapacity }}
                        @if ( $value->LocalCode <> "" )
                            &nbsp; Local Code : &nbsp; {{ $value->LocalCode }}
                        @endif
                        @if ( $value->DurableSupplieCode <> "" )
                            &nbsp; รหัสครุภัณฑ์/รหัสพัสดุ : &nbsp; {{ $value->DurableSupplieCode }}
                        @endif
                        @if ( $value->AssetToolCode <> "" )
                            &nbsp; รหัสสินทรัพย์/รหัสเครื่องมือ : &nbsp; {{ $value->AssetToolCode }}
                        @endif
                        @if ( $value->Brand <> "" )
                            &nbsp; ยี่ห้อ : &nbsp; {{ $value->Brand }}
                        @endif
                        @if ( $value->Model <> "" )
                            &nbsp; รุ่น : &nbsp;{{ $value->Model }}
                        @endif
                        @if ( $value->SerialNumber <> "" )
                            &nbsp; S/N : &nbsp;{{ $value->SerialNumber }}
                        @endif <br>
                    </td>
                    <td>{{ nl2br($value->Report) }}</td>
                    <td>{{ nl2br($value->Cause) }}</td>
                    <td class="text-center">{{ $value->Value }} บาท</td>
                    <td>{{ nl2br($value->Guideline) }}</td>
                </tr>
                @php
                    $j++;
                @endphp
            @endforeach
        @else
            <tr>
                <td style="height: 15px">-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        @endif
        <tr>
            <td colspan="6" class="text-right">
                <br>
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผู้รายงาน <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
    </table>
    - หน. แผนกจัดทาเสนอ หน.กอง <br>
    - หน.กองจัดทาในภาพรวมของกอง สาเนา ผู้แทนฝ่าย /จป. ฝ่าย <br>
    - ต้นฉบับ : เก็บที่หน่วยงาน
    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="2" class="text-center">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td colspan="7" class="text-center">รหัสเอกสาร  FM-006/QP-PB-013</td>
            <td colspan="3" class="text-center">แก้ไขครั้งที่   02</td>
        </tr>
    </table>
@endsection
