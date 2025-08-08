@extends('adminlte::page')

@section('title','Performance Evaluation')

@section('content_header')
    <h1 class="m-0 text-dark">Performance</h1>
@stop

@section('content')
    <x-header.project projectId="{{$project->id}}">
        <x-slot name="collapseCard"></x-slot>
        <x-slot name="title">Detail</x-slot>
        <x-slot name="tool"></x-slot>
        <x-slot name="collapseButton">minus</x-slot>
    </x-header.project>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Performance</h3>
                    <div class="card-tools">
                        @if ( count($performance) == 0 )
                            <button class="btn btn-xs btn-default text-warning mx-1 shadow" name="create_record" id="create_record" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        @else
                            @foreach ($performance as $value)
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="{{$value->id}}" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            @endforeach
                        @endif
                        {{-- <a class="btnprn btn btn-info btn-sm" href="{{url('performance_weekly/'.$project->id)}}">Weekly Report</a> --}}
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table table-bordered table-sm">
                        <thead>
                            <th class="text-center">หัวข้อการประเมิน</th>
                            <th class="text-center">เป้าหมาย</th>
                            <th class="text-center">ผลการปฏิบัติ</th>
                            <th class="text-center">น้ำหนัก</th>
                            <th class="text-center">ผลการประเมิน</th>
                        </thead>
                        <tbody>
                            @php
                                $SafetyHealthAll = 30;
                                $QualityAll = 20;
                                $DurationAll = 20;
                                if ( $performance->SafetyHealth == "" ) { $ManHoursAll = 0; } else { $ManHoursAll = 3; }
                            @endphp
                            <tr>
                                <td><b>ผลการดำเนินงานทางด้านอาชีวะอนามัยและความปลอดภัย</b></td>
                                <td>จำนวนการเกิดอุบัติเหตุเป็น 0</td>
                                <td>
                                    @if ( count($performance->SafetyHealth) != "" )
                                        @if ( $performance->SafetyHealth == 5 )
                                            ไม่เกิดอุบัติเหตุ และมีข้อเสนอแนะ (5)
                                        @elseif ( $performance->SafetyHealth == 4 )
                                            ไม่เกิดอุบัติเหตุ (4)
                                        @elseif ( $performance->SafetyHealth == 3 )
                                            เกิดอุบัติเหตุ 1 ครั้ง, ทำตามมาตรฐาน (3)
                                        @elseif ( $performance->SafetyHealth == 2 )
                                            เกิดอุบัติเหตุ 1 ครั้ง, ไม่ทำตามมาตรฐาน (2)
                                        @elseif ( $performance->SafetyHealth == 1 )
                                            เกิดอุบัติเหตุมากกว่า 1 ครั้ง, ไม่ทำตามมาตรฐาน (1)
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">30%</td>
                                <td class="text-center">
                                    @if ( count($performance) != "" )
                                        @php
                                            if ( $performance->SafetyHealth == 5 ) {
                                                $SafetyHealth = 30;
                                            } elseif ( $performance->SafetyHealth == 4 ) {
                                                $SafetyHealth = 24;
                                            } elseif ( $performance->SafetyHealth == 3 ) {
                                                $SafetyHealth = 18;
                                            } elseif ( $performance->SafetyHealth == 2 ) {
                                                $SafetyHealth = 12;
                                            } else {
                                                $SafetyHealth = 6;
                                            }
                                        @endphp
                                        {{ number_format($SafetyHealth,2) }}
                                    @else
                                        @php
                                            $SafetyHealth = 0;
                                        @endphp
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b>ผลการดำเนินงานทางด้านคุณภาพ</b></td>
                                <td>จำนวนงานที่เกิด Rework, Claim, Complain เป็น 0</td>
                                <td>
                                    @if ( count($performance) != 0 )
                                        @foreach ($performance as $value)
                                            @if ( $value->Quality == 5 )
                                                ไม่เกิดงาน Claim, Complain, Rework และมีข้อเสนอแนะ (5)
                                            @elseif ( $value->Quality == 4 )
                                                ไม่เกิดงาน Claim, Complain, Rework (4)
                                            @elseif ( $value->Quality == 3 )
                                                เกิดงาน Claim, Complain, Rework 1 ครั้ง, ทำตามมาตรฐาน (3)
                                            @elseif ( $value->Quality == 2 )
                                                เกิดงาน Claim, Complain, Rework 1 ครั้ง, ไม่ทำตามมาตรฐาน (2)
                                            @elseif ( $value->Quality == 1 )
                                                เกิดงาน Claim, Complain, Reworkมากกว่า 1 ครั้ง, ไม่ทำตามมาตรฐาน (1)
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center">20%</td>
                                <td class="text-center">
                                    @if ( count($performance) != 0 )
                                        @foreach ($performance as $value)
                                            @php
                                                if ( $value->Quality == 5 ) {
                                                    $Quality = 20;
                                                } elseif ( $value->Quality == 4 ) {
                                                    $Quality = 16;
                                                } elseif ( $value->Quality == 3 ) {
                                                    $Quality = 12;
                                                } elseif ( $value->Quality == 2 ) {
                                                    $Quality = 8;
                                                } else {
                                                    $Quality = 4;
                                                }
                                            @endphp
                                            {{ number_format($Quality,2) }}
                                        @endforeach
                                    @else
                                        @php
                                            $Quality = 0;
                                        @endphp
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b>ผลการดำเนินงานทางด้านระยะเวลาการส่งมอบ</b></td>
                                <td>ส่งมอบตามระยะเวลาหรือเร็วกว่าที่ตกลงกับลูกค้า</td>
                                <td class="text-center">
                                    @foreach ($performance as $value)
                                        {{ $value->Duration }}
                                    @endforeach
                                </td>
                                <td class="text-center">20%</td>
                                <td class="text-center">
                                    @if ( count($performance) != 0 )
                                        @foreach ( $performance as $value )
                                            @php
                                                if ( $value->Duration > 48 ) {
                                                    $Duration = 1;
                                                } elseif ( $value->Duration < -48 ) {
                                                    $Duration = 5;
                                                } else {
                                                    $Duration = 20*((5-(4*(($value->Duration-48+96)/96)))/5);
                                                }
                                            @endphp
                                            {{ number_format($Duration,2) }}
                                        @endforeach
                                    @else
                                        @php
                                            $Duration = 0;
                                        @endphp
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b>ผลการดำเนินงานทางด้านการจัดการต้นทุนงาน</b></td>
                                <td style="background-color:gray;"></td>
                                <td style="background-color:gray;"></td>
                                <td class="text-center" >10%</td>
                                <td class="text-center" style="background-color:gray;">
                                    @if ( count($performance) != 0 )
                                        @foreach ( $performance as $value )
                                            @php
                                                if ( $value->ManHour > 40 ) {
                                                    $ManHour = 0.6;
                                                } else {
                                                    $ManHour = 3*((5-(4*($value->ManHour/40)))/5);
                                                }

                                                if ( $value->WastingTime > 12 ) {
                                                    $WastingTime = 0.6;
                                                } else {
                                                    $WastingTime = 3*((5-(4*($value->WastingTime/12)))/5);
                                                }
                                                if ( $value->ManHourRatio > 50 ) {
                                                    $ManHourRatio = 0.8;
                                                } elseif ( $value->ManHourRatio < 10 ) {
                                                    $ManHourRatio = 4;
                                                } else {
                                                    $ManHourRatio = (4*(3-(($value->ManHourRatio-30)/10)))/5;
                                                }
                                                $Cost = $ManHour + $WastingTime + $ManHourRatio;
                                            @endphp
                                            {{ number_format($Cost,2) }}
                                        @endforeach
                                    @else
                                        @php
                                            $Cost = 0;
                                        @endphp
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>การควบคุม Man-Hour ในแต่ละงาน</td>
                                <td>% จำนวนงานที่มี Man-Hour สูงกว่าประมาณการเป็น 0</td>
                                <td class="text-center">
                                    @foreach ($performance as $value)
                                        {{$value->ManHour}}
                                    @endforeach
                                </td>
                                <td class="text-center" style="background-color:gray;">3%</td>
                                <td class="text-center">
                                    @if ( count($performance) != 0 )
                                        {{ number_format($ManHour,2) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>การควบคุม Man-Hour ให้คุ้มค่า (Waiting/Idle)</td>
                                <td>% จำนวน Man-Hour ใน Admin/Support ต่อ งานอื่นๆเป็น 0</td>
                                <td class="text-center">
                                    @foreach ($performance as $value)
                                        {{$value->WastingTime}}
                                    @endforeach
                                </td>
                                <td class="text-center" style="background-color:gray;">3%</td>
                                <td class="text-center">
                                    @if ( count($performance) != 0 )
                                        {{ number_format($WastingTime,2) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>สัดส่วน Support ต่อ Direct (Support)</td>
                                <td>น้อยกว่า 30%</td>
                                <td class="text-center">
                                    @foreach ($performance as $value)
                                        {{$value->ManHourRatio}}
                                    @endforeach
                                </td>
                                <td class="text-center" style="background-color:gray;">4%</td>
                                <td class="text-center">
                                    @if ( count($performance) != 0 )
                                        {{ number_format($ManHourRatio,2) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b>การดำเนินงานตามมาตรฐานคุณภาพ อาชีวะอนามัยและความปลอดภัย</b></td>
                                <td>จำนวนงานที่ปฏิบัติตามมาตรฐานครบถ้วน</td>
                                <td style="background-color:gray;"></td>
                                <td class="text-center">20%</td>
                                <td class="text-center" style="background-color:gray;">
                                    @if ( count($performance) != 0 )
                                        @foreach ($performance as $value)
                                            @php
                                                $plan = $value->RiskPlan + $value->ManCertificatePlan + $value->ToolCertificatePlan + $value->CheckListPlan
                                                + $value->ParticipationPlan + $value->SafetyReportPlan + $value->SafetyTalkPlan + $value->WorkPermitPlan + $value->HotWorkPlan
                                                + $value->ConfinedSpacePlan + $value->LiftingPlan + $value->ScaffoldingPlan + $value->WindTurbinePlan + $value->SubcontractorPlan
                                                + $value->NonConformingPlan + $value->DamagePlan + $value->AdditionalPlan + $value->TakeCarePlan + $value->ObservationPlan
                                                + $value->IncidentPlan;

                                                $actual = $value->RiskActual + $value->ManCertificateActual + $value->ToolCertificateActual + $value->CheckListActual
                                                + $value->ParticipationActual + $value->SafetyReportActual + $value->SafetyTalkActual + $value->WorkPermitActual + $value->HotWorkActual
                                                + $value->ConfinedSpaceActual + $value->LiftingActual + $value->ScaffoldingActual + $value->WindTurbineActual + $value->SubcontractorActual
                                                + $value->NonConformingActual + $value->DamageActual + $value->AdditionalActual + $value->TakeCareActual + $value->ObservationActual
                                                + $value->IncidentPlan;

                                                if ( $plan != 0 ) {
                                                    $ISO = 15*($actual/$plan);
                                                } else {
                                                    $ISO = 0;
                                                }

                                                if ( $value->MileStonePlan == '' OR $value->MileStonePlan == 0) {
                                                    $MileStone = 0;
                                                } else {
                                                    $MileStone = 5*($value->MileStoneActual/$value->MileStonePlan);
                                                }

                                                $Standard = $ISO + $MileStone;
                                            @endphp
                                            {{ number_format($Standard,2) }}
                                        @endforeach
                                    @else
                                        @php
                                            $ISO = 0;
                                            $MileStone = 0;
                                            $Standard = 0;
                                        @endphp
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>การดำเนินงานตาม Mile Stone</td>
                                <td>
                                    สามารถดำเนินการตาม Milestone ได้อย่างครบถ้วน สมบูรณ์
                                </td>
                                <td class="text-center">
                                    @foreach ($performance as $value)
                                        {{$value->MileStoneActual}}
                                    @endforeach
                                </td>
                                <td class="text-center" style="background-color:gray;">5%</td>
                                <td class="text-center">
                                    {{ number_format($MileStone,2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>การดำเนินงานตามระบบ ISO</td>
                                <td>
                                    ดำเนินการตามระบบ ISO ได้ครบถ้วน สมบูรณ์
                                </td>
                                <td class="text-center">
                                    @foreach ($performance as $value)
                                        {{$value->KPI}}
                                    @endforeach
                                </td>
                                <td class="text-center" style="background-color:gray;">15%</td>
                                <td class="text-center">
                                    {{ number_format($MileStone,2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>รวม</b></td>
                                <td class="text-center">100%</td>
                                <td class="text-center">
                                    @php
                                        $total = $SafetyHealth + $Quality + $Duration + $Cost + $Standard;
                                    @endphp
                                    {{ number_format($total,2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"><b>KPI</b></td>
                                <td class="text-center">
                                    @foreach ($performance as $value)
                                        {{ number_format($value->KPI,2) }}
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal.input-form name-i-d="" modal-title="Create Evaluation">
        <x-input.dropdown title="ผลการดำเนินงานทางด้านอาชีวะอนามัยและความปลอดภัย" name-id="SafetyHealth">
            <option></option>
            <option value="5">ไม่เกิดอุบัติเหตุ และมีข้อเสนอแนะ</option>
            <option value="4">ไม่เกิดอุบัติเหตุ</option>
            <option value="3">เกิดอุบัติเหตุ 1 ครั้ง, ทำตามมาตรฐาน</option>
            <option value="2">เกิดอุบัติเหตุ 1 ครั้ง, ไม่ทำตามมาตรฐาน</option>
            <option value="1">เกิดอุบัติเหตุมากกว่า 1 ครั้ง, ไม่ทำตามมาตรฐาน</option>
        </x-input.dropdown>

        <x-input.dropdown title="ผลการดำเนินงานทางด้านคุณภาพ" name-id="Quality">
            <option></option>
            <option value="5">ไม่เกิดงาน Claim, Complain, Rework และมีข้อเสนอแนะ</option>
            <option value="4">ไม่เกิดงาน Claim, Complain, Rework</option>
            <option value="3">เกิดงาน Claim, Complain, Rework 1 ครั้ง, ทำตามมาตรฐาน</option>
            <option value="2">เกิดงาน Claim, Complain, Reworkมากกว่า 1 ครั้ง, ทำตามมาตรฐาน</option>
            <option value="1">เกิดงาน Claim, Complain, Reworkมากกว่า 1 ครั้ง, ไม่ทำตามมาตรฐาน</option>
        </x-input.dropdown>

        <x-input.text title="ผลการดำเนินงานทางด้านระยะเวลาการส่งมอบ (นับเป็นชั่วโมง หากเร็วกว่าให้ใส่ลบ(-) หากช้ากว่าให้ใส่เลขปกติ)" name-id="Duration"/>

        <x-input.text title="% จำนวนงานที่มี Man-Hour สูงกว่าประมาณการ" name-id="ManHour"/>

        <x-input.text title="% จำนวน Man-Hour ใน Admin/Support ต่อ งานอื่นๆ" name-id="WastingTime"/>

        <x-input.text title="% สัดส่วน Support ต่อ Direct" name-id="ManHourRatio"/>

        <x-input.text-column title="การปฏิบัติตาม Mile Stone" name-id-a="MileStonePlan" name-id-b="MileStoneActual" placeholder-a="Target" placeholder-b="Actual"/>

        <x-input.text title="การดำเนินงานตามระบบ ISO" name-id="ISO"/>

        @role('admin|head_operation')
            <x-input.text title="KPI" name-id="KPI"/>
        @endrole

        <x-slot name="othervalue">
            <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}" />
        </x-slot>
    </x-modal.input-form>

    <x-modal.confirm-delete delete-name=""/>
@endsection

@section('js')
    <script>
        $(document).ready(function(){

            <x-data-table.create-script name-i-d="" title="Add Performance Evaluation"/>

            <x-data-table.submit-script name-i-d="" action-url="performance_projects">
                location.reload();
            </x-data-table.submit-script>

            <x-data-table.edit-script edit-name=""  edit-url="{{ url('/performance_projects') }}">
                <x-data-table.edit-value-script name="SafetyHealth"/>
                <x-data-table.edit-value-script name="Quality"/>
                <x-data-table.edit-value-script name="Duration"/>
                <x-data-table.edit-value-script name="ManHour"/>
                <x-data-table.edit-value-script name="WastingTime"/>
                <x-data-table.edit-value-script name="ManHourRatio"/>
                <x-data-table.edit-value-script name="MileStonePlan"/>
                <x-data-table.edit-value-script name="MileStoneActual"/>
                <x-data-table.edit-value-script name="ISO"/>
                <x-data-table.edit-value-script name="KPI"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="performance_projects"/>
        });
    </script>
@endsection
