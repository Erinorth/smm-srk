@extends('layouts.printl')

@section('title','Risk Assesment')

@section('content')
    <h3 class="text-center">แบบฟอร์มการประเมินความเสี่ยง</h3>
    หน่วยงาน หบน-ธ. กฟน-ธ. อบค. (Master)
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">ลำดับ</th>
                    <th rowspan="2" class="text-center align-middle">[ ] งาน/กิจกรรม <br> [ ] พื้นที่</th>
                    <th rowspan="2" class="text-center align-middle">แหล่งกำเนิดอันตราย</th>
                    <th rowspan="2" class="text-center align-middle">ลักษณะการเกิดอันตราย</th>
                    <th rowspan="2" class="text-center align-middle">ผลกระทบ</th>
                    <th colspan="3" class="text-center align-middle">ความรุนแรง</th>
                    <th colspan="9" class="text-center align-middle">โอกาสที่เกิด</th>
                    <th rowspan="2" class="text-center align-middle" style="width:5%">ระดับความเสี่ยง</th>
                    <th rowspan="2" class="text-center align-middle">มาตรการควบคุมความเสี่ยง</th>
                </tr>
                <tr>
                    <th class="text-center align-middle">มาก</th>
                    <th class="text-center align-middle">ปานกลาง</th>
                    <th class="text-center align-middle">น้อย</th>
                    <th class="text-center align-middle">1</th>
                    <th class="text-center align-middle">2</th>
                    <th class="text-center align-middle">3</th>
                    <th class="text-center align-middle">4</th>
                    <th class="text-center align-middle">5</th>
                    <th class="text-center align-middle">6</th>
                    <th class="text-center align-middle">7</th>
                    <th class="text-center align-middle">8</th>
                    <th class="text-center align-middle" style="width:3%">ผล %</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $hazardx = '';
                    $kindofhazard = '';
                @endphp
                @foreach ($hazard as $value)
                    <tr>
                        @if ( $value->HazardName <> $hazardx )
                            <td rowspan="{{$value->CountOfHazardName}}" class="text-center"> {{$i}} </td>
                            <td rowspan="{{$value->CountOfHazardName}}">Master</td>
                            <td rowspan="{{$value->CountOfHazardName}}"> {{$value->HazardName }} </td>
                            @php
                                $i++;
                                $hazardx = $value->HazardName;
                            @endphp
                        @endif
                        @if ( $value->code_kindofhazard <> $kindofhazard )
                            <td rowspan="{{$value->CountOfKindofHazard}}"> {{$value->KindofHazard }} </td>
                            @php
                                $kindofhazard = $value->code_kindofhazard;
                            @endphp
                        @endif
                        <td>{{$value->Effect}}</td>
                        <td class="text-center">
                            @if ($value->Severity =='มาก')
                                /
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->Severity =='ปานกลาง')
                                /
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->Severity =='น้อย')
                                /
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->ManPower =='No')
                                -
                            @else
                                {{$value->ManPower}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->Contact =='No')
                                -
                            @else
                                {{$value->Contact}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->Procedure =='No')
                                -
                            @else
                                {{$value->Procedure}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->Training =='No')
                                -
                            @else
                                {{$value->Training}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->PPE =='No')
                                -
                            @else
                                {{$value->PPE}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->SafetyEquipment =='No')
                                -
                            @else
                                {{$value->SafetyEquipment}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->Verification =='No')
                                -
                            @else
                                {{$value->Verification}}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($value->SafetySign =='No')
                                -
                            @else
                                {{$value->SafetySign}}
                            @endif
                        </td>
                        <td>{{$value->Opportunity}}</td>
                        <td>
                            @if ( $value->Opportunity > 66.67)
                                @if ( $value->Severity =='มาก' )
                                    ความเสี่ยงยอมรับไม่ได้
                                @elseif ( $value->Severity =='ปานกลาง' )
                                    ความเสี่ยงสูง
                                @else
                                    ความเสี่ยงปานกลาง
                                @endif
                            @elseif ( $value->Opportunity > 45.83)   
                                @if ( $value->Severity =='มาก' )
                                    ความเสี่ยงสูง
                                @elseif ( $value->Severity =='ปานกลาง' )
                                        ความเสี่ยงปานกลาง
                                @else
                                    ความเสี่ยงยอมรับได้
                                @endif
                            @else
                                @if ( $value->Severity =='มาก' )
                                    ความเสี่ยงปานกลาง
                                @elseif ( $value->Severity =='ปานกลาง' )
                                    ความเสี่ยงยอมรับได้
                                @else
                                    ความเสี่ยงเล็กน้อย
                                @endif
                            @endif
                        </td>
                        <td>{{$value->HazardControl}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-sm">
            <tbody>
                <tr>
                    <td rowspan="4" class="text-right" style="width:25%">1.)ลงชื่อผู้ประเมิน</td>
                    <td class="text-center" style="width:25%">......................................................</td>
                    <td rowspan="4" class="text-right" style="width:25%">2.)ลงชื่อผู้ทบทวน</td>
                    <td class="text-center" style="width:25%">......................................................</td>
                </tr>
                <tr>
                    <td class="text-center">(......................................................)</td>
                    <td class="text-center">(......................................................)</td>
                </tr>
                <tr>
                    <td class="text-center">......................................................</td>
                    <td class="text-center">......................................................</td>
                </tr>
                <tr>
                    <td class="text-center">วันที่ .......... / .......... / ..........</td>
                    <td class="text-center">วันที่ .......... / .......... / ..........</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td class="text-center" style="width:33%">รองผู้ว่าการธุรกิจเกี่ยวเนื่อง</td>
                    <td class="text-center">FM-001/QP-PB-029</td>
                    <td class="text-center" style="width:33%">Rev.0</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
