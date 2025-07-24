$(document).on('click', '.edit<?php echo e($editName); ?>', function(){
    var id = $(this).attr('id');
    $('#form_result<?php echo e($editName); ?>').html('');
    $.ajax({
        url :"/<?php echo e($editUrl); ?>/"+id+"/edit",
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
});<?php /**PATH D:\xampp\htdocs\smm-srk\storage\framework\views/ce7faf5bf62eb8534bc975d2b3d54acb676db91a.blade.php ENDPATH**/ ?>