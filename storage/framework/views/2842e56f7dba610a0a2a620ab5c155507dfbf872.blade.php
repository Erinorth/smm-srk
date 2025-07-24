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