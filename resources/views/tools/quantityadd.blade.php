@extends('adminlte::page')

@section('title','Tool Quantity')

@section('content')
    @include('layouts.errors')
    <h5>Add Tool</h5>
    <form class="form-horizontal" method="POST" action="{{ URL('item_tools') }}">
        @csrf
        <div class="form-row">
            <div class="form-group col-md">
                <label for="tool_id">Tool Name // Unit</label>
                <select class="form-control" id="tool_id" name="tool_id" required>
                    <option value="">Tool Name // Unit</option>
                    @foreach ($tool as $value)
                        <option value="{{$value->id}}">{{$value->ToolName}} // {{$value->Unit}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md">
                <label for="Quantity">Quantity</label>
                <input type="text" class="form-control" name="Quantity">
            </div>
            <div class="form-group col-md">
                <label for="Remark">Remark</label>
                <input type="text" class="form-control" name="Remark">
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block btn-sm">Add</button>
        </div>
    </form>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Add Date</th>
                    <th class="text-center align-middle">Tool Name</th>
                    <th class="text-center align-middle">Quantity</th>
                    <th class="text-center align-middle">Unit</th>
                    <th class="text-center align-middle">Remark</th>
                    @role('admin')
                        <th class="text-center align-middle">Action</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach($toolquantity as $value)
                    <tr>
                        <td>{{ $value->created_at }}</td>
                        <td></td>
                        <td class="text-center">{{$value->InStore}}</td>
                        <td class="text-center"></td>
                        <td class="text-center">{{ $value->Remark}}</td>
                        <td class="text-center">
                            <form class="form-horizontal delete_form" method="POST" action="{{ URL('projects/'.$value->id) }}">
                                @csrf
                                @method('DELETE')
                                @role('admin')
                                    <a class="btn btn-warning btn-sm" href="{{ URL('projects/' .$value->id .'/edit') }}">Edit</a>
                                    <button type="submit" class="btn btn-danger delete_form btn-sm">Delete</button>
                                @endrole
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$toolquantity->links()}}
    </div>
@endsection
