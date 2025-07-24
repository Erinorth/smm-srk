<?php $__env->startSection('title','Project'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark">Projects</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                 <?php if (isset($component)) { $__componentOriginal0016fe8f62f0dc60d54a606049e169e1ae7c8127 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::class, ['title' => 'Calendar','theme' => 'primary','icon' => '','collapsible' => true,'removable' => true,'maximizable' => true]); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <div id="calendar"></div>
                 <?php if (isset($__componentOriginal0016fe8f62f0dc60d54a606049e169e1ae7c8127)): ?>
<?php $component = $__componentOriginal0016fe8f62f0dc60d54a606049e169e1ae7c8127; ?>
<?php unset($__componentOriginal0016fe8f62f0dc60d54a606049e169e1ae7c8127); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <?php if (isset($component)) { $__componentOriginal0016fe8f62f0dc60d54a606049e169e1ae7c8127 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Widget\Card::class, ['title' => 'Not Confirmed Project','theme' => 'red','collapsible' => 'collapsed','removable' => true,'maximizable' => true]); ?>
<?php $component->withName('adminlte-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                     <?php $__env->slot('toolsSlot'); ?> 
                        <?php if(auth()->check() && auth()->user()->hasRole('admin|head_engineering|planner|head_operation|head_diving')): ?>
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
                     <?php if (isset($component)) { $__componentOriginala280d1703fe48d0038c58d7ba038b66a75601590 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTable::class, ['nameID' => '_notconfirmed']); ?>
<?php $component->withName('data-table.data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                        <th>Project Name</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>Finish Date</th>
                        <th>Responsible</th>
                        <th>Action</th>
                         <?php $__env->slot('othertable'); ?> 
                         <?php $__env->endSlot(); ?>
                     <?php if (isset($__componentOriginala280d1703fe48d0038c58d7ba038b66a75601590)): ?>
<?php $component = $__componentOriginala280d1703fe48d0038c58d7ba038b66a75601590; ?>
<?php unset($__componentOriginala280d1703fe48d0038c58d7ba038b66a75601590); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($__componentOriginal0016fe8f62f0dc60d54a606049e169e1ae7c8127)): ?>
<?php $component = $__componentOriginal0016fe8f62f0dc60d54a606049e169e1ae7c8127; ?>
<?php unset($__componentOriginal0016fe8f62f0dc60d54a606049e169e1ae7c8127); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <?php if (isset($component)) { $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => 'card-green','collapseCard' => 'collapsed-card','title' => 'Preparing Project','collapseButton' => 'plus','tableId' => '_preparing']); ?>
<?php $component->withName('data-table.default-data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                     <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>Finish Date</th>
                    <th>Responsible</th>
                    <th>Key Date</th>
                    <th>Milestone</th>
                    <th>Action</th>
                     <?php $__env->slot('othertable'); ?> 
                     <?php $__env->endSlot(); ?>
                 <?php if (isset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5)): ?>
<?php $component = $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5; ?>
<?php unset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <?php if (isset($component)) { $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => 'card-cyan','collapseCard' => '','title' => 'Inprogress Project','collapseButton' => 'minus','tableId' => '_inprogress']); ?>
<?php $component->withName('data-table.default-data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                     <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>Finish Date</th>
                    <th>Responsible</th>
                    <th>Daily Report Link</th>
                    <th>Key Date</th>
                    <th>Milestone</th>
                    <th>Action</th>
                     <?php $__env->slot('othertable'); ?> 
                     <?php $__env->endSlot(); ?>
                 <?php if (isset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5)): ?>
<?php $component = $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5; ?>
<?php unset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <?php if (isset($component)) { $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => 'card-yellow','collapseCard' => 'collapsed-card','title' => 'Finished Project','collapseButton' => 'plus','tableId' => '_finished']); ?>
<?php $component->withName('data-table.default-data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                     <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>Finish Date</th>
                    <th>Responsible</th>
                    <th>MileStone</th>
                    <th>Action</th>
                     <?php $__env->slot('othertable'); ?> 
                     <?php $__env->endSlot(); ?>
                 <?php if (isset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5)): ?>
