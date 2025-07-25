<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class Project extends Component
{
    public $projectId;

    public function __construct($projectId)
    {
        $this->projectId = $projectId;
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
                        @foreach ($projectdetail as $value)
                            <h6>Project : {{ $value->ProjectName }}</h6>
                            <h6>Start Date : {{ $value->StartDate }}</h6>
                            <h6>Finish Date : {{ $value->FinishDate }}</h6>
                            <h6>รับผิดชอบ1/Planner/Site Engineer : {{ $value->SiteEngineerName }}</h6>
                            <h6>ผู้รับผิดชอบ2/Area Manager/ผู้ควบคุมงาน : {{ $value->AreaManagerName }}</h6>
                            <h6>Status : {{ $value->Status }}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function projectdetail()
    {
        $projectdetail = DB::select('SELECT projects.id, projects.ProjectName, projects.StartDate, projects.FinishDate, employees_1.ThaiName AS SiteEngineerName, employees_2.ThaiName AS AreaManagerName, projects.Status
            FROM employees AS employees_2
            RIGHT JOIN (employees AS employees_1
            RIGHT JOIN projects
            ON employees_1.id = projects.SiteEngineer)
            ON employees_2.id = projects.AreaManager
            WHERE (((projects.id)='.$this->projectId.'))');

        return $projectdetail;
    }
}
