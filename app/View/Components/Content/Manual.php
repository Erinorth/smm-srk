<?php

namespace App\View\Components\Content;

use Illuminate\View\Component;

class Manual extends Component
{
    public $tableData;

    public function __construct($tableData)
    {
        $this->tableData = $tableData;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.content.manual');
    }
}
