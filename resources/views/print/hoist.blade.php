@extends('layouts.print')

@section('title','Hoist Testing Report')

@section('content')
    <table class="table table-borderless table-sm">
        <tr>
            <td rowspan="2" class="text-center align-middle border-top border-left border-bottom" style="width:10%"> <img src="/img/EGAT.png" height="60"> </td>
            <td rowspan="2" class="text-center align-middle border-top border-left border-bottom" style="width:50%">
                <h4>แบบตรวจสอบเครื่องมือและอุปกรณ์</h4>
                <h5>ตามประกาศกรมสวัสดิการและคุ้มครองแรงงาน</h5>
                <h6>เรื่อง หลักเกณฑ์และวิธีการ การใช้เชือก ลวดสลิง และรอก พ.ศ 2553</h6>
            </td>
            <td class="align-middle border-top border-left"><b>Job No. :</b>&nbsp;<u>{{ $report->id }}</u></td>
            <td class="align-middle border-top border-right"><b>Date of Inspection :</b>&nbsp;<u>{{ $report->TestDate }}</u></td>
        </tr>
        <tr>
            <td colspan="2" class="align-middle border-left border-bottom border-right"><b>Customer :</b>&nbsp;<u> @if($hoist) {{ $hoist->Customer }} @else กฟนม-ธ. @endif </u></td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        @if($hoist)
            <tr>
                <td rowspan="2" class="align-middle" style="width:10%"><b>Equipment Detail</b></td>
                <td style="width:22.5%"><b>Brand :</b>&nbsp;<u> @if ($hoist->Brand == "") N/A @else {{ $hoist->Brand }} @endif </u></td>
                <td style="width:22.5%"><b>Capacity :</b>&nbsp;<u> {{ $hoist->Capacity }}&nbsp;Ton(s)</u></td>
                <td style="width:22.5%"><b>Model :</b>&nbsp;<u> @if ($hoist->Model == "") N/A @else {{ $hoist->Model }} @endif </u></td>
                <td><b>Serial Number :</b>&nbsp;<u> @if ($hoist->SerialNumber == "") N/A @else {{ $hoist->SerialNumber }} @endif </u></td>
            </tr>
            <tr>
                <td><b>Local Code :</b>&nbsp;<u> @if ($hoist->LocalCode == "") N/A @else {{ $hoist->LocalCode }} @endif </u></td>
                <td><b>รหัสครุภัณฑ์ :</b>&nbsp;<u> @if ($hoist->DurableSupplieCode == "") N/A @else {{ $hoist->DurableSupplieCode }} @endif </u></td>
                <td><b>รหัสสินทรัพย์ :</b>&nbsp;<u> @if ($hoist->AssetToolCode == "") N/A @else {{ $hoist->AssetToolCode }} @endif </u></td>
                <td><b>Register Date :</b>&nbsp;<u> @if ($hoist->RegisterDate == "") N/A @else {{ $hoist->RegisterDate }} @endif </u></td>
            </tr>
        @else
            <tr>
                <td rowspan="2" class="align-middle" style="width:10%"><b>Equipment Detail</b></td>
                <td style="width:22.5%"><b>Brand :</b>&nbsp;<u> @if ($tool->Brand == "") N/A @else {{ $tool->Brand }} @endif </u></td>
                <td style="width:22.5%"><b>Capacity :</b>&nbsp;<u> {{ $toolcatagory->RangeCapacity }}&nbsp;Ton(s)</u></td>
                <td style="width:22.5%"><b>Model :</b>&nbsp;<u> @if ($tool->Model == "") N/A @else {{ $tool->Model }} @endif </u></td>
                <td><b>Serial Number :</b>&nbsp;<u> @if ($tool->SerialNumber == "") N/A @else {{ $tool->SerialNumber }} @endif </u></td>
            </tr>
            <tr>
                <td><b>Local Code :</b>&nbsp;<u> @if ($tool->LocalCode == "") N/A @else {{ $tool->LocalCode }} @endif </u></td>
                <td><b>รหัสครุภัณฑ์ :</b>&nbsp;<u> @if ($tool->DurableSupplieCode == "") N/A @else {{ $tool->DurableSupplieCode }} @endif </u></td>
                <td><b>รหัสสินทรัพย์ :</b>&nbsp;<u> @if ($tool->AssetToolCode == "") N/A @else {{ $tool->AssetToolCode }} @endif </u></td>
                <td><b>Register Date :</b>&nbsp;<u> @if ($tool->RegisterDate == "") N/A @else {{ $tool->RegisterDate }} @endif </u></td>
            </tr>
        @endif
    </table>

    <table class="table table-borderless table-sm">
        <tr>
            <td rowspan="3" class="border-top border-left" style="width:40%">
                <h5>1. Chain Hoist Inspection & Test</h5>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Item</th>
                            <th class="text-center">Test Item</th>
                            <th class="text-center">Acceptable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Top Hook Assembly</td>
                            <td class="text-center">{{ $report->TopHook }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Bottom Hook Assembly</td>
                            <td class="text-center">{{ $report->BottomHook }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Safety Latch</td>
                            <td class="text-center">{{ $report->SafetyLatch }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>Chain Condition</td>
                            <td class="text-center">{{ $report->Condition }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td>Chain Pin</td>
                            <td class="text-center">{{ $report->Pin }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td>Chain Hoist Test</td>
                            <td class="text-center">{{ $report->Testing }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <h6>Remark</h6>
                                <u>{!! nl2br($report->Remark) !!}</u>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h5>3.Hook Inspection</h5>
                <div class="text-center">
                    <img src="/img/hook.png" height="300">
                </div>
                Hook Inspection Opening Throat of Main Hoist
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th colspan="2" rowspan="2" class="text-center align-middle">Description</th>
                            <th colspan="2" class="text-center">Dimension (mm.)</th>
                        </tr>
                        <tr>
                            <th class="text-center">Actual</th>
                            <th class="text-center">Permissible Limit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan="2" class="text-center align-middle">Opening Throat</th>
                            <th class="text-center">Top</th>
                            <td class="text-center">{{ number_format($report->HookTop,2) }}</td>
                            <td class="text-center">
                                @php
                                    $HookTop = $report->HookTop*1.07;
                                @endphp
                                {{ number_format($HookTop,2) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">Bottom</th>
                            <td class="text-center">{{ number_format($report->HookBottom,2) }}</td>
                            <td class="text-center">
                                @php
                                    $HookBottom = $report->HookBottom*1.07;
                                @endphp
                                {{ number_format($HookBottom,2) }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"><u>Note</u>&nbsp;: Permissible Limit = A+(7%*A)</td>
                        </tr>
                    </tfoot>
                </table>
            </td>
            <td colspan="2" class="border-top border-right">
                <h5>2. Load Chain Inspection Point</h5>
                <h6>2.1. 10 Links Dimension for Load Chain (mm.)</h6>
                <div class="text-center">
                    <img src="/img/10 link.png" height="150">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <h6>2.2. Standard Dimension (P) mm</h6>
                <div class="text-center">
                    <img src="/img/p.png" height="150">
                </div>
            </td>
            <td class="border-right">
                <h6>2.3. Chain Dimension (D) mm</h6>
                <div class="text-center">
                    <img src="/img/d.png" height="150">
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border-right">
                Tabl : Load Chain Dimension Check
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Description</th>
                            <th class="text-center">P (mm.)</th>
                            <th class="text-center">D (mm.)</th>
                            <th class="text-center">10 Links Dimension (mm.)</th>
                            <th class="text-center">Acceptable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center">Chain Hoist</th>
                            <td class="text-center">{{ number_format($report->HookTop,2) }}</td>
                            <td class="text-center">{{ number_format($report->LoadP,2) }}</td>
                            <td class="text-center">{{ number_format($report->Load10Link,2) }}</td>
                            <td rowspan="2" class="text-center align-middle">{{ $report->LoadTesting }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Standard</th>
                            @if ($hoist)
                                <td class="text-center">@if ($hoist->StandardP == "") N/A @else {{ number_format($hoist->StandardP,2) }} @endif </td>
                                <td class="text-center">@if ($hoist->StandardD == "") N/A @else {{ number_format($hoist->StandardD,2) }} @endif </td>
                                <td class="text-center">@if ($hoist->Standard10Link == "") N/A @else {{ number_format($hoist->Standard10Link,2) }} @endif </td>
                            @else
                                <td class="text-center">N/A</td>
                                <td class="text-center">N/A</td>
                                <td class="text-center">N/A</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
                Measured detail : Measure five Consecutive links with venier calipers Especially where Excessive wear is not indicated (Permissible 10 links Criteria : 10 links Dimension X 0.015)
                <br><br>
                <h6>2.4. Load Chain Twist Check</h6>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">A bend or Twist for the Hook of Main Hoist</th>
                        </tr>
                        <tr>
                            <th class="text-center">Description</th>
                            <th class="text-center">Acceptable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A bend or Twist of the Hook</td>
                            <td class="text-center">{{ $report->Twist }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">** Not Exceeding 10 degree from the Plane</td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="border-left border-bottom border-right">
                <h5>Inspection Result :&nbsp;<u>{{ $report->Result }}</u> @isset($report->Note) &nbsp; with note <u>{{ $report->Note }}</u> @endisset</h5>
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-sm">
        <tr>
            <td class="text-center" style="width:50%">
                <h5>Checked By</h5>
                <br>
                ....................................................................................<br><br>
                (....................................................................................)<br><br>
                Date........................../........................../..........................
            </td>
            <td class="text-center">
                <h5>Approved By</h5>
                <br>
                ....................................................................................<br><br>
                (....................................................................................)<br><br>
                Date........................../........................../..........................
            </td>
        </tr>
    </table>
@endsection
