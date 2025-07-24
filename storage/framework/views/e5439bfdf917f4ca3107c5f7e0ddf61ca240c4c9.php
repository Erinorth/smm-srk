 <?php if (isset($component)) { $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => '','collapseCard' => 'collapsed-card','title' => 'Tool Type','collapseButton' => 'plus','tableId' => '_tooltype']); ?>
<?php $component->withName('data-table.default-data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('tool'); ?> 
        <?php if(auth()->check() && auth()->user()->hasRole('admin|store_keeper')): ?>
             <?php if (isset($component)) { $__componentOriginal984d6b98ef3918f6802fc41f8389b70f5fdf74f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Button\CreateRecord::class, ['nameID' => '_tooltype']); ?>
<?php $component->withName('button.create-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal984d6b98ef3918f6802fc41f8389b70f5fdf74f4)): ?>
<?php $component = $__componentOriginal984d6b98ef3918f6802fc41f8389b70f5fdf74f4; ?>
<?php unset($__componentOriginal984d6b98ef3918f6802fc41f8389b70f5fdf74f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        <?php endif; ?>
     <?php $__env->endSlot(); ?>
    <th>Activity Type</th>
    <th>Main Type</th>
    <th>Sub Type</th>
    <th>Tool Name</th>
    <th>Remark</th>
    <th>Action</th>
     <?php $__env->slot('othertable'); ?> 
     <?php $__env->endSlot(); ?>
 <?php if (isset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5)): ?>
<?php $component = $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5; ?>
<?php unset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

 <?php if (isset($component)) { $__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\InputForm::class, ['nameID' => '_tooltype','modalTitle' => 'Create Tool Catagory']); ?>
<?php $component->withName('modal.input-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php if (isset($component)) { $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Text::class, ['title' => 'Activity Type','nameId' => 'ActivityType']); ?>
<?php $component->withName('input.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a)): ?>
<?php $component = $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a; ?>
<?php unset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Text::class, ['title' => 'Main Type','nameId' => 'MainType']); ?>
<?php $component->withName('input.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a)): ?>
<?php $component = $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a; ?>
<?php unset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Text::class, ['title' => 'Sub Type','nameId' => 'SubType']); ?>
<?php $component->withName('input.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a)): ?>
<?php $component = $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a; ?>
<?php unset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Text::class, ['title' => 'Tool Name','nameId' => 'ToolName']); ?>
<?php $component->withName('input.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a)): ?>
<?php $component = $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a; ?>
<?php unset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Text::class, ['title' => 'Remark','nameId' => 'Remark']); ?>
<?php $component->withName('input.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a)): ?>
<?php $component = $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a; ?>
<?php unset($__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php $__env->slot('othervalue'); ?> 
     <?php $__env->endSlot(); ?>
 <?php if (isset($__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa)): ?>
<?php $component = $__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa; ?>
<?php unset($__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

 <?php if (isset($component)) { $__componentOriginalbbba9e4bf837992f7af5c15b591501c1c2c90f3c = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\ConfirmDelete::class, ['deleteName' => '_tooltype']); ?>
<?php $component->withName('modal.confirm-delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalbbba9e4bf837992f7af5c15b591501c1c2c90f3c)): ?>
<?php $component = $__componentOriginalbbba9e4bf837992f7af5c15b591501c1c2c90f3c; ?>
<?php unset($__componentOriginalbbba9e4bf837992f7af5c15b591501c1c2c90f3c); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/components/content/tool-type.blade.php ENDPATH**/ ?>