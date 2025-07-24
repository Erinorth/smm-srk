<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class ConfirmDelete extends Component
{
    public $deleteName;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($deleteName)
    {
        $this->deleteName = $deleteName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div id="confirmModal{{$deleteName}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmation</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 class="text-center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button{{$deleteName}}" id="ok_button{{$deleteName}}" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
blade;
    }
}
