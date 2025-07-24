@extends('layouts.printl')

@section('title','Tool Calibrate Plan')

@section('content')
    <table class="table table-borderless table-sm">
        <tr>
            <td class="text-center"><h6>แผนการสอบเทียบเครื่องมือวัด <br>
                ประจำปี <u>{{ $year }}</u></h6>
            </td>
        </tr>
        <tr>
            <td>หน่วยงาน <u>กฟนม-ธ. อบค.</u></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td rowspan="2" class="text-center">ลำดับที่</td>
                <td rowspan="2" class="text-center">ชื่อเครื่องมือวัด</td>
                <td rowspan="2" class="text-center">รหัส</td>
                <td rowspan="2" class="text-center">หน่วยงานสอบเทียบ</td>
                <td colspan="4" class="text-center">Jan</td>
                <td colspan="4" class="text-center">Feb</td>
                <td colspan="4" class="text-center">Mar</td>
                <td colspan="4" class="text-center">Apr</td>
                <td colspan="4" class="text-center">May</td>
                <td colspan="4" class="text-center">Jun</td>
                <td colspan="4" class="text-center">Jul</td>
                <td colspan="4" class="text-center">Aug</td>
                <td colspan="4" class="text-center">Sep</td>
                <td colspan="4" class="text-center">Oct</td>
                <td colspan="4" class="text-center">Nov</td>
                <td colspan="4" class="text-center">Dec</td>
            </tr>
            <tr>
                @for ($i = 0; $i < 12; $i++)
                    <td class="text-center">1</td>
                    <td class="text-center">2</td>
                    <td class="text-center">3</td>
                    <td class="text-center">4</td>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($plan as $value)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $value->CatagoryName }} {{ $value->RangeCapacity }}</td>
                    <td>{{ $value->LocalCode }}</td>
                    <td>{{ $value->Calibrator }}</td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PJan <> 0 and $value->AJan <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PJan == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->AJan == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PFeb <> 0 and $value->AFeb <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PFeb == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->AFeb == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PMar <> 0 and $value->AMar <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PMar == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->AMar == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PApr <> 0 and $value->AApr <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PApr == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->AApr == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PMay <> 0 and $value->AMay <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PMay == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->AMay == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PJun <> 0 and $value->AJun <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PJun == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->AJun == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PJul <> 0 and $value->AJul <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PJul == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->AJul == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PAug <> 0 and $value->AAug <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PAug == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <div></div>
                        @elseif ( $value->AAug == 1 )
                            <div></div> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PSep <> 0 and $value->ASep <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PSep == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <div></div>
                        @elseif ( $value->ASep == 1 )
                            <div></div> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->POct <> 0 and $value->AOct <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->POct == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->AOct == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PNov <> 0 and $value->ANov <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PNov == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->ANov == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                    <td colspan="4" class="text-center">
                        @if ( $value->PDec <> 0 and $value->ADec <> 0 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg> <br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @elseif ( $value->PDec == 1 )
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            <div></div>
                        @elseif ( $value->ADec == 1 )
                            <div></div><br>
                            <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        @endif
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            <tr>
                <td colspan="52">
                    <div class="row">
                        <div class="col-6 text-center">
                            Plan &nbsp; <svg width="50" height="10"><rect width="50" height="10" style="fill:white; stroke-width:1; stroke:black" /></svg><br>
                            Actual &nbsp; <svg width="50" height="10"><rect width="50" height="10" style="fill:black; stroke-width:1; stroke:black" /></svg>
                        </div>
                        <div class="col-6 text-center">
                            <br><br>
                            ลงชื่อ <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> หัวหน้าหน่วยงาน <br><br>
                            ( <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u> ) <br><br>
                            วันที่ <u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>/<u>&emsp;&emsp;&emsp;&emsp;</u>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width: 33.33%"><h6>รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</h6></td>
            <td class="text-center" style="width: 33.34%">รหัสเอกสาร FM-002/QP-PB-017</td>
            <td class="text-center" style="width: 33.33%">แก้ไขครั้งที่ 01</td>
        </tr>
    </table>
@endsection