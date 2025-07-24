@extends('layouts.app')

@section('title','Expensive Tool')

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
                    <th class="text-center">Tool Name</th>
                    <th class="text-center">Type of use</th>
                    <th class="text-center">Hour of use</th>
                    @role('supervisor|foreman|admin')
                        <th class="text-center">Actions</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @foreach($dateexpensivetool as $value)
                    <tr>
                        <td class="text-center">{{ $value->ToolName }}</td>
                        <td class="text-center">{{ $value->TypeOfUse }}</td>
                        <td class="text-center">{{ $value->HourOfUse }}</td>
                        <td class="text-center">
                            <form class="form-horizontal delete_form" method="POST" action="{{ URL('date_expensivetools/'.$value->id) }}">
                                @csrf
                                @method('DELETE')
                                @role('supervisor|foreman|admin')
                                    <a class="btn btn-warning" href="{{url('date_expensivetools/'.$value->id.'/edit')}}">Edit</a>
                                    <button type="submit" class="btn btn-danger delete_form">Delete</button>
                                @endrole
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form class="form-horizontal" method="POST" action="{{ URL('date_expensivetools/'.$jobdate->id) }}">
        @csrf
        <div class="form-row">
            <div class="form-group col-md">
                <label for="tool_id">Tool Name *</label>
                <select class="form-control location" name="tool_id" required>
                    <option value="">Tool Name</option>
                        @foreach ($expensivetool as $value)
                            <option value="{{$value->id}}">{{$value->ToolName}}</option>
                        @endforeach
                </select>
            </div>
            <div class="form-group col-md">
                <label for="TypeOfUse">Type of use</label>
                <select class="form-control" name="TypeOfUse" required>
                    <option></option>
                    <option>Travel</option>
                    <option>Operation</option>
                </select>
            </div>
            <div class="form-group col-md">
                <label for="HourOfUse">Hour of use</label>
                <input type="text" class="form-control" name="HourOfUse" required>
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
