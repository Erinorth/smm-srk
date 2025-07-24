<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class Month extends Component
{
    public $monthId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($monthId)
    {
        $this->monthId = $monthId;
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
                        @foreach ($monthdetail as $value)
                            <h6>Start Of Annual : {{$value->StartOfAnnual}}</h6>
                            <h6>End Of Annual : {{$value->EndOfAnnual}}</h6>
                        @endforeach
                    </div>
                    <br>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                        @foreach ($monthdetail as $value)
                            <h6>Start Of Semiannual : {{$value->StartOfSemiannual}}</h6>
                            <h6>End Of Semiannual : {{$value->EndOfSemiannual}}</h6>
                        @endforeach
                    </div>
                    <br>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                        @foreach ($monthdetail as $value)
                            <h6>Start Of Quarter : {{$value->StartOfQuarter}}</h6>
                            <h6>End Of Quarter : {{$value->EndOfQuarter}}</h6>
                        @endforeach
                    </div>
                    <br>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                        @foreach ($monthdetail as $value)
                            <h6>Start Of Month : {{$value->StartOfMonth}}</h6>
                            <h6>End Of Month : {{$value->EndOfMonth}}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function monthdetail()
    {
        $monthdetail = DB::select('SELECT annuals.StartOfAnnual, annuals.EndOfAnnual, semiannuals.StartOfSemiannual, semiannuals.EndOfSemiannual, quarters.StartOfQuarter, quarters.EndOfQuarter, months.StartOfMonth, months.EndOfMonth
            FROM ((annuals INNER JOIN semiannuals ON annuals.id = semiannuals.annual_id) INNER JOIN quarters ON semiannuals.id = quarters.semiannual_id) INNER JOIN months ON quarters.id = months.quarter_id
            WHERE (((months.id)='.$this->monthId.'))');
        
        return $monthdetail;
    }
}