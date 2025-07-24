@extends('layouts.printl')

@section('title','Tool Calibrate List')

@section('content')
    <h5 class="text-center">บัญชีรายชื่อเครื่องมือวัดที่ต้องสอบเทียบ</h5> <br>
    หน่วยงาน <u>หบนม-ธ. กฟนม-ธ. อบค.</u>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <td class="text-center">ลำดับที่</td>
                <td class="text-center">ชื่อเครื่องมือวัด</td>
                <td class="text-center">Manufacturer</td>
                <td class="text-center">Model</td>
                <td class="text-center">Serial No.</td>
                <td class="text-center">รหัส</td>
                <td class="text-center">Ranges</td>
                <td class="text-center">Accuracy</td>
                <td class="text-center">ค่าความผิดพลาดที่ยอมรับได้</td>
                <td class="text-center">ผู้ดูแลเครื่องมือ</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($tool as $value)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td>{{ $value->CatagoryName }} {{ $value->CatagoryName }}</td>
                    <td class="text-center">{{ $value->Brand }}</td>
                    <td class="text-center">{{ $value->Model }}</td>
                    <td class="text-center">{{ $value->SerialNumber }}</td>
                    <td class="text-center">
                        @if ( $value->LocalCode <> "" )
                            {{ $value->LocalCode }}
                        @endif
                        @if ( $value->DurableSupplieCode <> "" )
                             // {{ $value->DurableSupplieCode }}
                        @endif
                        @if ( $value->AssetToolCode <> "" )
                             // {{ $value->AssetToolCode }}
                        @endif
                    </td>
                    <td class="text-center">{{ $value->RangeCapacity }}</td>
                    <td class="text-center">{{ $value->Accuracy }}</td>
                    <td class="text-center">{{ $value->AcceptError }}</td>
                    <td class="text-center">{{ $value->Responsible }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
           <tr>
               <td colspan="10">
                   <br>
                   <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3 text-center">
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
            <td class="text-center">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
            <td class="text-center">รหัสเอกสาร FM-001/QP-PB-017</td>
            <td class="text-center">แก้ไขครั้งที่ 02</td>
        </tr>
    </table>
@endsection
