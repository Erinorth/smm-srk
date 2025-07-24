@extends('layouts.printl')

@section('title','Tool PM Plan')

@section('content')
    <table class="table table-borderless table-sm">
        <tr>
            <td class="text-center"><h6>แผนการบารุงรักษาเชิงป้องกันเครื่องมืออุปกรณ์ประจาปี <u>{{ $year }}</u></h6></td>
        </tr>
        <tr>
            <td>เรียน <u>กฟนม-ธ.</u> แผนก <u>หบนม-ธ.</u> กอง <u>กฟนม-ธ.</u> ฝ่าย <u>อบค.</u></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td rowspan="2" class="text-center">ลำดับที่</td>
                <td rowspan="2" class="text-center">รายชื่อเครื่องมืออุปกรณ์</td>
                <td rowspan="2" class="text-center">รายละเอียดการทำ PM</td>
                <td colspan="12" class="text-center">เดือน</td>
                <td rowspan="2" class="text-center">ผู้รับผิดชอบ</td>
                <td rowspan="2" class="text-center">หมายเหตุ</td>
            </tr>
            <tr>
                <td class="text-center">ม.ค.</td>
                <td class="text-center">ก.พ.</td>
                <td class="text-center">มี.ค.</td>
                <td class="text-center">เม.ย.</td>
                <td class="text-center">พ.ค.</td>
                <td class="text-center">มิ.ย.</td>
                <td class="text-center">ก.ค.</td>
                <td class="text-center">ส.ค.</td>
                <td class="text-center">ก.ย.</td>
                <td class="text-center">ต.ค.</td>
                <td class="text-center">พ.ย.</td>
                <td class="text-center">ธ.ค.</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($plan as $value)
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
                        @endif
                    </td>
                    <td>{!! nl2br($value->Activity) !!}</td>
                    <td class="text-center">
                        @if ( $value->PJan <> 0 and $value->AJan <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PJan == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->AJan == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PFeb <> 0 and $value->AFeb <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PFeb == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->AFeb == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PMar <> 0 and $value->AMar <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PMar == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->AMar == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PApr <> 0 and $value->AApr <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PApr == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->AApr == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PMay <> 0 and $value->AMay <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PMay == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->AMay == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PJun <> 0 and $value->AJun <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PJun == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->AJun == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PJul <> 0 and $value->AJul <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PJul == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->AJul == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PAug <> 0 and $value->AAug <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PAug == 1 )
                            <div style="background-color: red">P</div> <br>
                            <div></div>
                        @elseif ( $value->AAug == 1 )
                            <div></div> <br>
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PSep <> 0 and $value->ASep <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PSep == 1 )
                            <div style="background-color: red">P</div> <br>
                            <div></div>
                        @elseif ( $value->ASep == 1 )
                            <div></div> <br>
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->POct <> 0 and $value->AOct <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->POct == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->AOct == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PNov <> 0 and $value->ANov <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PNov == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->ANov == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ( $value->PDec <> 0 and $value->ADec <> 0 )
                            <div style="background-color: red">P</div> <br>
                            <div style="background-color: blue">A</div>
                        @elseif ( $value->PDec == 1 )
                            <div style="background-color: red">P</div>
                        @elseif ( $value->ADec == 1 )
                            <div style="background-color: blue">A</div>
                        @endif
                    </td>
                    <td class="text-center">{{ $value->Responsible }}</td>
                    <td></td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <table class="table table-borderless table-sm">
        <tr>
            <td>
                - หัวหน้างานจัดทาเสนอ หน.แผนกเพื่อพิจารณารับรอง <br>
                - หัวหน้าแผนกรวบรวมเสนอหัวหน้ากองเพื่อพิจารณาอนุมัติ <br>
                - หัวหน้ากองจัดทาในภาพรวมของกอง
            </td>
            <td class="text-center">
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผู้จัดทำ <br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br>
                ตำแหน่ง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
            </td>
            <td class="text-center">
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผู้รับรอง <br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br>
                ตำแหน่ง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
            </td>
            <td class="text-center">
                ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ผู้อนุมัติ <br>
                ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br>
                ตำแหน่ง <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> <br>
                วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width: 33.33%"><h6>รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</h6></td>
            <td class="text-center" style="width: 33.34%">FM-003/QP-PB-013</td>
            <td class="text-center" style="width: 33.33%">แก้ไขครั้งที่ 02</td>
        </tr>
    </table>
@endsection