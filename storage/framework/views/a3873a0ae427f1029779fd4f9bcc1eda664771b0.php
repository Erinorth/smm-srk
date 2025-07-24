

<?php $__env->startSection('title','KPI'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark">KPI</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
     <?php if (isset($component)) { $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Card\DefaultCard::class, ['color' => '','collapseCard' => '','title' => 'Report','collapseButton' => 'minus']); ?>
<?php $component->withName('card.default-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
        <form class="form-horizontal" method="POST" action="<?php echo e(url('/KPIs_all')); ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label class="control-label" >Department</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="Department" id="Department">
                                <option></option>
                                <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->id); ?>"><?php echo e($value->DepartmentName); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label" >Period</label> <!-- -->
                        <div class="col">
                            <select class="form-control select2-bootstrap4" name="Period" id="Period">
                                <option></option>
                                <?php $__currentLoopData = $period; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->id); ?>"><?php echo e($value->StartDate); ?> to <?php echo e($value->EndDate); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <button type="submit" class="btn btn-success btn-sm">Report</button>
                </div>
            </div>
        </form>
     <?php if (isset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188)): ?>
<?php $component = $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188; ?>
<?php unset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/KPIs/index.blade.php ENDPATH**/ ?>