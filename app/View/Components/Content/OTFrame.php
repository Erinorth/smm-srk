<?php

namespace App\View\Components\Content;

use App\Models\Project;
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
        $project = Project::find($this->projectID);

        return view('components.content.o-t-frame',compact('project'));
    }
}
