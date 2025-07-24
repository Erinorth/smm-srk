<?php

namespace App\View\Components\Chart;

use Illuminate\View\Component;

class ManHour extends Component
{
    public $collapseCard;
    public $title;
    public $collapseButton;
    public $chartId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($collapseCard, $title, $collapseButton, $chartId)
    {
        $this->collapseCard = $collapseCard;
        $this->title = $title;
        $this->collapseButton = $collapseButton;
        $this->chartId = $chartId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div class="card {{$collapseCard}}">
    <div class="card-header">
        <h3 class="card-title">{{$title}}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-{{$collapseButton}}"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <canvas id="{{$chartId}}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
    </div>
</div>
blade;
    }
}
