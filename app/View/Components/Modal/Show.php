<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class Show extends Component
{
    public $modalTitle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalTitle)
    {
        $this->modalTitle = $modalTitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
        <div id="showModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{$modalTitle}}</h4> <!-- -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
blade;
    }
}
