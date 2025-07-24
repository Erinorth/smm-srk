@extends('adminlte::page')

@section('title','KPI')

@section('content_header')
    <h1 class="m-0 text-dark">KPI</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">KPI</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Work ID</th>
                                <th>Name</th>
                                <th>KPI</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($kpi as $value)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td class="text-center">
                                        @if ( Auth::user() == $value->WorkID )
                                            {{ $value->WorkID }}
                                        @else
                                            @role('admin|head_operation|head_engineering')
                                                {{ $value->WorkID }}
                                            @else
                                                N/A
                                            @endrole
                                        @endif
                                    </td>
                                    <td>
                                        @if ( Auth::user() == $value->WorkID )
                                            {{ $value->ThaiName }}
                                        @else
                                            @role('admin|head_operation|head_engineering')
                                                {{ $value->ThaiName }}
                                            @else
                                                <div class="text-center">N/A</div>
                                            @endrole
                                        @endif
                                    </td>
                                    <td class="text-center">{{ Number_format($value->KPI,2) }}</td>
                                    <td class="text-center">
                                        @if ( Auth::user() == $value->WorkID )
                                            <a href="{{ url ('KPIs/'.$value->id.'/'.$semiannual->id) }}" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                        @else
                                            @role('admin|head_operation|head_engineering')
                                                <a href="{{ url ('KPIs/'.$value->id.'/'.$semiannual->id) }}" class="btn btn-xs btn-default text-info mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>
                                            @else
                                                N/A
                                            @endrole
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')  
    <script>
        $(document).ready(function(){
            $('#data_table').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            });
        });
    </script>
@endsection