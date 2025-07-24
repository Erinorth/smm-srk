<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class TextColumn extends Component
{
    public $title;
    public $nameIdA;
    public $nameIdB;
    public $placeholderA;
    public $placeholderB;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $nameIdA, $nameIdB, $placeholderA, $placeholderB)
    {
        $this->title = $title;
        $this->nameIdA = $nameIdA;
        $this->nameIdB = $nameIdB;
        $this->placeholderA = $placeholderA;
        $this->placeholderB = $placeholderB;
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
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" name="{{$nameIdA}}" id="{{$nameIdA}}" placeholder="{{$placeholderA}}">
        </div>
        <div class="col">
            <input type="text" class="form-control" name="{{$nameIdB}}" id="{{$nameIdB}}" placeholder="{{$placeholderB}}">
        </div>
    </div>
</div>
blade;
    }
}
