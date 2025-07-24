$('#create_record<?php echo e($nameID); ?>').click(function(){
    $('.select2-bootstrap4').val(null).trigger('change');
    $('.select2-hidden-accessible').val(null).trigger('change');
    $('#create_form<?php echo e($nameID); ?>')[0].reset();
    $('.modal-title<?php echo e($nameID); ?>').text('Add New <?php echo e($title); ?>');
    $('#action_button<?php echo e($nameID); ?>').val('Add');
    $('#action<?php echo e($nameID); ?>').val('Add');
    $('#form_result<?php echo e($nameID); ?>').html('');
    $('#formModal<?php echo e($nameID); ?>').modal('show');
});<?php /**PATH D:\xampp\htdocs\smm-srk\storage\framework\views/2842e56f7dba610a0a2a620ab5c155507dfbf872.blade.php ENDPATH**/ ?>