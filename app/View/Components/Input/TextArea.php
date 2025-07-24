<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class TextArea extends Component
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
        <textarea class="form-control" name="{{$nameId}}" id="{{$nameId}}" rows="3"></textarea>
    </div>
</div>
blade;
    }
}
