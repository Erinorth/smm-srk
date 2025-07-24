@extends('layouts.app')

@section('title','Quality Control')

@section('content')
    @include('layouts.errors')
    @include('layouts.success')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($qualitycontroldetail as $value)
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
    <form class="form-horizontal" method="POST" action="{{ URL('qualitycontrols/'.$qualitycontrol->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="ControlledOperation">Controlled Operation</label>
                    <input type="text" class="form-control" name="ControlledOperation" placeholder="ControlledOperation" value="{{$qualitycontrol->ControlledOperation}}" required>
                </div>
                <div class="form-group col-md">
                    <label for="ControlledQuality">Controlled Quality</label>
                    <input type="text" class="form-control" name="ControlledQuality" placeholder="ControlledQuality" value="{{$qualitycontrol->ControlledQuality}}" required>
                </div>
                <div class="form-group col-md">
                    <label for="AcceptanceCriteria">Acceptance Criteria</label>
                    <input type="text" class="form-control" name="AcceptanceCriteria" placeholder="AcceptanceCriteria" value="{{$qualitycontrol->AcceptanceCriteria}}" required>
                </div>
                <div class="form-group col-md">
                    <label for="RecordedDocument">Recorded Document</label>
                    <input type="text" class="form-control" name="RecordedDocument" placeholder="RecordedDocument" value="{{$qualitycontrol->RecordedDocument}}" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-block">Update</button>
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
