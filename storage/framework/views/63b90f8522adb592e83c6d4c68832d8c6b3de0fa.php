var user_id;

$(document).on('click', '.delete<?php echo e($deleteName); ?>', function(){
    user_id = $(this).attr('id');
    $('.modal-title<?php echo e($deleteName); ?>').text('Confirmation');
    $('#ok_button<?php echo e($deleteName); ?>').text('Delete');
    $('#confirmModal<?php echo e($deleteName); ?>').modal('show');
});

$('#ok_button<?php echo e($deleteName); ?>').click(function(){
    $.ajax({
        url:"/<?php echo e($url); ?>/destroy/"+user_id, //
        beforeSend:function(){
            $('#ok_button<?php echo e($deleteName); ?>').text('Deleting...');
        },
        success:function(data)
        {
            setTimeout(function(){
                $('#confirmModal<?php echo e($deleteName); ?>').modal('hide');
                alert('Data Deleted');
                location.reload();
            }, 2000);
        }
    })
});<?php /**PATH D:\xampp\htdocs\smm-srk\storage\framework\views/101e457e8e616d723f1d800aa45a830f90b2d857.blade.php ENDPATH**/ ?>