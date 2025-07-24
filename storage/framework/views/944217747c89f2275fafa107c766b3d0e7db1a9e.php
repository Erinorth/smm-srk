$('#create_form<?php echo e($nameID); ?>').on('submit', function(event){
    event.preventDefault();
    var formData = new FormData(this);
    var action_url = '';
    var baseActionUrl = "<?php echo e($actionUrl); ?>";

    // ตรวจสอบว่า actionUrl เป็น full URL หรือ relative path
    if (baseActionUrl.startsWith('http://') || baseActionUrl.startsWith('https://')) {
        // เป็น full URL
        if($('#action<?php echo e($nameID); ?>').val() == 'Add')
        {
            action_url = baseActionUrl;
        }
        
        if($('#action<?php echo e($nameID); ?>').val() == 'Edit')
        {
            action_url = baseActionUrl + "/update";
        }
    } else {
        // เป็น relative path
        if($('#action<?php echo e($nameID); ?>').val() == 'Add')
        {
            action_url = "/" + baseActionUrl;
        }
        
        if($('#action<?php echo e($nameID); ?>').val() == 'Edit')
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
                $('#create_form<?php echo e($nameID); ?>')[0].reset();
                <?php echo e($slot); ?>

            }
            $('#form_result<?php echo e($nameID); ?>').html(html);
        }
    });
});<?php /**PATH D:\xampp\htdocs\smm-srk\storage\framework\views/f85981bdf7a1faeaab6da1f616ab6751d520edf3.blade.php ENDPATH**/ ?>