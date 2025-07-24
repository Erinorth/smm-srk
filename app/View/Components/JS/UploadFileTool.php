<?php

namespace App\View\Components\JS;

use Illuminate\View\Component;

class UploadFileTool extends Component
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.j-s.upload-file-tool');
    }
}
