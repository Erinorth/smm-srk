<?php

namespace App\View\Components\Content;

use App\Models\Department;
use Illuminate\View\Component;

class Product extends Component
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
        $department = Department::orderby('DepartmentName','asc')->get();

        return view('components.content.product',compact('department'));
    }
}
