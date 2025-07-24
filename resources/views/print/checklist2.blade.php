@extends('layouts.printl')

@section('title','Check List')

@section('content')
    @foreach ($header as $value)
        <table class="table table-borderless table-sm">
            <tr>
                <td rowspan="3" class="text-center align-middle border-top border-left" style="width:10%"> <img src="/img/EGAT.png" height="70"> </td>
                <td rowspan="3" class="text-center align-middle border-right border-top" style="width:24%"><h4>Mechanical Maintenance Division</h4></td>
                <td rowspan="2" class="text-center align-middle border-right border-top" style="width:33%"><h4>Quality Check List</h4></td>
                <td colspan="2" class="border-top" style="width:24%">Date _________________ to _________________</td>
                <td class="text-right border-top border-right">P. _____ / _____</td>
            </tr>
            <tr>
                <td colspan="3" class="border-right"> PM Order : <u>{{ $value->PMOrder }}</u></td>
            </tr>
            <tr>
                <td class="border-top border-left">Plant Name : <u>{{ $value->LocationName }}</u></td>
                <td colspan="3" class="border-left border-right">Plant-Unit : <u>{{ $value->MachineName }} / {{ $value->Remark }}</u></td>
            </tr>
            <tr>
                <td colspan="2" class="border-left"> Department Name : <u>Hydro and Renewable Power Plant Department</u></td>
                <td class="border-left">Equipment Name : <u>{{ $value->SpecificName }}</u></td>
                <td class="border-left" style="width:11%">Manitenance Type :</td>
                <td>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">MO</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                        <label class="form-check-label" for="inlineCheckbox2">MI</label>
                    </div>
                </td>
                <td class="border-right"></td>
            </tr>
            <tr>
                <td colspan="2" class="border-left border-bottom"> Section : <u>Hydro and Renewable Power Plant Maintenance Section</u></td>
                <td class="border-left border-bottom">Task : -</td>
                <td class="text-right border-left border-bottom">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">CI</label>
                    </div>
                </td>
                <td colspan="2" class="border-right border-bottom">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                        <label class="form-check-label" for="inlineCheckbox1">WI</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                        <label class="form-check-label" for="inlineCheckbox2">Other _______________________</label>
                    </div>
                </td>
            </tr>
        </table>
    @endforeach

    @if ( count($procedure) > 0 )
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Activity</th>
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
                    @php
                        $procedurex = '';
                    @endphp
                    @foreach($procedure as $value)
                        <tr>
                            @if ( $value->ActivityName <> $procedurex )
                                <td rowspan="{{$value->CountOfActivityName}}" class="text-center"> {{$value->ActivityName }} </td>
                                @php
                                    $procedurex = $value->ActivityName;
                                @endphp
                            @endif
                            <td>{{ $value->Procedure }}</td>
                            <td>{{ nl2br($value->ControlledPoint) }}</td>
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
        <table class="table table-borderless table-sm">
            <tr>
                <td class="border-top border-left border-bottom" style="width:8%">Checked By :</td>
                <td class="text-center border-top border-bottom" style="width:25%">
                    <br>
                    ....................................................<br>
                    (.....................................................)<br>
                    Date __________ / __________ / __________
                </td>
                <td class="border-top border-left border-bottom" style="width:8%">Approved By :</td>
                <td class="text-center border-top border-bottom" style="width:26%">
                    <br>
                    ....................................................<br>
                    (.....................................................)<br>
                    Date __________ / __________ / __________
                </td>
                <td class="border-top border-left border-bottom" style="width:8%">Witness By :</td>
                <td class="text-center border-top border-right border-bottom" style="width:25%">
                    <br>
                    ....................................................<br>
                    (.....................................................)<br>
                    Date __________ / __________ / __________
                </td>
            </tr>
        </table>
        <table class="table table-bordered table-sm">
            <tr>
                <td class="text-center" style="width:33%">ฝ่ายบำรุงรักษาเครื่องกล</td>
                <td class="text-center" style="width:34%">รหัสเอกสาร xxxxxxxxxxxx</td>
                <td class="text-center" style="width:33%">แก้ไขครั้งที่ xx</td>
            </tr>
        </table>
    @endif
@endsection
