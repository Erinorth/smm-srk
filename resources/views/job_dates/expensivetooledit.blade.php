@extends('layouts.app')

@section('title','Expensive Tool')

@section('content')
    @include('layouts.errors')
    @include('layouts.success')    
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($dateexpensivetooldetail as $value)
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
    <form class="form-horizontal" method="POST" action="{{ URL('date_expensivetools/'.$dateexpensivetool->id) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group col-md">
                <label for="tool_id">Tool Name *</label>
                <select class="form-control location" name="tool_id" required>
                    <option value="">Tool Name</option>
                        @foreach ($expensivetool as $value)
                            <option value="{{$value->id}}" @if($dateexpensivetool->tool_id == $value->id) {{ 'selected' }} @endif>{{$value->ToolName}}</option>
                        @endforeach
                </select>
            </div>
            <div class="form-group col-md">
                <label for="TypeOfUse">Type of use</label>
                <select class="form-control" name="TypeOfUse" required>
                    <option>{{$dateexpensivetool->TypeOfUse}}</option>
                    <option>Travel</option>
                    <option>Operation</option>
                </select>
            </div>
            <div class="form-group col-md">
                <label for="HourOfUse">Hour of use</label>
                <input type="text" class="form-control" name="HourOfUse" value="{{$dateexpensivetool->HourOfUse}}" required>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">Update</button>
        </div>
    </form>
@endsection