<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use App\Models\Law;

class Laws extends Component
{
    public $lawId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($lawId)
    {
        $this->lawId = $lawId;
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
                    <div class="row row-cols-1">
                        <h6>{{$law->LawName}}</h6>
                    </div>
                    <div class="row row-cols-2">
                        <h6>Announcement Date : {{$law->AnnouncementDate}}</h6>
                        <h6>Number of Pages : {{$law->NumberOfPages}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function law()
    {
        $law = Law::find($this->lawId);
        
        return $law;
    }
}
