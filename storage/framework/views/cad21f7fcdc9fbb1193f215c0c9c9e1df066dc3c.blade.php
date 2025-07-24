$('#create_form{{$nameID}}').on('submit', function(event){
    event.preventDefault();
    var formData = new FormData(this);
    var action_url = '';

    if($('#action{{$nameID}}').val() == 'Add')
    {
        action_url = "/{{$actionUrl}}";
    }

    if($('#action{{$nameID}}').val() == 'Edit')
    {
        action_url = "/{{$actionUrl}}/update";
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