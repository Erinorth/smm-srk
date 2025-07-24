$(document).on('click', '.edit{{$editName}}', function(){
    var id = $(this).attr('id');
    $('#form_result{{$editName}}').html('');
    var baseEditUrl = "{{$editUrl}}";
    var editUrl = '';

    // ตรวจสอบว่า editUrl เป็น full URL หรือ relative path
    if (baseEditUrl.startsWith('http://') || baseEditUrl.startsWith('https://')) {
        // เป็น full URL
        editUrl = baseEditUrl + "/" + id + "/edit";
    } else {
        // เป็น relative path
        editUrl = "/" + baseEditUrl + "/" + id + "/edit";
    }

    $.ajax({
        url: editUrl,
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