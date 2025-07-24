$(document).on('click', '.edit{{$editName}}', function(){
    var id = $(this).attr('id');
    $('#form_result{{$editName}}').html('');
    $.ajax({
        url :"/{{$editUrl}}/"+id+"/edit",
        dataType:"json",
        success:function(data)
        {
            {{$slot}}
            $('#hidden_id{{$editName}}').val(id);
            $('#action_button{{$editName}}').val('Edit');
            $('#action{{$editName}}').val('Edit');
            $('#formModal{{$editName}}').modal('show');
        }
    })
});