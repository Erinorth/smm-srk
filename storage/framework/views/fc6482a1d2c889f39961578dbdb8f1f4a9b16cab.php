 <?php if (isset($component)) { $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => '','collapseCard' => 'collapsed-card','title' => 'Link Employee','collapseButton' => 'plus','tableId' => '_link_employee']); ?>
<?php $component->withName('data-table.default-data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('tool'); ?> 
     <?php $__env->endSlot(); ?>
    <th>Work ID</th>
    <th>Name</th>
    <th>User Name</th>
    <th>Email</th>
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
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\InputForm::class, ['nameID' => '_link_employee','modalTitle' => 'Add New Employee']); ?>
<?php $component->withName('modal.input-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php if (isset($component)) { $__componentOriginal8edc3f604ccf86198d552bab71204eb2a48b3274 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Dropdown::class, ['title' => 'User Name','nameId' => 'user_id']); ?>
<?php $component->withName('input.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <option></option>
        <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     <?php if (isset($__componentOriginal8edc3f604ccf86198d552bab71204eb2a48b3274)): ?>
<?php $component = $__componentOriginal8edc3f604ccf86198d552bab71204eb2a48b3274; ?>
<?php unset($__componentOriginal8edc3f604ccf86198d552bab71204eb2a48b3274); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\ConfirmDelete::class, ['deleteName' => '_link_employee']); ?>
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
<?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/components/content/link-employee.blade.php ENDPATH**/ ?>