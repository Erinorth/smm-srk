<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class InputForm extends Component
{
    public $modalTitle;
    public $nameID;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalTitle, $nameID)
    {
        $this->modalTitle = $modalTitle;
        $this->nameID = $nameID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div id="formModal{{$nameID}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$modalTitle}}</h4> <!-- -->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_result{{$nameID}}"></span>
                <form method="post" id="create_form{{$nameID}}" class="form-horizontal">
                    @csrf
                    {{$slot}}
                    <div class="form-group text-center">
                        {{$othervalue}}
                        <input type="hidden" name="action{{$nameID}}" id="action{{$nameID}}" value="Add" />
                        <input type="hidden" name="hidden_id{{$nameID}}" id="hidden_id{{$nameID}}" />
                        <input type="submit" name="action_button{{$nameID}}" id="action_button{{$nameID}}" class="btn btn-success" value="Add" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
blade;
    }
}
