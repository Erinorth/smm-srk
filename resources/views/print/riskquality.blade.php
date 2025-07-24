@extends('layouts.printl')

@section('title','Quality Assesment')

@section('content')
    <h3 class="text-center">แบบฟอร์มการประเมินความเสี่ยง</h3>
    หน่วยงาน หบน-ธ. กฟน-ธ. อบค. <br>
    งาน @foreach ($job as $value){{$value->ProjectName}} / {{$value->LocationName}} / {{$value->MachineName}} / {{$value->SystemName}} / {{$value->SpecificName}} / {{$value->ScopeName}} @endforeach
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">ลำดับ</th>
                    <th rowspan="2" class="text-center align-middle">งาน/กิจกรรม</th>
                    <th rowspan="2" class="text-center align-middle">Critical Path <br> Y/N</th>
                    <th rowspan="2" class="text-center align-middle">ผลกระทบต่อเป้าหมายในด้าน</th>
                    <th colspan="3" class="text-center align-middle">ความรุนแรง</th>
                    <th colspan="10" class="text-center align-middle">โอกาสที่เกิด</th>
                    <th rowspan="2" class="text-center align-middle" style="width:5%">ระดับความเสี่ยง</th>
                    <th rowspan="2" class="text-center align-middle" style="width:33%">มาตรการควบคุมความเสี่ยง</th>
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
                    <th class="text-center align-middle">9</th>
                    <th class="text-center align-middle" style="width:3%">ผล %</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($risk as $value)
                    <tr>
                        <td rowspan="2" class="text-center">{{$i}}</td>
                        <td rowspan="2">{{$value->ActivityName}} / {{$value->Detail}}</td>
                        <td rowspan="2"></td>
                        <td>Duration</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td></td>
                        <td rowspan="2"></td>
                    </tr>
                    <tr>
                        <td>Cost</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php
                        $i++;
                    @endphp
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
                    <td class="text-center" style="width:33%">กองโรงไฟฟ้าพลังน้ำและพลังงานหมุนเวียน</td>
                    <td class="text-center">HMS</td>
                    <td class="text-center" style="width:33%">Rev.0</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
