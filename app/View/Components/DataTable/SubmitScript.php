<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;

class SubmitScript extends Component
{
    public $actionUrl;
    public $nameID;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($actionUrl, $nameID)
    {
        $this->actionUrl = $actionUrl;
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
$('#create_form{{$nameID}}').on('submit', function(event){
    event.preventDefault();
    var formData = new FormData(this);
    var action_url = '';
    var baseActionUrl = "{{$actionUrl}}";

    // ตรวจสอบว่า actionUrl เป็น full URL หรือ relative path
    if (baseActionUrl.startsWith('http://') || baseActionUrl.startsWith('https://')) {
        // เป็น full URL
        if($('#action{{$nameID}}').val() == 'Add')
        {
            action_url = baseActionUrl;
        }
        
        if($('#action{{$nameID}}').val() == 'Edit')
        {
            action_url = baseActionUrl + "/update";
        }
    } else {
        // เป็น relative path
        if($('#action{{$nameID}}').val() == 'Add')
        {
            action_url = "/" + baseActionUrl;
        }
        
        if($('#action{{$nameID}}').val() == 'Edit')
        {
            action_url = "/" + baseActionUrl + "/update";
        }
    }

    $.ajax({
        type:'POST',
        url: action_url,
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data)
        {
            var html = '';
            if(data.errors)
            {
                html = '<div class="alert alert-danger">';
                for(var count = 0; count < data.errors.length; count++)
                {
                    html += '<p>' + data.errors[count] + '</p>';
                }
                html += '</div>';
            }
            if(data.success)
            {
                html = '<div class="alert alert-success">' + data.success + '</div>';
                $('.select2-bootstrap4').val(null).trigger('change');
                $('#create_form{{$nameID}}')[0].reset();
                {{$slot}}
            }
            $('#form_result{{$nameID}}').html(html);
        }
    });
});
blade;
    }
}
