<?php

namespace App\View\Components\Content;

use App\Models\Expectation;
use App\Models\Factor;
use Illuminate\View\Component;

class ExpectationFactor extends Component
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
        $expectation = Expectation::orderBy('Expectation','asc')->get();

        $factor = Factor::orderBy('Factor','asc')->get();

        return view('components.content.expectation-factor',compact('expectation','factor'));
    }
}
