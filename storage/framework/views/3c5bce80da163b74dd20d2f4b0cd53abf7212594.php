 <?php if (isset($component)) { $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTableScript::class, ['tableName' => '_add_role','ajaxUrl' => ''.e(url('/user_roles')).'']); ?>
<?php $component->withName('data-table.data-table-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'UserName']); ?>
<?php $component->withName('data-table.column-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b)): ?>
<?php $component = $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b; ?>
<?php unset($__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
     <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'email']); ?>
<?php $component->withName('data-table.column-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        orderable: false
     <?php if (isset($__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b)): ?>
<?php $component = $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b; ?>
<?php unset($__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
     <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Role']); ?>
<?php $component->withName('data-table.column-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b)): ?>
<?php $component = $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b; ?>
<?php unset($__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
     <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'action']); ?>
<?php $component->withName('data-table.column-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        orderable: false
     <?php if (isset($__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b)): ?>
<?php $component = $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b; ?>
<?php unset($__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
     <?php $__env->slot('order'); ?> [0,'asc'] <?php $__env->endSlot(); ?>
 <?php if (isset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5)): ?>
<?php $component = $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5; ?>
<?php unset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

 <?php if (isset($component)) { $__componentOriginalb53487e2c7816706a08ad720a59c4d3afb5ccbe6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\CreateScript::class, ['nameID' => '_add_role','title' => 'Add New Role']); ?>
<?php $component->withName('data-table.create-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalb53487e2c7816706a08ad720a59c4d3afb5ccbe6)): ?>
<?php $component = $__componentOriginalb53487e2c7816706a08ad720a59c4d3afb5ccbe6; ?>
<?php unset($__componentOriginalb53487e2c7816706a08ad720a59c4d3afb5ccbe6); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

 <?php if (isset($component)) { $__componentOriginal7d853bcccbd33c940802828ca52fa5c67f0ee7ff = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\SubmitScript::class, ['nameID' => '_add_role','actionUrl' => ''.e(url('/user_roles')).'']); ?>
<?php $component->withName('data-table.submit-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php if (isset($component)) { $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => '_add_role']); ?>
<?php $component->withName('data-table.ajax-reload-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5)): ?>
<?php $component = $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5; ?>
<?php unset($__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
     <?php if (isset($component)) { $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => '']); ?>
<?php $component->withName('data-table.ajax-reload-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5)): ?>
<?php $component = $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5; ?>
<?php unset($__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
 <?php if (isset($__componentOriginal7d853bcccbd33c940802828ca52fa5c67f0ee7ff)): ?>
<?php $component = $__componentOriginal7d853bcccbd33c940802828ca52fa5c67f0ee7ff; ?>
<?php unset($__componentOriginal7d853bcccbd33c940802828ca52fa5c67f0ee7ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

var user_id;
var role_id;

$(document).on('click', '.delete_add_role', function(){
    user_id = $(this).attr('user_id');
    role_id = $(this).attr('role_id');
    $('.modal-title').text('Confirmation');
    $('#ok_button_add_role').text('Delete');
    $('#confirmModal_add_role').modal('show');
});

$('#ok_button_add_role').click(function(){
    $.ajax({
        url:"<?php echo e(url('/user_roles/destroy')); ?>/" + user_id + "/" + role_id,
        beforeSend:function(){
            $('#ok_button_add_role').text('Deleting...');
        },
        success:function(data)
        {
            setTimeout(function(){
                $('#confirmModal_add_role').modal('hide');
                $('#data_table_add_role').DataTable().ajax.reload();
                 <?php if (isset($component)) { $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => '']); ?>
<?php $component->withName('data-table.ajax-reload-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5)): ?>
<?php $component = $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5; ?>
<?php unset($__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                alert('Data Deleted');
            }, 2000);
        }
    })
});
<?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/components/j-s/add-role.blade.php ENDPATH**/ ?>