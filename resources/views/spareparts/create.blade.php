@extends('adminlte::page')

@section('title','Spare Part')

@section('content')
    @include('layouts.errors')
    <h5>Create Spare Part</h5>
    <form class="form-horizontal" method="POST" action="{{ URL('/spareparts') }}">
        @csrf
        <div class="form-row">
            <div class="form-group col-md">
                <label for="SparePartName">Spare Part Name</label>
                <input type="text" class="form-control" name="SparePartName">
            </div>
            <div class="form-group col-md">
                <label for="Detail">Detail</label>
                <input type="text" class="form-control" name="Detail">
            </div>
            <div class="form-group col-md">
                <label for="Unit">Unit</label>
                <input type="text" class="form-control" name="Unit">
            </div>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">Add</button>
        </div>
    </form>
@endsection