@extends('adminlte::page')

@section('title','KPI')

@section('content_header')
    <h1 class="m-0 text-dark">KPI</h1>
@stop

@section('content')
    <x-card.default-card color="" collapse-card="" title="Report" collapse-button="minus">
        <x-slot name="tool"></x-slot>
        <form class="form-horizontal" method="POST" action="{{ url('/KPIs_all') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >Department</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="Department" id="Department">
                                <option></option>
                                @foreach ($department as $value)
                                    <option value="{{ $value->id }}">{{ $value->DepartmentName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label" >Period</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="Period" id="Period">
                                <option></option>
                                @foreach ($period as $value)
                                    <option value="{{ $value->id }}">{{ $value->StartDate }} to {{ $value->EndDate }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Report</button>
                </div>
            </div>
        </form>
    </x-card.default-card>
@endsection
