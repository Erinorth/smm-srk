<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class DeleteScript extends Component
{
    public $url;
    public $deleteName;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url, $deleteName)
    {
        $this->url = $url;
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
var user_id;

$(document).on('click', '.delete{{$deleteName}}', function(){
    user_id = $(this).attr('id');
    $('.modal-title{{$deleteName}}').text('Confirmation');
    $('#ok_button{{$deleteName}}').text('Delete');
    $('#confirmModal{{$deleteName}}').modal('show');
});

$('#ok_button{{$deleteName}}').click(function(){
    $.ajax({
        url:"/{{$url}}/destroy/"+user_id, //
        beforeSend:function(){
            $('#ok_button{{$deleteName}}').text('Deleting...');
        },
        success:function(data)
        {
            setTimeout(function(){
                $('#confirmModal{{$deleteName}}').modal('hide');
                alert('Data Deleted');
                location.reload();
            }, 2000);
        }
    })
});
blade;
    }
}
