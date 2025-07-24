<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;

class CreateRecord extends Component
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
        return <<<'blade'
<button class="btn btn-xs text-success" name="create_record{{$nameID}}" id="create_record{{$nameID}}" title="Add"><i class="fa fa-lg fa-fw fa-plus-square"></i></button>
blade;
    }
}
