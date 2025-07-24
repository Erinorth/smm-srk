<?php

namespace App\View\Components\Content;

use Illuminate\View\Component;
use App\Models\Employee;

class PlanOT extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.content.plan-o-t');
    }
}
