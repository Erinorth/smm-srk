<button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => "btn btn-{$theme}"])); ?>

    <?php if(isset($nameID)): ?>name="<?php echo e($nameID); ?>" id="<?php echo e($nameID); ?>"<?php endif; ?>>
    <?php if(isset($icon)): ?> <i class="<?php echo e($icon); ?>"></i> <?php endif; ?>
    <?php if(isset($label)): ?> <?php echo e($label); ?> <?php endif; ?>
</button>
<?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/vendor/adminlte/components/form/button.blade.php ENDPATH**/ ?>