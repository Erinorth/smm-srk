<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;

class Menu extends Component
{
    public $color;
    public $url;
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($color, $url, $name)
    {
        $this->color = $color;
        $this->url = $url;
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
<a class="btn btn-{{$color}} btn-sm" href="{{$url}}">{{$name}}</a>
blade;
    }
}
