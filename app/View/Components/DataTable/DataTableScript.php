<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class DataTableScript extends Component
{
    public $tableName;
    public $ajaxUrl;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tableName, $ajaxUrl = null)
    {
        $this->tableName = $tableName;
        $this->ajaxUrl = $ajaxUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.data-table.data-table-script');
    }
}
