<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use App\Models\ToolCatagory;

class ToolCatagoryHeader extends Component
{
    public $toolCatagoryId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($toolCatagoryId)
    {
        $this->toolCatagoryId = $toolCatagoryId;
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
                        <h6>Catagory Name : {{$toolcatagory->CatagoryName}}</h6>
                        <h6>Unit : {{$toolcatagory->Unit}}</h6>
                        <h6>Measuring Tool : {{$toolcatagory->MeasuringTool}}</h6>
                        <h6>Min : {{$toolcatagory->Min}}</h6>
                        <h6>Max : {{$toolcatagory->Max}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
blade;
    }

    public function toolcatagory()
    {
        $toolcatagory = ToolCatagory::find($this->toolCatagoryId);
        
        return $toolcatagory;
    }
}