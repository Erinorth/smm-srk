<div class="<?php echo e($makeFormGroupClass()); ?>">

    
    <?php if(isset($label)): ?>
        <label for="<?php echo e($id); ?>" <?php if(isset($labelClass)): ?> class="<?php echo e($labelClass); ?>" <?php endif; ?>>
            <?php echo e($label); ?>

        </label>
    <?php endif; ?>

    
    <div class="<?php echo e($makeInputGroupClass($errors->first($errorKey))); ?>">

        
        <?php if(isset($prependSlot)): ?>
            <div class="input-group-prepend"><?php echo e($prependSlot); ?></div>
        <?php endif; ?>

        
        <?php echo $__env->yieldContent('input_group_item'); ?>

        
        <?php if(isset($appendSlot)): ?>
            <div class="input-group-append"><?php echo e($appendSlot); ?></div>
        <?php endif; ?>

    </div>

    
    <?php if(! isset($disableFeedback)): ?>
        <?php $__errorArgs = [$errorKey];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-feedback d-block" role="alert">
                <strong><?php echo e($message); ?></strong>
            </span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <?php endif; ?>

</div>



<?php if (! $__env->hasRenderedOnce('5fd2b74e-266b-4f4e-a857-8df3c6106347')): $__env->markAsRenderedOnce('5fd2b74e-266b-4f4e-a857-8df3c6106347'); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">

    

    .adminlte-invalid-igroup {
        box-shadow: 0 .25rem 0.5rem rgba(0,0,0,.1);
    }

    

    .adminlte-invalid-igroup > .input-group-prepend > *,
    .adminlte-invalid-igroup > .input-group-append > * {
        border-color: #dc3545 !important;
    }

</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/vendor/adminlte/components/form/input-group-component.blade.php ENDPATH**/ ?>