<?php $component = $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5; ?>
<?php unset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            </div>
        </div>
    </div>

    <?php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน project.pdf').'">การใช้งาน Project</a>',null]
        ];
    ?>
     <?php if (isset($component)) { $__componentOriginal87db5dc623afe3cb526bd1b01866198119a4bf9e = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Content\Manual::class, ['tableData' => $tabledata]); ?>
<?php $component->withName('content.manual'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal87db5dc623afe3cb526bd1b01866198119a4bf9e)): ?>
<?php $component = $__componentOriginal87db5dc623afe3cb526bd1b01866198119a4bf9e; ?>
<?php unset($__componentOriginal87db5dc623afe3cb526bd1b01866198119a4bf9e); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\InputForm::class, ['nameID' => '','modalTitle' => 'Create Project']); ?>
<?php $component->withName('modal.input-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php
            $config = ['format' => 'YYYY-MM-DD'];
        ?>
         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'ProjectName','label' => 'Project Name','disableFeedback' => true]); ?>
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
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Select2::class, ['name' => 'project_type_id','label' => 'Project Type']); ?>
<?php $component->withName('adminlte-select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-placeholder' => 'Select an option...']); ?>
            <option/>
            <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value->id); ?>"><?php echo e($value->TypeName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php if (isset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435)): ?>
<?php $component = $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435; ?>
<?php unset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\InputDate::class, ['name' => 'StartDate','label' => 'Start Date','config' => $config]); ?>
<?php $component->withName('adminlte-input-date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Choose a date...']); ?>
             <?php $__env->slot('appendSlot'); ?> 
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
             <?php $__env->endSlot(); ?>
         <?php if (isset($__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67)): ?>
<?php $component = $__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67; ?>
<?php unset($__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\InputDate::class, ['name' => 'FinishDate','label' => 'Finish Date','config' => $config]); ?>
<?php $component->withName('adminlte-input-date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'Choose a date...']); ?>
             <?php $__env->slot('appendSlot'); ?> 
                <div class="input-group-text bg-gradient-danger">
                    <i class="fas fa-calendar-alt"></i>
                </div>
             <?php $__env->endSlot(); ?>
         <?php if (isset($__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67)): ?>
<?php $component = $__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67; ?>
<?php unset($__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Select2::class, ['name' => 'SiteEngineer','label' => 'ผู้รับผิดชอบ1/Planner/Site Engineer']); ?>
<?php $component->withName('adminlte-select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-placeholder' => 'Select an option...']); ?>
            <option/>
            <?php $__currentLoopData = $siteengineer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value->id); ?>"><?php echo e($value->ThaiName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php if (isset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435)): ?>
<?php $component = $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435; ?>
<?php unset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Select2::class, ['name' => 'AreaManager','label' => 'ผู้รับผิดชอบ2/Area Manager/ผู้ควบคุมงาน']); ?>
<?php $component->withName('adminlte-select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-placeholder' => 'Select an option...']); ?>
            <option/>
            <?php $__currentLoopData = $areamanager; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value->id); ?>"><?php echo e($value->ThaiName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php if (isset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435)): ?>
<?php $component = $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435; ?>
<?php unset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Supervisor','label' => 'จำนวนประมาณการการใช้ Supervisor']); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'number','type' => 'number']); ?>
             <?php $__env->slot('appendSlot'); ?> 
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
             <?php $__env->endSlot(); ?>
         <?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Foreman','label' => 'จำนวนประมาณการการใช้ Foreman']); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'number','type' => 'number']); ?>
             <?php $__env->slot('appendSlot'); ?> 
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
             <?php $__env->endSlot(); ?>
         <?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Skill','label' => 'จำนวนประมาณการการใช้ Skill']); ?>
<?php $component->withName('adminlte-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['placeholder' => 'number','type' => 'number']); ?>
             <?php $__env->slot('appendSlot'); ?> 
                <div class="input-group-text bg-dark">
                    <i class="fas fa-hashtag"></i>
                </div>
             <?php $__env->endSlot(); ?>
         <?php if (isset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff)): ?>
<?php $component = $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff; ?>
<?php unset($__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Select2::class, ['name' => 'Status','label' => 'Status']); ?>
<?php $component->withName('adminlte-select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-placeholder' => 'Select an option...']); ?>
            <option/>
            <option>Not Confirmed</option>
            <option>Confirmed</option>
         <?php if (isset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435)): ?>
