@extends('layouts.printl')

@section('title','Law Assesment')

@section('content')
    <h3 class="text-center">แบบฟอร์มการประเมินความสอดคล้องต่อกฏหมาย</h3>
    หน่วยงาน {{$department->DepartmentName}} <br>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">รายละเอียด</th>
                    <th colspan="3" class="text-center align-middle">ความสอดคล้อง</th>
                    <th rowspan="2" class="text-center align-middle">หลักฐาน</th>
                </tr>
                <tr>
                    <th class="text-center align-middle">สอดคล้อง</th>
                    <th class="text-center align-middle">ไม่สอดคล้อง</th>
                    <th class="text-center align-middle">ไม่เกี่ยวข้อง</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lawassesment as $lawname => $law_list)
                    <tr>
                        <th colspan="5"><b>{{ $lawname }}</b></th>
                    </tr>
                    @foreach ($law_list as $value)
                        <tr>
                            <td>{!! nl2br($value->LawDetail) !!}</td>
                            <td class="text-center">
                                @if ( $value->Related == "Yes" AND $value->Evident !== null )
                                    /
                                @endif
                            </td>
                            <td class="text-center">
                                @if ( $value->Related == "Yes" AND $value->Evident == null )
                                    /
                                @endif
                            </td>
                            <td class="text-center">
                                @if ( $value->Related == "No" )
                                    /
                                @endif
                            </td>
                            <td>
                                {!! nl2br($value->Evident) !!}
                            </td>
                        </tr>
                    @endforeach
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
                    <td class="text-center" style="width:33%">{{$department->DepartmentName}}</td>
                    <td class="text-center"></td>
                    <td class="text-center" style="width:33%">Rev.0</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
