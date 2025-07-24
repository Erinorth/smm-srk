@extends('layouts.app')

@section('title')
    Meeting
@endsection

@section('content')
    @include('layouts.errors')
    @include('layouts.success')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($projectmeetingdetail as $value)
                <h5>Project : {{ $value->ProjectName }}</h5>
                <h5>วันที่ : {{ $value->MeetingDate }}</h5>
                <h5>เรื่องประชุม : {{ $value->Subject }}</h5>
            @endforeach
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th class="text-center">ประเด็นสำคัญ</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($meeting as $value)
                    <tr>
                        <td class="text-center">{{$value->MainPoint}}</td>
                        <td class="text-center">
                            <form class="form-horizontal delete_form" method="POST" action="{{ URL('meetings/'.$value->id) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning btn-sm" href="{{ URL('meetings/'.$value->id.'/edit') }}">Edit</a>
                                <a class="btn btn-info btn-sm" href="{{ url('actionplans/'.$value->id.'/create')}}">Action Plan</a>
                                <button type="submit" class="btn btn-danger delete_form btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <form class="form-horizontal" method="POST" action="{{ URL('meetings') }}">
        @csrf
        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" name="MainPoint" placeholder="ประเด็นสำคัญ" required>
            </div>
            <input type="text" name="project_meeting_id" value="{{$projectmeeting->id}}" hidden>
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block btn-sm">Add</button>
        </div>
    </form>
@endsection
