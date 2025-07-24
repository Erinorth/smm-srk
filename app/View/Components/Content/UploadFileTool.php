<?php

namespace App\View\Components\Content;

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
        return view('components.content.upload-file-tool');
    }
}
