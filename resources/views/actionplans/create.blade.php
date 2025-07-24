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
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th class="text-center">กิจกรรม</th>
                    <th class="text-center">ผู้รับผิดชอบ</th>
                    <th class="text-center">กำหนดแล้วเสร็จ</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($actionplan as $value)
                    <tr>
                        <td class="text-center">{{$value->Activity}}</td>
                        <td class="text-center">{{$value->Responsible}}</td>
                        <td class="text-center">{{$value->DeadLine}}</td>
                        <td class="text-center">{{$value->Status}}</td>
                        <td class="text-center">
                            <form class="form-horizontal delete_form" method="POST" action="{{ URL('actionplans/'.$value->id) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning btn-sm" href="{{ URL('actionplans/'.$value->id.'/edit') }}">Edit</a>
                                <button type="submit" class="btn btn-danger delete_form btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <form class="form-horizontal" method="POST" action="{{ URL('actionplans') }}">
        @csrf
        <div class="form-row">
            <div class="col">
                <input type="text" class="form-control" name="Activity" placeholder="กิจกรรม" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="Responsible" placeholder="ผู้รับผิดชอบ" required>
            </div>
            <div class="col">
                <input type="date" class="form-control" name="DeadLine" placeholder="กำหนดแล้วเสร็จ" required>
            </div>
            <input type="text" name="Status" value="Not Start" hidden>
            <input type="text" name="meeting_id" value="{{$meeting->id}}" hidden>
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block btn-sm">Add</button>
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
