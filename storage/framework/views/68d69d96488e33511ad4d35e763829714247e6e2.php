

<?php $__env->startSection('title', 'Risk Schedule'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark">Risk Schedule</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
     <?php if (isset($component)) { $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Card\DefaultCard::class, ['color' => '','collapseCard' => '','title' => 'Risk Schedule','collapseButton' => 'minus']); ?>
<?php $component->withName('card.default-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
        <div class="container">
            <div id="calendar"></div>
        </div>
     <?php if (isset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188)): ?>
<?php $component = $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188; ?>
<?php unset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Card\DefaultCard::class, ['color' => '','collapseCard' => 'collapsed-card','title' => 'Yesterday','collapseButton' => 'plus']); ?>
<?php $component->withName('card.default-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
        <table class="table table-striped table-bordered table-sm display">
            <thead>
                <tr>
                    <th class="text-center align-middle">Project Name</th>
                    <th class="text-center align-middle">กิจกรรม</th>
                    <th class="text-center align-middle">ลักษณะความเสี่ยง</th>
                    <th class="text-center align-middle">ผลกระทบ</th>
                    <th class="text-center align-middle">มาตรการควบคุม</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $yesterday; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($value->ProjectName); ?></td>
                        <td><?php echo e($value->Activity); ?></td>
                        <td><?php echo e($value->TypeOfRisk); ?></td>
                        <td><?php echo e($value->Effect); ?></td>
                        <td><?php echo e($value->CounterMeasure); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
     <?php if (isset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188)): ?>
<?php $component = $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188; ?>
<?php unset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Card\DefaultCard::class, ['color' => '','collapseCard' => '','title' => 'Today : '.e(NOW()).'','collapseButton' => 'minus']); ?>
<?php $component->withName('card.default-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Project Name</th>
                    <th class="text-center align-middle">กิจกรรม</th>
                    <th class="text-center align-middle">ลักษณะความเสี่ยง</th>
                    <th class="text-center align-middle">ผลกระทบ</th>
                    <th class="text-center align-middle">มาตรการควบคุม</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $today; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($value->ProjectName); ?></td>
                        <td><?php echo e($value->Activity); ?></td>
                        <td><?php echo e($value->TypeOfRisk); ?></td>
                        <td><?php echo e($value->Effect); ?></td>
                        <td><?php echo e($value->CounterMeasure); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
     <?php if (isset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188)): ?>
<?php $component = $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188; ?>
<?php unset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Card\DefaultCard::class, ['color' => '','collapseCard' => 'collapsed-card','title' => 'Tomorrow','collapseButton' => 'plus']); ?>
<?php $component->withName('card.default-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="text-center align-middle">Project Name</th>
                    <th class="text-center align-middle">กิจกรรม</th>
                    <th class="text-center align-middle">ลักษณะความเสี่ยง</th>
                    <th class="text-center align-middle">ผลกระทบ</th>
                    <th class="text-center align-middle">มาตรการควบคุม</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $tomorrow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($value->ProjectName); ?></td>
                        <td><?php echo e($value->Activity); ?></td>
                        <td><?php echo e($value->TypeOfRisk); ?></td>
                        <td><?php echo e($value->Effect); ?></td>
                        <td><?php echo e($value->CounterMeasure); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
     <?php if (isset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188)): ?>
<?php $component = $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188; ?>
<?php unset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function(){

            var calendar = $('#calendar').fullCalendar({
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                header:{
                    left:'prev,next',
                    center:'title',
                    right:'today'
                },
                events:'/QSH_schedules',
                eventAfterRender: function(event, element) {
                    $(element).tooltip({
                        title: event.description,
                        container: "body"
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/QSHs/schedule.blade.php ENDPATH**/ ?>