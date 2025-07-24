<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Dropdown extends Component
{
    public $title;
    public $nameId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $nameId)
    {
        $this->title = $title;
        $this->nameId = $nameId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div class="form-group">
    <label class="control-label" >{{$title}}</label> <!-- -->
    <div>
        <select class="form-control select2-bootstrap4" name="{{$nameId}}" id="{{$nameId}}">
            {{$slot}}
        </select>
    </div>
</div>
blade;
    }
}
