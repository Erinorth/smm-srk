<?php

namespace App\View\Components\Chart;

use Illuminate\View\Component;

class HalfCard extends Component
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
        return view('components.chart.half-card');
    }
}