<?php $component = $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435; ?>
<?php unset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Select2::class, ['name' => 'show','label' => 'Show On Calendar']); ?>
<?php $component->withName('adminlte-select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-placeholder' => 'Select an option...']); ?>
            <option/>
            <option>Yes</option>
            <option>No</option>
         <?php if (isset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435)): ?>
<?php $component = $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435; ?>
<?php unset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'DailyReport','label' => 'Daily Report Link','disableFeedback' => true]); ?>
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

         <?php $__env->slot('othervalue'); ?>  <?php $__env->endSlot(); ?>
     <?php if (isset($__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa)): ?>
<?php $component = $__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa; ?>
<?php unset($__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\InputForm::class, ['nameID' => 'keydate','modalTitle' => 'Key Date']); ?>
<?php $component->withName('modal.input-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php if (isset($component)) { $__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\InputFile::class, ['name' => 'KeyDate','label' => 'Select Key Date File for Upload','igroupSize' => '','placeholder' => 'Choose a file...']); ?>
<?php $component->withName('adminlte-input-file'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
             <?php $__env->slot('prependSlot'); ?> 
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
             <?php $__env->endSlot(); ?>
         <?php if (isset($__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70)): ?>
<?php $component = $__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70; ?>
<?php unset($__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php $__env->slot('othervalue'); ?>  <?php $__env->endSlot(); ?>
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

    <div id="formModal_keydate" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result_keydate"></span>
                    <form method="post" id="create_form_keydate" class="form-horizontal" enctype="multipart/form-data" action="javascript:void(0)">
                        <?php echo csrf_field(); ?>

                         <?php if (isset($component)) { $__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\InputFile::class, ['name' => 'select_file','label' => 'Select File for Upload','igroupSize' => '','placeholder' => 'Choose a file...']); ?>
<?php $component->withName('adminlte-input-file'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                             <?php $__env->slot('prependSlot'); ?> 
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                             <?php $__env->endSlot(); ?>
                         <?php if (isset($__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70)): ?>
<?php $component = $__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70; ?>
<?php unset($__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        <input type="hidden" name="action_keydate" id="action_keydate" value="Upload" />
                        <input type="submit" name="action_button_keydate" id="action_button_keydate" class="btn btn-success" value="Upload" />
                        <input type="hidden" name="project_id" id="project_id"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal_keydate" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Confirmation</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button_keydate" id="ok_button_keydate" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function(){

            var calendar = $('#calendar').fullCalendar({
                /* schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source', */
                schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,timeline'
                },
                events:"<?php echo e(url('/project_calendars')); ?>"
            });

             <?php if (isset($component)) { $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTableScript::class, ['tableName' => '_inprogress','ajaxUrl' => ''.e(url('/projects/inprogress')).'']); ?>
<?php $component->withName('data-table.data-table-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'ProjectName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'TypeName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'StartDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'FinishDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Responsible']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'DailyReport']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'KeyDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'MileStone']); ?>
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
                 <?php $__env->slot('order'); ?> [2,'asc'] <?php $__env->endSlot(); ?>
             <?php if (isset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5)): ?>
<?php $component = $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5; ?>
<?php unset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

             <?php if (isset($component)) { $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTableScript::class, ['tableName' => '_notconfirmed','ajaxUrl' => ''.e(url('/projects')).'']); ?>
<?php $component->withName('data-table.data-table-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'ProjectName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'TypeName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'StartDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'FinishDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Responsible']); ?>
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
                 <?php $__env->slot('order'); ?> [2,'asc'] <?php $__env->endSlot(); ?>
             <?php if (isset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5)): ?>
<?php $component = $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5; ?>
<?php unset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

             <?php if (isset($component)) { $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTableScript::class, ['tableName' => '_preparing','ajaxUrl' => ''.e(url('/projects/prepare')).'']); ?>
<?php $component->withName('data-table.data-table-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'ProjectName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'TypeName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'StartDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'FinishDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Responsible']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'KeyDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'MileStone']); ?>
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
                 <?php $__env->slot('order'); ?> [2,'asc'] <?php $__env->endSlot(); ?>
             <?php if (isset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5)): ?>
