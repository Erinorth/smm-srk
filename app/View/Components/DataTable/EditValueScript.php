<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class EditValueScript extends Component
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
$('#{{$name}}').val(data.result.{{$name}});
$('#{{$name}}').trigger('change');
blade;
    }
}
