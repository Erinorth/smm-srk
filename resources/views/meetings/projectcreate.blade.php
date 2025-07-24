@extends('layouts.app')

@section('title')
    Meeting
@endsection

@section('content')
    @include('layouts.errors')
    @include('layouts.success')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($projectdetail as $value)
                <h5>Project : {{ $value->ProjectName }}</h5>
                <h5>Location : {{ $value->LocationName }}</h5>
                <h5>Start Date : {{ $value->StartDate }}</h5>
                <h5>Finish Date : {{ $value->FinishDate }}</h5>
                <h5>Planner : {{ $value->PlannerName }}</h5>
                <h5>Site Engineer : {{ $value->SiteEngineerName }}</h5>
                <h5>Area Manager : {{ $value->AreaManagerName }}</h5>
                <h5>Status : {{ $value->Status }}</h5>
            @endforeach
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th class="text-center">วันที่ประชุม</th>
                    <th class="text-center">หัวข้อการประชุม</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($meeting as $value)
                    <tr>
                        <td class="text-center">{{$value->MeetingDate}}</td>
                        <td class="text-center">{{$value->Subject}}</td>
                        <td class="text-center">
                            <form class="form-horizontal delete_form" method="POST" action="{{ URL('project_meetings/'.$value->id) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning btn-sm" href="{{ URL('meetingdates/'.$value->id.'/edit') }}">Edit</a>
                                <a class="btn btn-info btn-sm" href="{{ url('meetings/'.$value->id.'/create')}}">Meeting Detail</a>
                                <button type="submit" class="btn btn-danger delete_form btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <form class="form-horizontal" method="POST" action="{{ URL('project_meetings') }}">
        @csrf
        <div class="form-row">
            <div class="col">
                <input type="date" class="form-control" name="MeetingDate" placeholder="วันที่ประชุม" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="Subject" placeholder="หัวข้อการประชุม" required>
            </div>
            <input type="text" name="project_id" value="{{$project->id}}" hidden>
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block btn-sm">Add</button>
        </div>
    </form>
@endsection
