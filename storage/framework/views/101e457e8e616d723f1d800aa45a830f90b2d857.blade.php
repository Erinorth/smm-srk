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