@extends('adminlte::page')

@section('title','Measuring Tool')

@section('content')
    @include('layouts.errors')
    @include('layouts.success')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($datemeasuringtooldetail as $value)
                <h5>Project : {{$value->ProjectName}}</h5>
                <h5>Location : {{$value->LocationName}}</h5>
                <h5>Product : {{$value->ProductName}}</h5>
                <h5>Machine : {{$value->MachineName}}</h5>
                <h5>System : {{$value->SystemName}}</h5>
                <h5>Equipment : {{$value->EquipmentName}}</h5>
                <h5>Date : {{$value->Date}}</h5>
            @endforeach
        </div>
    </div>
    <br>
    
    <form class="form-horizontal" method="POST" action="{{ URL('date_measuringtools/'.$datemeasuringtool->id) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group col-md">
                <label for="tool_id">Tool Name/Serial Number *</label>
                <select class="form-control" name="tool_id">
                    <option value="">Tool Name/Serial Number</option>
                        @foreach ($measuringtool as $item)
                            <option value="{{$item->id}}" @if($datemeasuringtool->tool_id == $item->id) {{ 'selected' }} @endif>{{$item->ToolName}} / {{$item->SerialNumber}}</option>
                        @endforeach
                </select>
            </div>
            <div class="form-group col-md">
                <h6 class="text-center">OR</h6>
            </div>
            <div class="form-group col-md">
                <label for="OtherToolName">Other Tool Name *</label>
                <input type="text" class="form-control" name="OtherToolName" value="{{$datemeasuringtool->OtherToolName}}">
            </div>
            <div class="form-group col-md">
                <label for="OtherSerialNumber">Other Serial Number *</label>
                <input type="text" class="form-control" name="OtherSerialNumber" value="{{$datemeasuringtool->OtherSerialNumber}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="MeasuredObject">Measured Object *</label>
                <input type="text" class="form-control" name="MeasuredObject" value="{{$datemeasuringtool->MeasuredObject}}" required>
            </div>
            <div class="form-group col-md">
                <label for="User">User *</label>
                <input type="text" class="form-control" name="User" value="{{$datemeasuringtool->User}}" required>
            </div>
            <div class="form-group col-md">
                <label for="Remark">Remark</label>
                <input type="text" class="form-control" name="Remark" value="{{$datemeasuringtool->Remark}}">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">Update</button>
        </div>
    </form>
@endsection