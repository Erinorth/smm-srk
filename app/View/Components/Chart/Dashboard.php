<?php

namespace App\View\Components\Chart;

use Illuminate\View\Component;

class Dashboard extends Component
{
    public $titleName;
    public $themeName;
    public $iDName;

    public function __construct($titleName, $themeName, $iDName)
    {
        $this->titleName = $titleName;
        $this->themeName = $themeName;
        $this->iDName = $iDName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.chart.dashboard');
    }
}
