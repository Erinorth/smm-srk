

<?php $__env->startSection('title','404 Error Page'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark">500 Error Page</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="error-page">
        <h2 class="headline text-danger">500</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>
            <p>
                We will work on fixing that right away.
                Meanwhile, you may <a href="/dashboard">return to dashboard</a>.
            </p>
            
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/errors/500.blade.php ENDPATH**/ ?>