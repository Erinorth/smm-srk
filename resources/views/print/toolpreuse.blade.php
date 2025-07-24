@extends('layouts.printl')

@section('title','Tool Pre Use')

@section('content')
    <table class="table table-borderless table-sm">
        <tr>
            <td class="text-center"><h6>แบบตรวจสอบเครื่องมืออุปกรณ์ก่อนการใช้งาน</h6></td>
        </tr>
        <tr>
            <td>เรียน <u>หบนม-ธ.</u> แผนก <u>หบนม-ธ.</u> กอง <u>กฟนม-ธ.</u> ฝ่าย <u>อบค.</u></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td colspan="{{ $day + 4}}+4">
                    @foreach ($tool as $value)
                        ชื่อเครื่องมือุปกรณ์ : <u>{{ $value->CatagoryName }}//{{ $value->LocalCode }}</u>
                        รหัสประจำตัวอุปกรณ์ : <u>{{ $value->SerialNumber }}</u>
                        ทะเบียน กฟผ. : <u>{{ $value->DurableSupplieCode }}//{{ $value->AssetToolCode }}</u>
                        ยี่ห้อ/รุ่น : <u>{{ $value->Brand }}/{{ $value->Model }}</u>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td rowspan="2" class="text-center">ลำดับที่</td>
                <td rowspan="2" colspan="2" class="text-center">รายการตรวจสอบ</td>
                <td colspan="{{ $day }}" class="text-center">เดือน : <u>{{ $month }}</u> ปี : <u>{{ $year }}</u></td>
                <td rowspan="2" class="text-center">หมายเหตุ</td>
            </tr>
            <tr>
                @for ($d = 1; $d <  10 ; $d++)
                    <td class="text-center">0{{ $d }}</td>
                @endfor
                @for ($d2 = 10; $d2 <  $day + 1 ; $d2++)
                    <td class="text-center">{{ $d2 }}</td>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($activity as $value)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td class="text-center" colspan="2">{{ $value->Activity }}</td>
                    @for ($j = 0; $j <  $day ; $j++)
                        <td class="text-center"></td>
                    @endfor
                    <td>{{ $value->Remark }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            <tr>
                <td colspan="2">
                    <i class="far fa-lg fa-fw fa-check-circle"></i> สภาพปกติ <br>
                    <i class="far fa-lg fa-fw fa-times-circle"></i> สภาพผิดปกติ ยังใช้งานได้ <br>
                    <i class="fa fa-lg fa-fw fa-circle"></i> สภาพผิดปกติ ต้องแก้ไขห้ามใช้งาน
                </td>
                <td class="text-center align-middle">ลงชื่่อผู้ตรวจสอบ</td>
                @for ($j = 0; $j <  $day ; $j++)
                    <td class="text-center"></td>
                @endfor
                <td class="text-center" style="width: 15%">
                    ผู้จัดทำ <br>
                    <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><br>
                    ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br>
                    วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width: 33.33%"><h6>รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</h6></td>
            <td class="text-center" style="width: 33.34%">FM-004/QP-PB-013</td>
            <td class="text-center" style="width: 33.33%">แก้ไขครั้งที่ 02</td>
        </tr>
    </table>
@endsection