<?php

namespace App\View\Components\Content;

use App\User;
use Illuminate\View\Component;

class LinkEmployee extends Component
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
        $user = User::orderBy('name','asc')->get();

        return view('components.content.link-employee',compact('user'));
    }
}
