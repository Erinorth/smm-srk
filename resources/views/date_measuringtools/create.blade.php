@extends('adminlte::page')

@section('title','Measuring Tool')

@section('content')
    @include('layouts.errors')
    @include('layouts.success')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($jobdatedetail as $value)
                <h5>Project : {{$value->ProjectName}}</h5>
                <h5>Location : {{$value->LocationName}}</h5>
                <h5>Product : {{$value->ProductName}}</h5>
                <h5>Machine : {{$value->MachineName}}</h5>
                <h5>System : {{$value->SystemName}}</h5>
                <h5>Equipment : {{$value->EquipmentName}}</h5>
            @endforeach
          </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ToolName</th>
                    <th class="text-center">Serial Number</th>
                    <th class="text-center">Measured Object</th>
                    <th class="text-center">User</th>
                    <th class="text-center">Remark</th>
                    @role('supervisor|foreman|admin')
                        <th class="text-center">Action</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach($datemeasuringtool1 as $value)
                    <tr>
                        <td class="text-center">{{ $value->ToolName }}</td>
                        <td class="text-center">{{ $value->SerialNumber }}</td>
                        <td class="text-center">{{ $value->MeasuredObject }}</td>
                        <td class="text-center">{{ $value->User }}</td>
                        <td class="text-center">{{ $value->Remark }}</td>
                        @role('supervisor|foreman|admin')
                            <td class="text-center">
                                <form class="form-horizontal delete_form" method="POST" action="{{ URL('date_measuringtools/'.$value->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-warning" href="{{url('date_measuringtools/'.$value->id.'/edit')}}">Edit</a>
                                    <button type="submit" class="btn btn-danger delete_form">Delete</button>
                                </form>
                            </td>
                        @endrole
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Other Tool Name</th>
                    <th class="text-center">Other Serial Number</th>
                    <th class="text-center">Measured Object</th>
                    <th class="text-center">User</th>
                    <th class="text-center">Remark</th>
                    @role('supervisor|foreman|admin')
                        <th class="text-center">Action</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach($datemeasuringtool2 as $value)
                    <tr>
                        <td class="text-center">{{ $value->OtherToolName }}</td>
                        <td class="text-center">{{ $value->OtherSerialNumber }}</td>
                        <td class="text-center">{{ $value->MeasuredObject }}</td>
                        <td class="text-center">{{ $value->User }}</td>
                        <td class="text-center">{{ $value->Remark }}</td>
                        @role('supervisor|foreman|admin')
                            <td class="text-center">
                                <form class="form-horizontal delete_form" method="POST" action="{{ URL('date_measuringtools/'.$value->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-warning" href="{{url('date_measuringtools/'.$value->id.'/edit')}}">Edit</a>
                                    <button type="submit" class="btn btn-danger delete_form">Delete</button>
                                </form>
                            </td>
                        @endrole
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form class="form-horizontal" method="POST" action="{{ URL('date_measuringtools/'.$jobdate->id) }}">
        @csrf
        <div class="form-row">
            <div class="form-group col-md">
                <label for="tool_id">Tool Name/Serial Number *</label>
                <select class="form-control" name="tool_id">
                    <option value="">Tool Name/Serial Number</option>
                        @foreach ($measuringtool as $value)
                            <option value="{{$value->id}}">{{$value->ToolName}} / {{$value->SerialNumber}}</option>
                        @endforeach
                </select>
            </div>
            <div class="form-group col-md">
                <h6 class="text-center">OR</h6>
            </div>
            <div class="form-group col-md">
                <label for="OtherToolName">Other Tool Name *</label>
                <input type="text" class="form-control" name="OtherToolName">
            </div>
            <div class="form-group col-md">
                <label for="OtherSerialNumber">Other Serial Number *</label>
                <input type="text" class="form-control" name="OtherSerialNumber">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="MeasuredObject">Measured Object *</label>
                <input type="text" class="form-control" name="MeasuredObject" required>
            </div>
            <div class="form-group col-md">
                <label for="User">User *</label>
                <input type="text" class="form-control" name="User" required>
            </div>
            <div class="form-group col-md">
                <label for="Remark">Remark</label>
                <input type="text" class="form-control" name="Remark">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">Add</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.delete_form').on('submit',function () {
                if (confirm("Do you want to delete?")) {
                    return true;
                }
                else {
                    return false;
                }
            });
        });
    </script>
@endsection