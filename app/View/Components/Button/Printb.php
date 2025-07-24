<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;

class Printb extends Component
{
    public $url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<a class="btnprn btn btn-xs btn-default text-info mx-1 shadow" title="Print" href="{{$url}}"><i class="fa fa-lg fa-fw fa-print"></i></a>
blade;
    }
}
