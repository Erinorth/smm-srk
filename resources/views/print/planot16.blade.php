@extends('layouts.printl')

@section('title','Plan Overtime')

@section('content')
    <table class="table table-borderless table-sm">
        <tr>
            <td class="text-center">
                <h4>ประมาณการล่วงเวลารายบุคคล ฝ่ายบำรุงรักษาเครื่องกล</h4><br>
                <h5>กองโรงไฟฟ้าพลังน้ำและพลังงานหมุนเวียน</h5><br>
                <h6>ชื่องาน </h6>
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td rowspan="5" class="text-center">ลำดับที่</td>
                <td rowspan="5" class="text-center">ชื่อ - สกุล</td>
                <td rowspan="5" class="text-center">ตำแหน่ง</td>
                <td rowspan="5" class="text-center">งานที่ได้รับมอบหมาย</td>
                <td colspan="{{ $dayinmonth +2}}" class="text-center">เดือน</td>
                <td rowspan="5" class="text-center">ล่วงเวลาสะสม(ยกมา)</td>
                <td rowspan="5" class="text-center">รวมทั้งหมด</td>
            </tr>
            <tr>
                <td>วันที่ตามปฏิทิน</td>
                @for ($i = 1; $i < $dayinmonth + 1; $i++)
                    <td class="text-center">{{ $i }}</td>
                @endfor
                <td rowspan="4">รวม</td>
            </tr>
            <tr>
                <td>วันที่ของงาน</td>
                {{-- @for ($i = 1; $i < $dayinmonth + 1; $i++)
                    <td class="text-center">{{ $i }}</td>
                @endfor --}}
            </tr>
            <tr>
                <td>วัน (จ. - อา.)</td>
                {{-- @for ($i = 1; $i < $dayinmonth + 1; $i++)
                    <td class="text-center">{{ $i }}</td>
                @endfor --}}
            </tr>
            <tr>
                <td>Craft/ปฏิบัติหน้าที่/ชุด</td>
                <td colspan="{{ $dayinmonth }}" class="text-center">จำนวนล่วงเวลารายวัน</td>
            </tr>
        </thead>
        <tbody>
            @php
                $j = 1;
            @endphp
            @foreach ($plan as $value)
                <tr>
                    <td class="text-center">{{ $j }}</td>
                    <td>{{ $value->ThaiName }}</td>
                    <td class="text-center">ตำแหน่ง</td>
                    <td class="text-center">1</td>
                    <td class="text-center">Craft</td>
                    @php $x = 0; $x = $x + $value->Plan1;@endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan1,1) }}</td> @php $x = $x + $value->Plan2; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan2,1) }}</td> @php $x = $x + $value->Plan3; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan3,1) }}</td> @php $x = $x + $value->Plan4; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan4,1) }}</td> @php $x = $x + $value->Plan5; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan5,1) }}</td> @php $x = $x + $value->Plan6; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan6,1) }}</td> @php $x = $x + $value->Plan7; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan7,1) }}</td> @php $x = $x + $value->Plan8; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan8,1) }}</td> @php $x = $x + $value->Plan9; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan9,1) }}</td> @php $x = $x + $value->Plan10; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan10,1) }}</td> @php $x = $x + $value->Plan11; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan11,1) }}</td> @php $x = $x + $value->Plan12; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan12,1) }}</td> @php $x = $x + $value->Plan13; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan13,1) }}</td> @php $x = $x + $value->Plan14; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan14,1) }}</td> @php $x = $x + $value->Plan15; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan15,1) }}</td> @php $x = $x + $value->Plan16; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan16,1) }}</td> @php $x = $x + $value->Plan17; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan17,1) }}</td> @php $x = $x + $value->Plan18; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan18,1) }}</td> @php $x = $x + $value->Plan19; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan19,1) }}</td> @php $x = $x + $value->Plan20; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan20,1)}}</td> @php $x = $x + $value->Plan21; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan21,1) }}</td> @php $x = $x + $value->Plan22; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan22,1) }}</td> @php $x = $x + $value->Plan23; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan23,1) }}</td> @php $x = $x + $value->Plan24; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan24,1) }}</td> @php $x = $x + $value->Plan25; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan25,1) }}</td> @php $x = $x + $value->Plan26; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan26,1) }}</td> @php $x = $x + $value->Plan27; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan27,1) }}</td> @php $x = $x + $value->Plan28; @endphp
                    <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan28,1) }}</td> @php $x = $x + $value->Plan29; @endphp
                    @if ( $dayinmonth >= 29 )
                        <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan29,1) }}</td> @php $x = $x + $value->Plan30; @endphp
                    @endif
                    @if ( $dayinmonth >= 30 )
                        <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan30,1) }}</td> @php $x = $x + $value->Plan31; @endphp
                    @endif
                    @if ( $dayinmonth == 31 )
                        <td class="text-center @if ($x>90) text-danger @elseif ($x>60) text-warning @elseif ($x>30) text-success @endif">{{ number_format($value->Plan31,1) }}</td>
                    @endif
                    <td rowspan="2" class="text-center">{{ number_format($value->SumActual,1) }} <br> ({{ $value->MaxActualDate }})</td>
                    <td rowspan="2" class="text-center">{{ number_format($value->TotalOT,1) }}</td>
                    <td rowspan="2" class="text-center">{{ $value->Frame }} <br> ({{ $value->UpdateFrame }})</td>
                </tr>
                @php
                    $j++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <div class="row">
        <div class="col-1">
            *หมายเหตุ
        </div>
        <div class="col text-success text-left">
            - สีเขียวหมายถึงล่วงเวลาสะสม 30 - 60 ชั่วโมง
        </div>
    </div>
    <div class="row">
        <div class="col-1"></div>
        <div class="col text-warning text-left">
            - สีเหลืองหมายถึงล่วงเวลาสะสม 60 - 90 ชั่วโมง
        </div>
    </div>
    <div class="row">
        <div class="col-1"></div>
        <div class="col text-danger text-left">
            - สีแดงหมายถึงล่วงเวลาสะสมมากกว่า 90 ชั่วโมง
        </div>
    </div>
@endsection