<?php $component = $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5; ?>
<?php unset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

             <?php if (isset($component)) { $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTableScript::class, ['tableName' => '_finished','ajaxUrl' => ''.e(url('/projects/finish')).'']); ?>
<?php $component->withName('data-table.data-table-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'ProjectName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'TypeName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'StartDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'FinishDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Responsible']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'MileStone']); ?>
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
                 <?php $__env->slot('order'); ?> [3,'desc'] <?php $__env->endSlot(); ?>
             <?php if (isset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5)): ?>
<?php $component = $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5; ?>
<?php unset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

             <?php if (isset($component)) { $__componentOriginalb53487e2c7816706a08ad720a59c4d3afb5ccbe6 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\CreateScript::class, ['nameID' => '','title' => 'Project']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\SubmitScript::class, ['nameID' => '','actionUrl' => 'projects']); ?>
<?php $component->withName('data-table.submit-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => 'notconfirmed']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => 'preparing']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => 'inprogress']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => 'finished']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditScript::class, ['editName' => '','editUrl' => 'projects']); ?>
<?php $component->withName('data-table.edit-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal29fc1eba46b477c43acc345b92cdc726cbaadaf0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'ProjectName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'project_type_id']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'StartDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'FinishDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'SiteEngineer']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'AreaManager']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'Supervisor']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'Foreman']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'Skill']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'Status']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'show']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\EditValueScript::class, ['name' => 'DailyReport']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DeleteScript::class, ['deleteName' => '','url' => ''.e(url('/projects')).'']); ?>
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

            $(document).on('click','.keydate', function(){
                var project_id = $(this).attr('id');
                $('#create_form_keydate')[0].reset();
                $('#form_result_keydate').html('');
                $('#formModal_keydate').modal('show');
                console.log(project_id);
                $('#project_id').val(project_id);
            });

            $('#create_form_keydate').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action_url_keydate = '';

                if($('#action_keydate').val() == 'Upload')
                {
                    action_url_keydate = "<?php echo e(url('/upload_keydate')); ?>";
                }

                if($('#action_keydate').val() == 'Edit')
                {
                    action_url_keydate = "<?php echo e(url('/upload_keydate/update')); ?>";
                }

                $.ajax({
                    type:'POST',
                    url: action_url_keydate,
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        var html_keydate = '';
                        if(data.errors)
                        {
                            html_keydate = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html_keydate += '<p>' + data.errors[count] + '</p>';
                            }
                            html_keydate += '</div>';
                            $('#create_form_keydate')[0].reset();
                        }
                        if(data.failures)
                        {
                            console.log('failures');

                            html_keydate = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.failures.length; count++)
                            {
                                html_keydate += '<p> Row:' + data.failures[count].row +
                                ' ' + data.failures[count].errors + '</p>';
                            }
                            html_keydate += '</div>';
                            $('#create_form_keydate')[0].reset();
                            $('#data_table_inprogress').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html_keydate = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form_keydate')[0].reset();
                            $('#data_table_inprogress').DataTable().ajax.reload();
                            $('#data_table_preparing').DataTable().ajax.reload();
                        }
                        $('#form_result_keydate').html(html_keydate);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

            $(document).on('click','.edit_keydate', function(){
                var uploadid = $(this).attr('id');
                $('#form_result_keydate').html('');
                $('#project_id').val(uploadid);
                $('#action_button_keydate').val('Edit');
                $('#action_keydate').val('Edit');
                $('#formModal_keydate').modal('show');
                console.log(uploadid);
            });

            var user_id_keydate;

            $(document).on('click', '.delete_keydate', function(){
                user_id_keydate = $(this).attr('id');
                $('.modal-title').text('Confirmation');
                $('#ok_button_keydate').text('Delete');
                $('#confirmModal_keydate').modal('show');
                console.log(user_id_keydate);
            });

            $('#ok_button_keydate').click(function(){
                $.ajax({
                    url:"<?php echo e(url('/upload_keydate/destroy')); ?>/" + user_id_keydate,
                    beforeSend:function(){
                        $('#ok_button_keydate').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal_keydate').modal('hide');
                            alert('Data Deleted');
                            location.reload();
                        }, 2000);
                    }
                })
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/projects/index.blade.php ENDPATH**/ ?>