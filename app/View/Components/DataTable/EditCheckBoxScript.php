<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class EditCheckBoxScript extends Component
{
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
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
        return <<<'blade'
if( data.result.{{$name}} == 1 ) {
    $('#{{$name}}').prop('checked', true);
} else {
    $('#{{$name}}').prop('checked', false);
}
blade;
    }
}
