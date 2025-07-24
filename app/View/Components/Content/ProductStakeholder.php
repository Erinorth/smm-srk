<?php

namespace App\View\Components\Content;

use App\Models\Product;
use App\Models\Stakeholder;
use Illuminate\View\Component;

class ProductStakeholder extends Component
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
        $product = Product::orderBy('ProductName','asc')->get();

        $stakeholder = Stakeholder::orderBy('StakeholderName','asc')->get();

        return view('components.content.product-stakeholder',compact('product','stakeholder'));
    }
}
