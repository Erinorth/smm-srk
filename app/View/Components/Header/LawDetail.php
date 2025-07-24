<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class LawDetail extends Component
{
    public $lawDetailId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($lawDetailId)
    {
        $this->lawDetailId = $lawDetailId;
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
                    @foreach ($lawdetail as $value)
                        <div class="row row-cols-1">
                            <h6>{{$value->LawName}}</h6>
                        </div>
                        <div class="row row-cols-2">
                            <h6>Announcement Date : {{$value->AnnouncementDate}}</h6>
                            <h6>Number of Pages : {{$value->NumberOfPages}}</h6>
                        </div>
                        <div class="row row-cols-1">
                            <h6>{!! nl2br($value->LawDetail) !!}</h6>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function lawdetail()
    {
        $lawdetail = DB::select('SELECT laws.LawName, laws.AnnouncementDate, laws.NumberOfPages, laws.Regulator, law_details.LawDetail, law_details.id
            FROM laws INNER JOIN law_details ON laws.id = law_details.law_id
            WHERE (((law_details.id)='.$this->lawDetailId.'))');
        
        return $lawdetail;
    }
}
