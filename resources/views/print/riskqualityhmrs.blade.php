@extends('layouts.printl')

@section('title','Quality Assesment')

@section('content')
    <h3 class="text-center">แบบบัญชีระบุ และจัดการความเสี่ยง/โอกาส ด้านคุณภาพ อาชีวอนามัยและความปลอดภัย ปี _______</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td rowspan="2">
                        ความเสี่ยงของ <u>รวธ. ชธธ. {{$department->Department}} {{$department->Section}}</u> (โครงการ สายงาน-ผู้ช่วยผู้ว่าการ-ฝ่าย-กอง-แผนก) <br>
                        หัวข้อ <u> การประเมินความเสี่ยง </u> ปรับปรุงครั้งที่ _______<br>
                        ปัจจัยที่พิจารณาทั้งหมด <u>{{ count($factor) }}</u>
                    </td>
                    <td>
                        ความเสี่ยงเกี่ยวกับ  <input type="checkbox"> นโยบาย  <input type="checkbox"> ภารกิจ  <input type="checkbox"> แผนงาน  <input type="checkbox"> เป้าหมาย  <input type="checkbox" checked> ผลิตภัณฑ์และบริการ <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        ระบบงาน <input type="checkbox" checked> คุณภาพ ISO 9001 <input type="checkbox" checked> อาชีวอนามัยและความปลอดภัย ISO 45001
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">ลำดับ</th>
                    <th rowspan="2" class="text-center align-middle">ปัจจัยพิจารณา</th>
                    <th rowspan="2" class="text-center align-middle">ลักษณะความเสี่ยงที่อาจทำให้ไม่เป็นตามข้อกำหนด/ไม่บรรลุผล</th>
                    <th rowspan="2" class="text-center align-middle">ลักษณะของผลกระทบ</th>
                    <th colspan="3" class="text-center align-middle">ประเมินความเสี่ยง</th>
                    <th colspan="2" class="text-center align-middle">โอกาสในการพัฒนา</th>
                    <th rowspan="2" class="text-center align-middle">มาตรการจัดการความเสี่ยง/โอกาส<br>(ตามหมายเหตุท้ายแบบฟอร์ม)</th>
                    <th rowspan="2" class="text-center align-middle">เครื่องมือหรือวิธีการติดตามประเมินผล</th>
                </tr>
                <tr>
                    <th class="text-center align-middle" style="width:3%">โอกาสเกิด</th>
                    <th class="text-center align-middle" style="width:3%">ผลกระทบ</th>
                    <th class="text-center align-middle" style="width:5%">ระดับความเสี่ยง</th>
                    <th class="text-center align-middle" style="width:2%">มี</th>
                    <th class="text-center align-middle" style="width:2%">ไม่มี</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $factor = '';
                    $i = 1;
                @endphp
                @foreach ($risk as $value)
                    <tr>
                        @if ( $value->Factor <> $factor )
                            <td rowspan="{{$value->CountOfFactor}}" class="text-center"> {{$i}} </td>
                            <td rowspan="{{$value->CountOfFactor}}"> {{$value->Factor }} </td>
                            @php
                                $factor = $value->Factor;
                                $i++;
                            @endphp
                        @endif
                        <td>{{$value->TypeofRisk}}</td>
                        <td>{{$value->Effect}}</td>
                        <td></td>
                        <td class="text-center">{{$value->EffectValue}}</td>
                        <td></td>
                        <td class="text-center">/</td>
                        <td></td>
                        <td>{{$value->Measure}}</td>
                        <td>{{$value->Followup}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-sm">
            <tbody>
                <tr>
                    <td class="text-right">ผู้จัดทำ</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-center">(................................................................)</td>
                    <td class="text-right">ตำแหน่ง</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-right">วันที่</td>
                    <td class="text-center">................................................................</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right">ผู้รับรอง</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-center">(................................................................)</td>
                    <td class="text-right">ตำแหน่ง</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-right">วันที่</td>
                    <td class="text-center">................................................................</td>
                    <td>(ระดับหัวหน้างานขึ้นไป/ผู้รับผิดชอบ)</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="text-right">FM-002/QP-PB-039 Rev.02</p>
@endsection
