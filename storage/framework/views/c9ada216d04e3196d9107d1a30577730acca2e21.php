$(document).on('click', '.edit<?php echo e($editName); ?>', function(){
    var id = $(this).attr('id');
    $('#form_result<?php echo e($editName); ?>').html('');
    var baseEditUrl = "<?php echo e($editUrl); ?>";
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
            <?php echo e($slot); ?>

            $('#hidden_id<?php echo e($editName); ?>').val(id);
            $('#action_button<?php echo e($editName); ?>').val('Edit');
            $('#action<?php echo e($editName); ?>').val('Edit');
            $('#formModal<?php echo e($editName); ?>').modal('show');
        }
    })
});<?php /**PATH D:\xampp\htdocs\smm-srk\storage\framework\views/e8b08b6b3296b28b6dc37fc3429c824049aa0e57.blade.php ENDPATH**/ ?>