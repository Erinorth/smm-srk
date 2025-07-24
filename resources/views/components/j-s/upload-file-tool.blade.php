$(document).on('click','.attachment', function(){
    var attachment_id = $(this).attr('id');
    $('#create_form_{{ $name }}')[0].reset();
    $('#form_result_{{ $name }}').html('');
    $('#formModal_{{ $name }}').modal('show');
    console.log(attachment_id);
    $('#attachment_id').val(attachment_id);
});

$('#create_form_{{ $name }}').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var action_url_{{ $name }} = '';

    if($('#action_{{ $name }}').val() == 'Upload')
    {
        action_url_{{ $name }} = "{{ url('/upload_tool') }}";
    }

    if($('#action_{{ $name }}').val() == 'Edit')
    {
        action_url_{{ $name }} = "{{ url('/upload_tool/update') }}";
    }

    $.ajax({
        type:'POST',
        url: action_url_{{ $name }},
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data)
        {
            var html_{{ $name }} = '';
            if(data.errors)
            {
                html_{{ $name }} = '<div class="alert alert-danger">';
                for(var count = 0; count < data.errors.length; count++)
                {
                    html_{{ $name }} += '<p>' + data.errors[count] + '</p>';
                }
                html_{{ $name }} += '</div>';
                $('#create_form_{{ $name }}')[0].reset();
            }
            if(data.failures)
            {
                console.log('failures');

                html_{{ $name }} = '<div class="alert alert-danger">';
                for(var count = 0; count < data.failures.length; count++)
                {
                    html_{{ $name }} += '<p> Row:' + data.failures[count].row +
                    ' ' + data.failures[count].errors + '</p>';
                }
                html_{{ $name }} += '</div>';
                $('#create_form_{{ $name }}')[0].reset();
                $('#data_table').DataTable().ajax.reload();
            }
            if(data.success)
            {
                html_{{ $name }} = '<div class="alert alert-success">' + data.success + '</div>';
                $('#create_form_{{ $name }}')[0].reset();
                $('#data_table').DataTable().ajax.reload();
            }
            $('#form_result_{{ $name }}').html(html_{{ $name }});
        },
        error: function(data){
            console.log('error');
        }
    });
});

$(document).on('click','.edit_attachment', function(){
    var uploadid = $(this).attr('id');
    $('#form_result_{{ $name }}').html('');
    $('#attachment_id').val(uploadid);
    $('#action_button_{{ $name }}').val('Edit');
    $('#action_{{ $name }}').val('Edit');
    $('#formModal_{{ $name }}').modal('show');
    console.log(uploadid);
});

var user_id_{{ $name }};

$(document).on('click', '.delete_attachment', function(){
    user_id_{{ $name }} = $(this).attr('id');
    $('.modal-title').text('Confirmation');
    $('#ok_button_{{ $name }}').text('Delete');
    $('#confirmModal_{{ $name }}').modal('show');
    console.log(user_id_{{ $name }});
});

$('#ok_button_{{ $name }}').click(function(){
    $.ajax({
        url: "{{ url('/upload_tool/destroy') }}/" + user_id_{{ $name }} + "/{{ $name }}",
        beforeSend:function(){
            $('#ok_button_{{ $name }}').text('Deleting...');
        },
        success:function(data)
        {
            setTimeout(function(){
                $('#confirmModal_{{ $name }}').modal('hide');
                alert('Data Deleted');
                location.reload();
            }, 2000);
        }
    })
});
