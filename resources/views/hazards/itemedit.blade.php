@extends('layouts.app')

@section('title','Hazard')

@section('content')
    @include('layouts.errors')
    @include('layouts.success')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($itemhazarddetail as $value)
                <h5>Product : {{$value->ProductName}}</h5>
                <h5>Location : {{$value->LocationName}}</h5>
                <h5>Machine : {{$value->MachineName}}</h5>
                <h5>System : {{$value->SystemName}}</h5>
                <h5>Equipment : {{$value->EquipmentName}}</h5>
                <h5>Scope : {{$value->ScopeName}}</h5>
            @endforeach
        </div>
    </div>
    <br>

    <form class="form-horizontal" method="POST" action="{{ URL('item_hazards/'.$itemhazard->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="hazard_id"><h6>Hazard Name</h6></label>
            <select class="form-control" id="hazard_id" name="hazard_id" required>
                <option value="">Hazard Name</option>
                @foreach ($hazard as $item)
                    <option value="{{$item->id}}" @if($itemhazard->hazard_id == $item->id) {{ 'selected' }} @endif>{{$item->HazardName}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-block">Update</button>
        </div>
    </form>
@endsection
