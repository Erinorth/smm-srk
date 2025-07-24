@extends('layouts.app')

@section('title')
    Cost Rate
@endsection

@section('content')
    
    <div class="container-sm">
        <h3>Cost Rate</h3>
    </div>
    <div class="container-sm">
        <div class="card">
            <div class="card-body">
                <div class="container-sm">
                    Cost Rate Version : {{$costrate->DateVersion}}
                    <br>
                    Supervisor
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <th>ปกติ</th>
                                <th>ล่วงเวลา 1 เท่า</th>
                                <th>ล่วงเวลา 1.5 เท่า</th>
                                <th>ล่วงเวลา 2 เท่า</th>
                                <th>ล่วงเวลา 3 เท่า</th>
                                <th>เบี้ยเลี้ยง</th>
                                <th>ที่พัก</th>
                            </thead>
                            <tbody>
                                <td>{{$costrate->SupervisorNormal}}</td>
                                <td>{{$costrate->SupervisorOT1}}</td>
                                <td>{{$costrate->SupervisorOT15}}</td>
                                <td>{{$costrate->SupervisorOT2}}</td>
                                <td>{{$costrate->SupervisorOT3}}</td>
                                <td>{{$costrate->SupervisorAllowance}}</td>
                                <td>{{$costrate->SupervisorRent}}</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
    
    
    
    
    
    
    
    
    
    
    

@endsection