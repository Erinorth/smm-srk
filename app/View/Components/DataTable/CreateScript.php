<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class CreateScript extends Component
{
    public $title;
    public $nameID;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $nameID)
    {
        $this->title = $title;
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
$('#create_record{{$nameID}}').click(function(){
    $('.select2-bootstrap4').val(null).trigger('change');
    $('.select2-hidden-accessible').val(null).trigger('change');
    $('#create_form{{$nameID}}')[0].reset();
    $('.modal-title{{$nameID}}').text('Add New {{$title}}');
    $('#action_button{{$nameID}}').val('Add');
    $('#action{{$nameID}}').val('Add');
    $('#form_result{{$nameID}}').html('');
    $('#formModal{{$nameID}}').modal('show');
});
blade;
    }
}
