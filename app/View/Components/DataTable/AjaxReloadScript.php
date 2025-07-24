<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class AjaxReloadScript extends Component
{
    public $tableId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tableId)
    {
        $this->tableId = $tableId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
$('#data_table{{$tableId}}').DataTable().ajax.reload();
blade;
    }
}
