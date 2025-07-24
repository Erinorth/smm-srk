@extends('layouts.app')

@section('title')
    Action Plan
@endsection

@section('content')
    @include('layouts.errors')
    @include('layouts.success')
    <div class="container-sm">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
            @foreach ($meetingdetail as $value)
                <h5>Project : {{ $value->ProjectName }}</h5>
                <h5>วันที่ : {{ $value->MeetingDate }}</h5>
                <h5>เรื่องประชุม : {{ $value->Subject }}</h5>
                <h5>ประเด็นสำคัญ : {{ $value->MainPoint }}</h5>
            @endforeach
        </div>
    </div>
    <br>
    <form class="form-horizontal" method="POST" action="{{ URL('actionplans/'.$actionplan->id) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="col">
                <label for="Activity">กิจกรรม</label>
                <input type="text" class="form-control" name="Activity" value="{{$actionplan->Activity}}" required>
            </div>
            <div class="col">
                <label for="Responsible">ผู้รับผิดชอบ</label>
                <input type="text" class="form-control" name="Responsible" value="{{$actionplan->Responsible}}" required>
            </div>
            <div class="col">
                <label for="DeadLine">กำหนดแล้วเสร็จ</label>
                <input type="date" class="form-control" name="DeadLine" value="{{$actionplan->DeadLine}}" required>
            </div>
            <div class="col">
                <label for="Status">สถานะ</label>
                <select class="form-control" name="Status">
                    <option>{{$actionplan->Status}}</option>
                    <option>Not Start</option>
                    <option>In Progress</option>
                    <option>Complete</option>
                </select>
            </div>
            <input type="text" name="meeting_id" value="{{$actionplan->meeting_id}}" hidden>
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-warning btn-block btn-sm">Update</button>
        </div>
    </form>
@endsection
