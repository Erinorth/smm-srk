<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class CheckBox extends Component
{
    public $title;
    public $idValue;
    public $nameValue;
    public $checkValue;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $idValue, $nameValue, $checkValue)
    {
        $this->title = $title;
        $this->idValue = $idValue;
        $this->nameValue = $nameValue;
        $this->checkValue = $checkValue;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="{{$checkValue}}" id="{{$idValue}}" name="{{$nameValue}}">
    <label class="form-check-label" for="{{$nameValue}}">
        {{$title}}
    </label>
</div>
blade;
    }
}
