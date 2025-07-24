<?php

namespace App\View\Components\Content;

use App\Models\Expectation;
use App\Models\Stakeholder;
use Illuminate\View\Component;

class StakeholderExpectation extends Component
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
        $stakeholder = Stakeholder::orderBy('StakeholderName','asc')->get();

        $expectation = Expectation::orderBy('Expectation','asc')->get();

        return view('components.content.stakeholder-expectation',compact('stakeholder','expectation'));
    }
}
