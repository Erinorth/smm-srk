<?php

namespace App\View\Components\Content;

use App\Models\Location;
use App\Models\StakeholderType;
use Illuminate\View\Component;

class Stakeholder extends Component
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
        $type = StakeholderType::orderBy('TypeName','asc')->get();
        $location = Location::orderBy('LocationThaiName','asc')->get();

        return view('components.content.stakeholder',compact('type','location'));
    }
}
