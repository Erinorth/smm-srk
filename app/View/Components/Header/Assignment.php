<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class Assignment extends Component
{
    public $assignmentId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($assignmentId)
    {
        $this->assignmentId = $assignmentId;
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
                        @foreach ($assinmentdetail as $value)
                            <h6>Start Of Week : {{$value->StartDate}}</h6>
                            <h6>End Of Week : {{$value->EndDate}}</h6>
                        @endforeach
                    </div>
                    <br>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                        @foreach ($assinmentdetail as $value)
                            <h6>Assignee : {{$value->Assignee}}</h6>
                            <h6>Day : {{$value->Day}}</h6>
                            <h6>Point : {{$value->Point}}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function assinmentdetail()
    {
        $assinmentdetail = DB::select('SELECT w_f_h_w_f_a_assignments.id, week.StartDate, week.EndDate, employees.ThaiName AS Assignee, w_f_h_w_f_a_assignments.Day, w_f_h_w_f_a_assignments.Point
            FROM w_f_h_w_f_a_assignments
            INNER JOIN employees
            ON employees.id = w_f_h_w_f_a_assignments.Assignee
            INNER JOIN (SELECT date.Year, date.Week, start_date.StartDate, end_date.EndDate
                FROM date
                INNER JOIN ( SELECT Year, Week, MIN(Date) AS StartDate
                    FROM date
                    GROUP BY Year, Week ) AS start_date
                ON date.Year = start_date.Year AND date.Week = start_date.Week
                INNER JOIN ( SELECT Year, Week, MAX(Date) AS EndDate
                    FROM date
                    GROUP BY Year, Week ) AS end_date
                ON date.Year = end_date.Year AND date.Week = end_date.Week
                GROUP BY date.Year, date.Week, start_date.StartDate, end_date.EndDate) AS week
            ON w_f_h_w_f_a_assignments.Date = week.StartDate
            WHERE (((w_f_h_w_f_a_assignments.id)='.$this->assignmentId.'))');

        return $assinmentdetail;
    }
}
