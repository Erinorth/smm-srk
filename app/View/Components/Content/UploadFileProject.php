<?php

namespace App\View\Components\Content;

use App\Models\Project;
use Illuminate\View\Component;

class UploadFileProject extends Component
{
    public $name;
    public $projectID;

    public function __construct($name, $projectID = null)
    {
        $this->name = $name;
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

        return view('components.content.upload-file-project',compact('project'));
    }
}
