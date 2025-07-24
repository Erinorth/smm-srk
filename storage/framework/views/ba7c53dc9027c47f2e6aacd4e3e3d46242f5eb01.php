$('#create_form<?php echo e($nameID); ?>').on('submit', function(event){
    event.preventDefault();
    var formData = new FormData(this);
    var action_url = '';

    if($('#action<?php echo e($nameID); ?>').val() == 'Add')
    {
        action_url = "/<?php echo e($actionUrl); ?>";
    }

    if($('#action<?php echo e($nameID); ?>').val() == 'Edit')
    {
        action_url = "/<?php echo e($actionUrl); ?>/update";
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
                $('#create_form<?php echo e($nameID); ?>')[0].reset();
                <?php echo e($slot); ?>

            }
            $('#form_result<?php echo e($nameID); ?>').html(html);
        }
    });
});<?php /**PATH D:\xampp\htdocs\smm-srk\storage\framework\views/cad21f7fcdc9fbb1193f215c0c9c9e1df066dc3c.blade.php ENDPATH**/ ?>