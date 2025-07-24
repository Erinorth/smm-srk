<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class EmployeeHeader extends Component
{
    public $employeeId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div class="row">
    <div class="col-12">
        <div class="card {{$collapseCard}}">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                    {{$tool}}
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-{{$collapseButton}}"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-sm">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                        @foreach ($employeedetail as $value)
                            <h6>หมายเลขประจำตัว : {{$value->WorkID}}</h6>
                            <h6>ชื่อ-สกุล : {{$value->ThaiName}}</h6>
                            <h6>ตำแหน่ง : {{$value->Position}}</h6>
                            <h6>หน่วยงาน : {{$value->DepartmentName}}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function employeedetail()
    {
        $employeedetail = DB::select('SELECT employees.WorkID, employees.ThaiName, employees.Position, departments.DepartmentName, employees.id
            FROM departments INNER JOIN employees ON departments.id = employees.department_id
            WHERE (((employees.id)='.$this->employeeId.'))');
        
        return $employeedetail;
    }
}
