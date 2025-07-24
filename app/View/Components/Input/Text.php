<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Text extends Component
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
        <input type="text" class="form-control" name="{{$nameId}}" id="{{$nameId}}">
    </div>
</div>
blade;
    }
}
