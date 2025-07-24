<div class="text-center">
    <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                                <button class="edit btn btn-xs btn-default text-warning mx-1 shadow" name="edit" id="<?php echo e($data->id); ?>" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>

        <button class="delete btn btn-xs btn-default text-danger mx-1 shadow" name="edit" id="<?php echo e($data->id); ?>" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>
    <?php else: ?> N/A
    <?php endif; ?>
</div><?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/users/action2.blade.php ENDPATH**/ ?>