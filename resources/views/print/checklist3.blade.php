@extends('layouts.printl')

@section('title','Check List')

@section('content')
    @foreach ($itemdetail as $value)
        <table class="table table-bordered table-sm">
            <tr>
                <td rowspan="2" class="text-center align-middle" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
                <td rowspan="2" class="text-center align-middle" style="width:23.4%"><h4>HRPD Check List</h4></td>
                <td style="width:33.3%"> Project : {{$value->ProjectName}} </td>
                <td style="width:33.3%"> Location : {{$value->LocationName}} </td>
            </tr>
            <tr>
                <td> Start Date : {{date('d-m-Y', strtotime($value->StartDate))}}</td>
                <td> Finish Date : {{date('d-m-Y', strtotime($value->FinishDate))}}</td>
            </tr>
            <tr>
                <td colspan="2"> Product : {{$value->ProductName}}</td>
                <td>Machine : 
                    @if ( $value->MachineDetail == "" )
                        {{$value->MachineName}}
                    @else
                        {{$value->MachineName}}//{{$value->MachineDetail}}
                    @endif
                </td>
                <td>System : {{$value->SystemName}}</td>
            </tr>
            <tr>
                <td colspan="2"> Equipment : {{$value->EquipmentName}}</td>
                <td>Scope of Work : {{$value->ScopeName}}</td>
                <td>Remark : {{$value->Remark}}</td>
            </tr>
        </table>
    @endforeach

        Scope of Work
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">No</th>
                    <th class="text-center align-middle">Activity</th>
                    <th class="text-center align-middle">Detail</th>
                    <th class="text-center align-middle" style="width:7%">Checked</th>
                    <th class="text-center align-middle" style="width:10%">Date/Time</th>
                    <th class="text-center align-middle" style="width:20%">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activity as $value)
                    <tr>
                        <td class="text-center align-middle">{{$value->Order}}</td>
                        <td>{{$value->ActivityName}}</td>
                        <td>{{$value->Detail}}</td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ( count($hazard) > 0 )
        Hazard
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">แหล่งกำเนิดอันตราย</th>
                        <th class="text-center align-middle">ลักษณะการเกิดอันตราย</th>
                        <th class="text-center align-middle">ผลกระทบ</th>
                        <th class="text-center align-middle">มาตรการควบคุมเบื้องต้น</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hazardx = '';
                    @endphp
                    @foreach($hazard as $value)
                        <tr>
                            @if ( $value->HazardName <> $hazardx )
                                <td rowspan="{{$value->CountOfHazardName}}"> {{$value->HazardName }} </td>
                                @php
                                    $hazardx = $value->HazardName;
                                @endphp
                            @endif
                            <td>{{ $value->KindofHazard }}</td>
                            <td>{{ $value->Effect }}</td>
                            <td>{!! nl2br($value->HazardControl) !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    @if ( count($qualitycontrol) > 0 )
        Quality Control
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Controlled Operation</th>
                        <th class="text-center align-middle">Controlled Quality</th>
                        <th class="text-center align-middle">Acceptance Criteria</th>
                        <th class="text-center align-middle">Recorded Document</th>
                        <th class="text-center align-middle" style="width:20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($qualitycontrol as $value)
                        <tr>
                            <td>{{ $value->ControlledOperation }}</td>
                            <td>{{ $value->ControlledQuality }}</td>
                            <td class="text-center">{{ $value->AcceptanceCriteria }}</td>
                            <td>{{ $value->RecordedDocument }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    @if ( count($document) > 0 )
        Document
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Document Name</th>
                        <th class="text-center align-middle">Document Code</th>
                        <th class="text-center align-middle" style="width:7%">Checked</th>
                        <th class="text-center align-middle" style="width:10%">Date/Time</th>
                        <th class="text-center align-middle" style="width:20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($document as $value)
                        <tr>
                            <td>{{ $value->DocumentName }}</td>
                            <td class="text-center">{{ $value->DocumentCode }}</td>
                            <td class="text-center"><input type="checkbox"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    @if ( count($sparepart) > 0 )
        Spare Part
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Spare Part Name</th>
                        <th class="text-center align-middle">Detail</th>
                        <th class="text-center align-middle">Quantity</th>
                        <th class="text-center align-middle">Unit</th>
                        <th class="text-center align-middle" style="width:7%">Checked</th>
                        <th class="text-center align-middle" style="width:10%">Date/Time</th>
                        <th class="text-center align-middle" style="width:20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sparepart as $value)
                        <tr>
                            <td>{{ $value->SparePartName }}</td>
                            <td>{{ $value->Detail }}</td>
                            <td class="text-center">{{ $value->Quantity }}</td>
                            <td class="text-center">{{ $value->Unit }}</td>
                            <td class="text-center"><input type="checkbox"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ( count($consumable) > 0 )
        Consumable
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Consumable Name</th>
                        <th class="text-center align-middle">Detail</th>
                        <th class="text-center align-middle">Quantity</th>
                        <th class="text-center align-middle">Unit</th>
                        <th class="text-center align-middle" style="width:7%">Checked</th>
                        <th class="text-center align-middle" style="width:10%">Date/Time</th>
                        <th class="text-center align-middle" style="width:20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consumable as $value)
                        <tr>
                            <td>{{ $value->ConsumableName }}</td>
                            <td>{{ $value->Detail }}</td>
                            <td class="text-center">{{ $value->Quantity }}</td>
                            <td class="text-center">{{ $value->Unit }}</td>
                            <td class="text-center"><input type="checkbox"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ( count($toolcatagory) > 0 )
        Tool
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Tool Name</th>
                        <th class="text-center align-middle">Quantity</th>
                        <th class="text-center align-middle">Unit</th>
                        <th class="text-center align-middle" style="width:7%">Checked</th>
                        <th class="text-center align-middle" style="width:10%">Date/Time</th>
                        <th class="text-center align-middle" style="width:20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($toolcatagory as $value)
                        <tr>
                            <td>{{ $value->CatagoryName }}</td>
                            <td class="text-center">{{ $value->Quantity }}</td>
                            <td class="text-center">{{ $value->Unit }}</td>
                            <td class="text-center"><input type="checkbox"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ( count($specialtool) > 0 )
        Special Tool
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Special Tool Name</th>
                        <th class="text-center align-middle">Part Name</th>
                        <th class="text-center align-middle">Drawing/Reference</th>
                        <th class="text-center align-middle" style="width:7%">Checked</th>
                        <th class="text-center align-middle" style="width:10%">Date/Time</th>
                        <th class="text-center align-middle" style="width:20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($specialtool as $value)
                        <tr>
                            <td>{{ $value->SpecialToolName }}</td>
                            <td class="text-center">{{ $value->PartName }}</td>
                            <td class="text-center">{{ $value->DrawingNumber }}</td>
                            <td class="text-center"><input type="checkbox"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ( count($safetytag) > 0 )
        Safety Tag
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Tag Location</th>
                        <th class="text-center align-middle">Purpose</th>
                        <th class="text-center align-middle" style="width:7%">Taged</th>
                        <th class="text-center align-middle" style="width:10%">Date/Time</th>
                        <th class="text-center align-middle" style="width:7%">Untaged</th>
                        <th class="text-center align-middle" style="width:10%">Date/Time</th>
                        <th class="text-center align-middle" style="width:20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($safetytag as $value)
                        <tr>
                            <td>{{ $value->TagLocation }}</td>
                            <td class="text-center">{{ $value->Purpose }}</td>
                            <td class="text-center"><input type="checkbox"></td>
                            <td></td>
                            <td class="text-center"><input type="checkbox"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ( count($procedure) > 0 )
        Work Procedure
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">No.</th>
                        <th class="text-center align-middle">Procedure</th>
                        <th class="text-center align-middle">Controlled Point</th>
                        <th class="text-center align-middle">Class</th>
                        <th class="text-center align-middle">Man</th>
                        <th class="text-center align-middle">Hour</th>
                        <th class="text-center align-middle" style="width:7%">Checked</th>
                        <th class="text-center align-middle" style="width:10%">Date/Time</th>
                        <th class="text-center align-middle" style="width:20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($procedure as $value)
                        <tr>
                            <td class="text-center">{{ $value->Order2 }}</td>
                            <td>{{ $value->Procedure }}</td>
                            <td>{!! nl2br($value->ControlledPoint) !!}</td>
                            <td class="text-center">{{ $value->Class }}</td>
                            <td class="text-center">{{ $value->Man }}</td>
                            <td class="text-center">{{ $value->Hour }}</td>
                            <td class="text-center"><input type="checkbox"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-borderless table-sm">
            <tbody>
                <tr>
                    <td class="text-right">ผู้ควบคุมงาน</td>
                    <td class="text-center">................................................................</td>
                    <td class="text-center">(................................................................)</td>
                    <td class="text-right">วันที่</td>
                    <td class="text-center">................................................................</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td class="text-center" style="width:33%">กองโรงไฟฟ้าพลังน้ำและพลังงานหมุนเวียน</td>
                    <td class="text-center"></td>
                    <td class="text-center" style="width:33%">Rev.0</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
