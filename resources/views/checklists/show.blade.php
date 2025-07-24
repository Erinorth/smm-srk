@extends('layouts.app')

@section('title','Check List')

@section('headscripts')
    <script src="http://www.position-absolute.com/creation/print/jquery.printPage.js"></script>
@endsection

@section('content')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($itemdetail as $value)
                <h5>Project : {{$value->ProjectName}}</h5>
                <h5>Location : {{$value->LocationName}}</h5>
                <h5>Product : {{$value->ProductName}}</h5>
                <h5>Machine : {{$value->MachineName}}</h5>
                <h5>System : {{$value->SystemName}}</h5>
                <h5>Equipment : {{$value->EquipmentName}}</h5>
                <h5>Scope of Work : {{$value->ScopeName}}</h5>
                <h5>Remark : {{$value->Remark}}</h5>
            @endforeach
        </div>
    </div>
    <br>
        Hazard
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Hazard</th>
                    <th class="text-center align-middle">Controller</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hazard as $value)
                    <tr>
                        <td>{{ $value->HazardName }}</td>
                        <td class="text-center">
                            @if ($value->id == 21)
                                <a class="btn btn-info btn-sm" href="{{ url('workathights/'.$job->id.'/'.$item->id.'/create') }}" >Work at Hight</a>
                            @elseif ($value->id == 25)
                                <a class="btn btn-info btn-sm" href="{{ url('confinedspaces/'.$job->id.'/'.$item->id.'/create') }}" >Confined Space</a>
                            @elseif ($value->id == 26)
                                <a class="btn btn-info btn-sm" href="{{ url('hotworks/'.$job->id.'/'.$item->id.'/create') }}" >Hot Work</a>
                            @elseif ($value->id == 35)
                                <a class="btn btn-info btn-sm" href="{{ url('liftings/'.$job->id.'/'.$item->id.'/create') }}" >Lifting</a>
                            @elseif ($value->id == 37)
                                <a class="btn btn-info btn-sm" href="{{ url('hotworks/'.$job->id.'/'.$item->id.'/create') }}" >Hot Work</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        Quality Control
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Controlled Operation</th>
                    <th class="text-center align-middle">Controlled Quality</th>
                    <th class="text-center align-middle">Acceptance Criteria</th>
                    <th class="text-center align-middle">Recorded Document</th>
                </tr>
            </thead>
            <tbody>
                @foreach($qualitycontrol as $value)
                    <tr>
                        <td>{{ $value->ControlledOperation }}</td>
                        <td>{{ $value->ControlledQuality }}</td>
                        <td class="text-center">{{ $value->AcceptanceCriteria }}</td>
                        <td>{{ $value->RecordedDocument }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        Document
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Document Name</th>
                    <th class="text-center align-middle">Document Code</th>
                    <th class="text-center align-middle">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($document as $value)
                    <tr>
                        <td>{{ $value->DocumentName }}</td>
                        <td class="text-center">{{ $value->DocumentCode }}</td>
                        <td>{{ $value->Remark }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        Spare Part
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Spare Part Name</th>
                    <th class="text-center align-middle">Detail</th>
                    <th class="text-center align-middle">Quantity</th>
                    <th class="text-center align-middle">Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sparepart as $value)
                    <tr>
                        <td>{{ $value->SparePartName }}</td>
                        <td>{{ $value->Detail }}</td>
                        <td class="text-center">{{ $value->Quantity }}</td>
                        <td class="text-center">{{ $value->Unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        Consumable
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Consumeable Name</th>
                    <th class="text-center align-middle">Detail</th>
                    <th class="text-center align-middle">Quantity</th>
                    <th class="text-center align-middle">Unit</th>
                    <th class="text-center align-middle">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consumable as $value)
                    <tr>
                        <td>{{ $value->ConsumableName }}</td>
                        <td>{{ $value->Detail }}</td>
                        <td class="text-center">{{ $value->Quantity }}</td>
                        <td class="text-center">{{ $value->Unit }}</td>
                        <td>{{ $value->Remark }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        Tool
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Tool Name</th>
                    <th class="text-center align-middle">Quantity</th>
                    <th class="text-center align-middle">Unit</th>
                    <th class="text-center align-middle">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($toolcatagory as $value)
                    <tr>
                        <td>{{ $value->CatagoryName }}</td>
                        <td class="text-center">{{ $value->Quantity }}</td>
                        <td class="text-center">{{ $value->Unit }}</td>
                        <td>{{ $value->Remark }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        Special Tool
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Special Tool Name</th>
                    <th class="text-center align-middle">Part Name</th>
                    <th class="text-center align-middle">Drawing/Reference</th>
                    <th class="text-center align-middle">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($specialtool as $value)
                    <tr>
                        <td>{{ $value->SpecialToolName }}</td>
                        <td class="text-center">{{ $value->PartName }}</td>
                        <td class="text-center">{{ $value->DrawingNumber }}</td>
                        <td>{{ $value->Remark }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        Safety Tag
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Tag Location</th>
                    <th class="text-center align-middle">Purpose</th>
                    <th class="text-center align-middle">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($safetytag as $value)
                    <tr>
                        <td>{{ $value->TagLocation }}</td>
                        <td class="text-center">{{ $value->Purpose }}</td>
                        <td>{{ $value->Remark }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        Work Procedure
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">No.</th>
                    <th class="text-center align-middle">Procedure</th>
                </tr>
            </thead>
            <tbody>
                @foreach($procedure as $value)
                    <tr>
                        <td class="text-center">{{ $value->Order }}</td>
                        <td>{{ $value->Procedure }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <div class="form-group">
        <a class="btnprn btn btn-info btn-block btn-sm" href="{{ url('checklist/'.$job->id.'/'.$item->id) }}" >Print Check List</a>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.btnprn').printPage();
        });
    </script>
@endsection
