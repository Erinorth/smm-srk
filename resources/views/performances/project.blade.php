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
                        @foreach ( $performance as $value)
                            <tbody>
                                @php
                                    if ( is_null($value->SafetyHealth) ){
                                        $SafetyHealthAll = 0;
                                        $SafetyHealth = 0;
                                    } else {
                                        $SafetyHealthAll = 30;
                                        $SafetyHealth = $value->SafetyHealth * 6;
                                    }

                                    if ( is_null($value->Quality) ) {
                                        $QualityAll = 0;
                                        $Quality = 0;
                                    } else {
                                        $QualityAll = 20;
                                        $Quality = $value->Quality * 4;
                                    }

                                    if ( is_null($value->Duration) ) {
                                        $DurationAll = 0;
                                        $Duration = 0;
                                    } else {
                                        $DurationAll = 20;
                                        if ( $value->Duration > 48 ) {
                                            $Duration = 1;
                                        } elseif ( $value->Duration < -48 ) {
                                            $Duration = 5;
                                        } else {
                                            $Duration = 20*((5-(4*(($value->Duration-48+96)/96)))/5);
                                        }
                                    }

                                    if ( is_null($value->ManHour) ) {
                                        $ManHoursAll = 0;
                                        $ManHour = 0;
                                    } else {
                                        $ManHoursAll = 3;
                                        if ( $value->ManHour > 40 ) {
                                            $ManHour = 0.6;
                                        } else {
                                            $ManHour = 3*((5-(4*($value->ManHour/40)))/5);
                                        }
                                    }

                                    if ( is_null($value->WastingTime) ) {
                                        $WastingTimeAll = 0;
                                        $WastingTime = 0;
                                    } else {
                                        $WastingTimeAll = 3;
                                        if ( $value->WastingTime > 12 ) {
                                            $WastingTime = 0.6;
                                        } else {
                                            $WastingTime = 3*((5-(4*($value->WastingTime/12)))/5);
                                        }
                                    }

                                    if ( is_null($value->ManHourRatio) ) {
                                        $ManHourRatioAll = 0;
                                        $ManHourRatio = 0;
                                    } else {
                                        $ManHourRatioAll = 4;
                                        if ( $value->ManHourRatio > 50 ) {
                                            $ManHourRatio = 0.8;
                                        } elseif ( $value->ManHourRatio < 10 ) {
                                            $ManHourRatio = 4;
                                        } else {
                                            $ManHourRatio = (4*(3-(($value->ManHourRatio-30)/10)))/5;
                                        }
                                    }

                                    $CostAll = $ManHoursAll + $WastingTimeAll + $ManHourRatioAll;

                                    $CostTotal = $ManHour + $WastingTime + $ManHourRatio;

                                    if ( is_null($value->MileStone) ) {
                                        $MileStoneAll = 0;
                                        $MileStone = 0;
                                    } else {
                                        $MileStoneAll = 5;
                                        $MileStone = $value->MileStoneActual;
                                    }

                                    if ( is_null($value->ISO) ) {
                                        $ISOAll = 0;
                                        $ISO = 0;
                                    } else {
                                        $ISOAll = 15;
                                        $ISO = 15*($value->ISO)/5;
                                    }

                                    $StandardAll = $MileStoneAll + $ISOAll;

                                    $StandardTotal = $MileStone + $ISO;

                                    $TotalAll = $SafetyHealthAll + $QualityAll + $DurationAll + $CostAll + $StandardAll;

                                    $Total = $SafetyHealth + $Quality + $Duration + $CostTotal + $StandardTotal;
                                @endphp
                                <tr>
                                    <td><b>ผลการดำเนินงานทางด้านอาชีวะอนามัยและความปลอดภัย</b></td>
                                    <td>จำนวนการเกิดอุบัติเหตุเป็น 0</td>
                                    <td>
                                        @if ( $value->SafetyHealth == 5 )
                                            ไม่เกิดอุบัติเหตุ และมีข้อเสนอแนะ (5)
                                        @elseif ( $value->SafetyHealth == 4 )
                                            ไม่เกิดอุบัติเหตุ (4)
                                        @elseif ( $value->SafetyHealth == 3 )
                                            เกิดอุบัติเหตุ 1 ครั้ง, ทำตามมาตรฐาน (3)
                                        @elseif ( $value->SafetyHealth == 2 )
                                            เกิดอุบัติเหตุ 1 ครั้ง, ไม่ทำตามมาตรฐาน (2)
                                        @elseif ( $value->SafetyHealth == 1 )
                                            เกิดอุบัติเหตุมากกว่า 1 ครั้ง, ไม่ทำตามมาตรฐาน (1)
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $SafetyHealthAll }}%</td>
                                    <td class="text-center">
                                        {{ number_format($SafetyHealth,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>ผลการดำเนินงานทางด้านคุณภาพ</b></td>
                                    <td>จำนวนงานที่เกิด Rework, Claim, Complain เป็น 0</td>
                                    <td>
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
                                    </td>
                                    <td class="text-center">{{ $QualityAll }}%</td>
                                    <td class="text-center">
                                        {{ number_format($Quality,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>ผลการดำเนินงานทางด้านระยะเวลาการส่งมอบ</b></td>
                                    <td>ส่งมอบตามระยะเวลาหรือเร็วกว่าที่ตกลงกับลูกค้า</td>
                                    <td class="text-center">
                                        {{ $value->Duration }}
                                    </td>
                                    <td class="text-center">{{ $DurationAll }}%</td>
                                    <td class="text-center">
                                        {{ number_format($Duration,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>ผลการดำเนินงานทางด้านการจัดการต้นทุนงาน</b></td>
                                    <td style="background-color:gray;"></td>
                                    <td style="background-color:gray;"></td>
                                    <td class="text-center" >
                                        {{ $CostAll }}%
                                    </td>
                                    <td class="text-center" style="background-color:gray;">
                                        {{ number_format($CostTotal,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>การควบคุม Man-Hour ในแต่ละงาน</td>
                                    <td>% จำนวนงานที่มี Man-Hour สูงกว่าประมาณการเป็น 0</td>
                                    <td class="text-center">
                                       {{ $value->ManHour }}
                                    </td>
                                    <td class="text-center" style="background-color:gray;">{{ $ManHoursAll }}%</td>
                                    <td class="text-center">
                                        {{ number_format($ManHour,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>การควบคุม Man-Hour ให้คุ้มค่า (Waiting/Idle)</td>
                                    <td>% จำนวน Man-Hour ใน Admin/Support ต่อ งานอื่นๆเป็น 0</td>
                                    <td class="text-center">
                                        {{ $value->WastingTime }}
                                    </td>
                                    <td class="text-center" style="background-color:gray;">{{ $WastingTimeAll }}%</td>
                                    <td class="text-center">
                                        {{ number_format($WastingTime,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>สัดส่วน Support ต่อ Direct (Support)</td>
                                    <td>น้อยกว่า 30%</td>
                                    <td class="text-center">
                                        {{ $value->ManHourRatio }}
                                    </td>
                                    <td class="text-center" style="background-color:gray;">{{ $ManHourRatioAll }}%</td>
                                    <td class="text-center">
                                        {{ number_format($ManHourRatio,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>การดำเนินงานตามมาตรฐานคุณภาพ อาชีวะอนามัยและความปลอดภัย</b></td>
                                    <td>จำนวนงานที่ปฏิบัติตามมาตรฐานครบถ้วน</td>
                                    <td style="background-color:gray;"></td>
                                    <td class="text-center">{{ $StandardAll }}%</td>
                                    <td class="text-center" style="background-color:gray;">
                                        {{ number_format($StandardTotal,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>การดำเนินงานตาม Mile Stone</td>
                                    <td>
                                        สามารถดำเนินการตาม Milestone ได้อย่างครบถ้วน สมบูรณ์
                                    </td>
                                    <td class="text-center">
                                        {{ $value->MileStone }}
                                    </td>
                                    <td class="text-center" style="background-color:gray;">{{ $MileStoneAll }}%</td>
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
                                        {{ $value->ISO }}
                                    </td>
                                    <td class="text-center" style="background-color:gray;">{{ $ISOAll }}%</td>
                                    <td class="text-center">
                                        {{ number_format($ISO,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>รวม</b></td>
                                    <td class="text-center">{{ $TotalAll }}%</td>
                                    <td class="text-center">
                                        {{ number_format($Total,2) }}
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
                        @endforeach
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

        <x-input.text title="การปฏิบัติตาม Mile Stone" name-id="MileStone"/>

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
                <x-data-table.edit-value-script name="MileStone"/>
                <x-data-table.edit-value-script name="ISO"/>
                <x-data-table.edit-value-script name="KPI"/>
            </x-data-table.edit-script>

            <x-data-table.delete-script delete-name="" url="performance_projects"/>
        });
    </script>
@endsection
