<?php

namespace App\View\Components\JS;

use Illuminate\View\Component;

class OTFrame extends Component
{
    public $projectID;

    public function __construct($projectID)
    {
        $this->projectID = $projectID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $project = $this->projectID;

        return view('components.j-s.o-t-frame',compact('project'));
    }
}
