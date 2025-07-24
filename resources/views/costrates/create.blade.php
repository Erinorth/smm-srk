@extends('layouts.app')

@section('title')
    Create Cost Rate
@endsection

@section('content')
    
    <div class="container-sm">
        <h3>Create Cost Rate</h3>
    </div>
    <div class="container-sm">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ URL('/costrates') }}">
                    @csrf
                    <div class="container-sm">
                        <div class="form-group row">
                            <label for="CostRateVersion">Cost Rate Version *</label>
                            <div class="col">
                                <label for="CostRateVersion">Cost Rate Version *</label>
                                <input type="date" class="form-control" name="CostRateVersion" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Supervisor">Supervisor *</label>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" name="SupervisorNormal" Placeholder="ปกติ" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SupervisorOT1" Placeholder="ล่วงเวลา 1 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SupervisorOT15" Placeholder="ล่วงเวลา 1.5 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SupervisorOT2" Placeholder="ล่วงเวลา 2 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SupervisorOT3" Placeholder="ล่วงเวลา 3 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SupervisorAllowance" Placeholder="เบี้ยเลี้ยง" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SupervisorRent" Placeholder="ที่พัก" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Foreman">Foreman *</label>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" name="ForemanNormal" Placeholder="ปกติ" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="ForemanOT1" Placeholder="ล่วงเวลา 1 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="ForemanOT15" Placeholder="ล่วงเวลา 1.5 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="ForemanOT2" Placeholder="ล่วงเวลา 2 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="ForemanOT3" Placeholder="ล่วงเวลา 3 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="ForemanAllowance" Placeholder="เบี้ยเลี้ยง" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="ForemanRent" Placeholder="ที่พัก" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Skilled">Skilled *</label>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" name="SkilledNormal" Placeholder="ปกติ" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SkilledOT1" Placeholder="ล่วงเวลา 1 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SkilledOT15" Placeholder="ล่วงเวลา 1.5 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SkilledOT2" Placeholder="ล่วงเวลา 2 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SkilledOT3" Placeholder="ล่วงเวลา 3 เท่า" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SkilledAllowance" Placeholder="เบี้ยเลี้ยง" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="SkilledRent" Placeholder="ที่พัก" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-4">
                                <label for="Overhead">Overhead</label>
                                <input type="text" class="form-control" id="Overhea" Placeholder="Overhead" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="VanRate">รถตู้วันละ</label>
                                <input type="text" class="form-control" id="VanRate" Placeholder="รถตู้วันละ" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="FuelRate">ค่าน้ำมันรถตู้วันละ/คัน</label>
                                <input type="text" class="form-control" id="FuelRate" Placeholder="ค่าน้ำมันรถตู้วันละ/คัน" required>
                            </div>
                          </div>
                        
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    
    
    
    
    

@endsection