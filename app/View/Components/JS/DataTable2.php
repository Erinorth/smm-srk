<?php

namespace App\View\Components\JS;

use Illuminate\View\Component;

class DataTable2 extends Component
{
    public $tableName;
    public $ajaxUrl;
    public $ajaxUrl2;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tableName, $ajaxUrl = null, $ajaxUrl2 = null)
    {
        $this->tableName = $tableName;
        $this->ajaxUrl = $ajaxUrl;
        $this->ajaxUrl2 = $ajaxUrl2;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.j-s.data-table2');
    }
}
