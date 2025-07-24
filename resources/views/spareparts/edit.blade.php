@extends('adminlte::page')

@section('title','Spare Part')

@section('content')
    @include('layouts.errors')
    <h5>Edit Spare Part</h5>
    <form class="form-horizontal" method="POST" action="{{ URL('spareparts/'.$sparepart->id) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group col-md">
                <label for="SparePartName">Spare Part Name</label>
                <input type="text" class="form-control" name="SparePartName" value="{{$sparepart->SparePartName}}">
            </div>
            <div class="form-group col-md">
                <label for="Detail">Detail</label>
                <input type="text" class="form-control" name="Detail" value="{{$sparepart->Detail}}">
            </div>
            <div class="form-group col-md">
                <label for="Unit">Unit</label>
                <input type="text" class="form-control" name="Unit" value="{{$sparepart->Unit}}">
            </div>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">Update</button>
        </div>
    </form>
@endsection