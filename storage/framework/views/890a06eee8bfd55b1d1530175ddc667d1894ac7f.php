

<?php $__env->startSection('title','Employee'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark">Employee</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
     <?php if (isset($component)) { $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => '','collapseCard' => '','title' => 'Employee','collapseButton' => 'minus','tableId' => '']); ?>
<?php $component->withName('data-table.default-data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?> 
            <?php if(auth()->check() && auth()->user()->hasRole('admin|head_engineering|head_operation')): ?>
                 <?php if (isset($component)) { $__componentOriginal984d6b98ef3918f6802fc41f8389b70f5fdf74f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Button\CreateRecord::class, ['nameID' => '']); ?>
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
        <th>Code</th>
        <th>ID</th>
        <th>Thai Name</th>
        <th>English Name</th>
        <th>Position</th>
        <th>EGAT Email</th>
        <th>Department</th>
        <th>Admin</th>
        <th>Telephone Number</th>
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
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\InputForm::class, ['nameID' => '','modalTitle' => 'Add New Employee']); ?>
<?php $component->withName('modal.input-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'WorkID','label' => 'Work ID','disableFeedback' => true]); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Input a text...']); ?>
<?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'ThaiName','label' => 'Thai Name','disableFeedback' => true]); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Input a text...']); ?>
<?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'EnglishName','label' => 'English Name','disableFeedback' => true]); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Input a text...']); ?>
<?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Position','label' => 'Position','disableFeedback' => true]); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Input a text...']); ?>
<?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'EGATEmail','label' => 'EGAT Email','disableFeedback' => true]); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Input a text...']); ?>
<?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Select2::class, ['name' => 'department_id','label' => 'Department']); ?>
<?php $component->withName('adminlte-select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-placeholder' => 'Select an option...']); ?>
            <option/>
            <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value->id); ?>"><?php echo e($value->DepartmentName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php if (isset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435)): ?>
<?php $component = $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435; ?>
<?php unset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Select2::class, ['name' => 'Admin','label' => 'Admin']); ?>
<?php $component->withName('adminlte-select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-placeholder' => 'Select an option...']); ?>
            <option/>
            <option>Head</option>
            <option>Admin</option>
            <option>No</option>
         <?php if (isset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435)): ?>
<?php $component = $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435; ?>
<?php unset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Telephone','label' => 'Telephone Number','disableFeedback' => true]); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Input a text...']); ?>
<?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\ConfirmDelete::class, ['deleteName' => '']); ?>
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

     <?php if (isset($component)) { $__componentOriginal9174bccf6cae1870db47364c3ebe43399a873318 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Content\Department::class, []); ?>
<?php $component->withName('content.department'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal9174bccf6cae1870db47364c3ebe43399a873318)): ?>
<?php $component = $__componentOriginal9174bccf6cae1870db47364c3ebe43399a873318; ?>
<?php unset($__componentOriginal9174bccf6cae1870db47364c3ebe43399a873318); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function(){

             <?php if (isset($component)) { $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTableScript::class, ['tableName' => '','ajaxUrl' => ''.e(url('/employees')).'']); ?>
<?php $component->withName('data-table.data-table-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'id']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'WorkID']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'ThaiName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'EnglishName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Position']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'EGATEmail']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'DepartmentName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Admin']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Telephone']); ?>
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
                 <?php $__env->slot('order'); ?> [1,'asc'] <?php $__env->endSlot(); ?>
             <?php if (isset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5)): ?>
<?php $component = $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5; ?>
<?php unset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

             <?php if (isset($component)) { $__componentOriginalb53487e2c7816706a08ad720a59c4d3afb5ccbe6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\CreateScript::class, ['nameID' => '','title' => 'Employee']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\SubmitScript::class, ['nameID' => '','actionUrl' => ''.e(url('/employees')).'']); ?>
<?php $component->withName('data-table.submit-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
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

             <?php if (isset($component)) { $__componentOriginal5a8484bd9526672dca7c392b9b56a48db8a0ed39 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditScript::class, ['editName' => '','editUrl' => ''.e(url('/employees')).'']); ?>
<?php $component->withName('data-table.edit-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'WorkID']); ?>
<?php $component->withName('data-table.edit-value-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0)): ?>
<?php $component = $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0; ?>
<?php unset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'ThaiName']); ?>
<?php $component->withName('data-table.edit-value-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0)): ?>
<?php $component = $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0; ?>
<?php unset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'EnglishName']); ?>
<?php $component->withName('data-table.edit-value-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0)): ?>
<?php $component = $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0; ?>
<?php unset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'Position']); ?>
<?php $component->withName('data-table.edit-value-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0)): ?>
<?php $component = $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0; ?>
<?php unset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'EGATEmail']); ?>
<?php $component->withName('data-table.edit-value-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0)): ?>
<?php $component = $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0; ?>
<?php unset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'department_id']); ?>
<?php $component->withName('data-table.edit-value-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0)): ?>
<?php $component = $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0; ?>
<?php unset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'Admin']); ?>
<?php $component->withName('data-table.edit-value-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0)): ?>
<?php $component = $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0; ?>
<?php unset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'Telephone']); ?>
<?php $component->withName('data-table.edit-value-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0)): ?>
<?php $component = $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0; ?>
<?php unset($__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
             <?php if (isset($__componentOriginal5a8484bd9526672dca7c392b9b56a48db8a0ed39)): ?>
<?php $component = $__componentOriginal5a8484bd9526672dca7c392b9b56a48db8a0ed39; ?>
<?php unset($__componentOriginal5a8484bd9526672dca7c392b9b56a48db8a0ed39); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

             <?php if (isset($component)) { $__componentOriginal54287947bfea0fef77130bade56aaba586af47cc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DeleteScript::class, ['deleteName' => '','url' => ''.e(url('/employees')).'']); ?>
<?php $component->withName('data-table.delete-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal54287947bfea0fef77130bade56aaba586af47cc)): ?>
<?php $component = $__componentOriginal54287947bfea0fef77130bade56aaba586af47cc; ?>
<?php unset($__componentOriginal54287947bfea0fef77130bade56aaba586af47cc); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

             <?php if (isset($component)) { $__componentOriginal624795dcbdf1282cded1fac23fc86d4ec8176f73 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\JS\Department::class, []); ?>
<?php $component->withName('j-s.department'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal624795dcbdf1282cded1fac23fc86d4ec8176f73)): ?>
<?php $component = $__componentOriginal624795dcbdf1282cded1fac23fc86d4ec8176f73; ?>
<?php unset($__componentOriginal624795dcbdf1282cded1fac23fc86d4ec8176f73); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/employees/index.blade.php ENDPATH**/ ?>