<?php

namespace App\View\Components\JS;

use Illuminate\View\Component;

class DashboardChart extends Component
{
    public $chartName;

    public function __construct($chartName)
    {
        $this->chartName = $chartName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.j-s.dashboard-chart');
    }
}
