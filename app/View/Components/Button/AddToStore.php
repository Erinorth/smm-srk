<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;

class AddToStore extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<a class="btn btn-xs text-info" href="{{ URL('consumable_addstores') }}" title="Add to Store"><i class="fa fa-lg fa-fw fa-cart-plus"></i></a>
blade;
    }
}
