<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class ColumnScript extends Component
{
    public $columnName;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
{
    data: '{{$columnName}}',
    name: '{{$columnName}}',
    {{$slot}}
},
blade;
    }
}
