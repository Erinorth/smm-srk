@extends('adminlte::page')

@section('title','Mobilization Report')

@section('content_header')
    <h1 class="m-0 text-dark">Mobilization Report</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mobilization ({{ $startdate }} to {{ $enddate }})</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">ไม่ได้เบี้ยเลี้ยง</th>
                                <th class="text-center">เบี้ยเลี้ยงปกติ</th>
                                <th class="text-center">เบี้ยเลี้ยงเหมาจ่าย</th>
                                <th class="text-center">เบี้ยเลี้ยงต่างประเทศ</th>
                                <th class="text-center">Stand By</th>
                                <th class="text-center">รวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $value)
                                <tr>
                                    <td class="text-center">{{ $value->WorkID }}</td>
                                    <td>{{ $value->ThaiName }}</td>
                                    <td class="text-center">{{ $value->Not }}</td>
                                    <td class="text-center">{{ $value->Domestic }}</td>
                                    <td class="text-center">{{ $value->DomesticPlus }}</td>
                                    <td class="text-center">{{ $value->Foreign }}</td>
                                    <td class="text-center">{{ $value->StandBy }}</td>
                                    <td class="text-center">{{ $value->Sum }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop