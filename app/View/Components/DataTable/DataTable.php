<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $nameID;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($nameID)
    {
        $this->nameID = $nameID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.data-table.data-table');
    }
}
