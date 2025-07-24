@extends('layouts.printl')

@section('title','Risk Assesment')

@section('content')
    <h3 class="text-center">มาตรการควบคุมความเสี่ยงในงาน {{$project->ProjectName}}</h3>
    หน่วยงาน หบน-ธ. กฟน-ธ. อบค.
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">ลำดับ</th>
                    <th rowspan="2" class="text-center align-middle">แหล่งกำเนิดอันตราย</th>
                    <th rowspan="2" class="text-center align-middle">ลักษณะการเกิดอันตราย</th>
                    <th rowspan="2" class="text-center align-middle">ผลกระทบ</th>
                    <th colspan="8" class="text-center align-middle">มาตรการควบคุมความเสี่ยง</th>
                    <th rowspan="2" class="text-center align-middle">เพิ่มเติม</th>
                </tr>
                <tr>
                    <th class="text-center align-middle">จำนวนคนที่ปฏิบัติ</th>
                    <th class="text-center align-middle">การสัมผัสแหล่งอันตราย</th>
                    <th class="text-center align-middle">ขั้นตอนการปฏิบัติงาน</th>
                    <th class="text-center align-middle">การอบรม</th>
                    <th class="text-center align-middle">อุปกรณ์ป้องกันภัยส่วนบุคคล (PPE)</th>
                    <th class="text-center align-middle">อุปกรณ์/เครื่องมือความปลอดภัย</th>
                    <th class="text-center align-middle">การตรวจการทำงาน/ความปลอดภัย</th>
                    <th class="text-center align-middle">การเตือนอันตราย</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $hazard = '';
                    $kindofhazard = '';
                    $effect = '';
                @endphp
                @foreach ($risk as $value)
                    <tr>
                        @if ( $value->HazardName <> $hazard )
                            <td rowspan="{{$value->CountOfHazardName}}" class="text-center"> {{$i}} </td>
                            <td rowspan="{{$value->CountOfHazardName}}"> {{$value->HazardName }} </td>
                            @php
                                $hazard = $value->HazardName;
                                $i++;
                            @endphp
                        @endif
                        @if ( $value->CodeKindofHazard <> $kindofhazard )
                            <td rowspan="{{$value->CountOfKindofHazard}}"> {{$value->KindofHazard }} </td>
                            @php
                                $kindofhazard = $value->CodeKindofHazard;
                            @endphp
                        @endif
                        @if ( $value->CodeEffect <> $effect )
                            <td rowspan="{{$value->CountOfEffect}}"> {{$value->Effect }} </td>
                            @php
                                $effect = $value->CodeEffect;
                            @endphp
                        @endif
                        <td class="text-center align-middle">
                            @if ($value->ManPower == 1 OR $value->ManPower == 2 OR $value->ManPower == 3)
                                <i class="fa fa-lg fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if ($value->Contact == 1 OR $value->Contact == 2 OR $value->Contact == 3)
                                <i class="fa fa-lg fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if ($value->Procedure == 1 OR $value->Procedure == 2 OR $value->Procedure == 3)
                                <i class="fa fa-lg fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if ($value->Training == 1 OR $value->Training == 2 OR $value->Training == 3)
                                <i class="fa fa-lg fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if ($value->PPE == 1 OR $value->PPE == 2 OR $value->PPE == 3)
                                <i class="fa fa-lg fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if ($value->SafetyEquipment == 1 OR $value->SafetyEquipment == 2 OR $value->SafetyEquipment == 3)
                                <i class="fa fa-lg fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if ($value->Verification == 1 OR $value->Verification == 2 OR $value->Verification == 3)
                                <i class="fa fa-lg fa-fw fa-check"></i>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if ($value->SafetySign == 1 OR $value->SafetySign == 2 OR $value->SafetySign == 3)
                                <i class="fa fa-lg fa-fw fa-check"></i>
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
                    <td rowspan="4" class="text-right" style="width:25%">1.)ลงชื่อผู้ปฏิบัติงาน</td>
                    <td class="text-center" style="width:25%">......................................................</td>
                    <td rowspan="4" class="text-right" style="width:25%">2.)ลงชื่อผู้ควบคุมงาน</td>
                    <td class="text-center" style="width:25%">......................................................</td>
                </tr>
                <tr>
                    <td class="text-center">(......................................................)</td>
                    <td class="text-center">(......................................................)</td>
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
                    <td class="text-center" style="width:33%">แผนกบำรุงรักษาโรงไฟฟ้าพลังน้ำและพลังงานหมุนเวียน</td>
                    <td class="text-center"></td>
                    <td class="text-center" style="width:33%">Rev.0</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
