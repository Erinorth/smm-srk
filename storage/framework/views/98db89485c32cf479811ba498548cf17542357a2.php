

<?php $__env->startSection('title','Tool'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark">Tool Calibration</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
     <?php if (isset($component)) { $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Card\DefaultCard::class, ['color' => '','collapseCard' => 'collapsed-card','title' => 'Report','collapseButton' => 'plus']); ?>
<?php $component->withName('card.default-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?>  <?php $__env->endSlot(); ?>
        <div class="container">
            <div class="row align-items-center justify-content-around">
                <div class="col-xl text-center">
                    <a class="btn btn-primary btn-sm" href="<?php echo e(URL('tool_calibrate_list')); ?>">List</a>
                </div>
                <div class="col-xl text-center">
                    <div class="form-group">
                        <label>Calibrate Plan</label>
                        <form class="form-horizontal" method="POST" action="<?php echo e(url('/tool_calibrate_plan')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="control-label" >Year</label> <!-- -->
                                        <div class="col">
                                            <input type="text" class="form-control" name="year" id="year" placeholder="ใส่ปี ค.ศ. 4 หลัก">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-center">
                                    <button type="submit" class="btn btn-success btn-sm">Print</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
     <?php if (isset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188)): ?>
<?php $component = $__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188; ?>
<?php unset($__componentOriginal184b0fc1f0a6fadf19a7acb2d8d8057cb311f188); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => '','collapseCard' => '','title' => 'Tool Calibration','collapseButton' => 'minus','tableId' => '']); ?>
<?php $component->withName('data-table.default-data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?> 
         <?php $__env->endSlot(); ?>
        <th>Catagory Name</th>
        <th>Range/Capacity</th>
        <th>LocalCode</th>
        <th>Brand</th>
        <th>Model</th>
        <th>SerialNumber</th>
        <th>Calibrate Date</th>
        <th>Expire Date</th>
        <th>Remark</th>
        <th>Attachment</th>
        <th>Update</th>
         <?php $__env->slot('othertable'); ?> 
             <?php $__env->endSlot(); ?>
     <?php if (isset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5)): ?>
<?php $component = $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5; ?>
<?php unset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

     <?php if (isset($component)) { $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => '','collapseCard' => 'collapsed-card','title' => 'Tool Calibration ALL','collapseButton' => 'plus','tableId' => '_tool_calibrate_all']); ?>
<?php $component->withName('data-table.default-data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('tool'); ?> 
         <?php $__env->endSlot(); ?>
        <th>ID</th>
        <th>Catagory Name</th>
        <th>Range/Capacity</th>
        <th>LocalCode</th>
        <th>Brand</th>
        <th>Model</th>
        <th>SerialNumber</th>
        <th>Calibrate Date</th>
        <th>Calibrator</th>
        <th>Result</th>
        <th>Certificate</th>
        <th>Accuracy</th>
        <th>AcceptError</th>
        <th>Expire Date</th>
        <th>Cost</th>
        <th>Remark</th>
        <th>Responible</th>
        <th>Attachment</th>
        <th>Action</th>
         <?php $__env->slot('othertable'); ?> 
         <?php $__env->endSlot(); ?>
     <?php if (isset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5)): ?>
<?php $component = $__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5; ?>
<?php unset($__componentOriginalf588d3044e2a9c17fcec3bff64a20fdada801da5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">History</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Calibrate Date</th>
                                <th>Calibrator</th>
                                <th>Result</th>
                                <th>Certificate No.</th>
                                <th>Accuracy</th>
                                <th>AcceptError</th>
                                <th>Cost</th>
                                <th>Remark</th>
                                <th>Responsible</th>
                            </tr>
                        </thead>
                        <tbody id="bodyData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

     <?php if (isset($component)) { $__componentOriginal4a22373cae50a89717f83044ed72e2609a4705aa = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Modal\InputForm::class, ['nameID' => '_update','modalTitle' => 'Add New Certificate']); ?>
<?php $component->withName('modal.input-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php
            $config = ['format' => 'YYYY-MM-DD'];
        ?>

         <?php if (isset($component)) { $__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\InputDate::class, ['name' => 'CalibrateDate','label' => 'Calibrate Date','config' => $config]); ?>
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

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Calibrator','label' => 'หน่วยงานสอบเทียบ','disableFeedback' => true]); ?>
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
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Select2::class, ['name' => 'Result','label' => 'Result Type']); ?>
<?php $component->withName('adminlte-select2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['data-placeholder' => 'Select an option...']); ?>
            <option></option>
            <option>Pass</option>
            <option>Not Pass</option>
         <?php if (isset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435)): ?>
<?php $component = $__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435; ?>
<?php unset($__componentOriginal53d96464c02914da1a5e3f6d78f2486c25523435); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Certificate','label' => 'Certificate No.','disableFeedback' => true]); ?>
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
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Accuracy','label' => 'Accuracy','disableFeedback' => true]); ?>
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
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'AcceptError','label' => 'ค่าความผิดพลาดที่ยอมรับได้','disableFeedback' => true]); ?>
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

         <?php if (isset($component)) { $__componentOriginald7c390877edf76a116b904633f8a9a4c6dc98f67 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\InputDate::class, ['name' => 'ExpireDate','label' => 'Expire Date','config' => $config]); ?>
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

         <?php if (isset($component)) { $__componentOriginal7d1474369c7a69c75ad2fc0edfd903b7880af2ff = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Cost','label' => 'ค่าใช้จ่าย']); ?>
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
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\Input::class, ['name' => 'Remark','label' => 'Remark','disableFeedback' => true]); ?>
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

         <?php if (isset($component)) { $__componentOriginal779aa8a3778a44f627a67101ca73adb528b17c70 = $component; } ?>
<?php $component = $__env->getContainer()->make(JeroenNoten\LaravelAdminLte\View\Components\Form\InputFile::class, ['name' => 'Attachment','label' => 'Upload files (if pass)','igroupSize' => '','placeholder' => 'Choose a file...']); ?>
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

    <?php
        $tabledata = [
            ['<a href="'. url('storage/user_manual/การใช้งาน tool calibrate.pdf').'">การใช้งาน Tool Calibrate</a>',null]
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function(){

             <?php if (isset($component)) { $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTableScript::class, ['tableName' => '','ajaxUrl' => '']); ?>
<?php $component->withName('data-table.data-table-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                 <?php if (isset($component)) { $__componentOriginal6c45c96de75fea92f5ca669b23310c721765280b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'CatagoryName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'RangeCapacity']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'LocalCode']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Brand']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Model']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'SerialNumber']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'CalibrateDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'ExpireDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Remark']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Attachment2']); ?>
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
                 <?php $__env->slot('order'); ?> [7,'asc'] <?php $__env->endSlot(); ?>
             <?php if (isset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5)): ?>
<?php $component = $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5; ?>
<?php unset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

             <?php if (isset($component)) { $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DataTableScript::class, ['tableName' => '_tool_calibrate_all','ajaxUrl' => 'tool_calibrates_all']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'CatagoryName']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'RangeCapacity']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'LocalCode']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Brand']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Model']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'SerialNumber']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'CalibrateDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Calibrator']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Result']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Certificate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Accuracy']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'AcceptError']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'ExpireDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Cost']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Remark']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Attachment3']); ?>
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
                 <?php $__env->slot('order'); ?> [0,'desc'] <?php $__env->endSlot(); ?>
             <?php if (isset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5)): ?>
<?php $component = $__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5; ?>
<?php unset($__componentOriginal6ca25e5ed2cd38686b29659e72fca2c7f2667ae5); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

            var show_id;

            $(document).on('click', '.history', function(){
                var show_id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"/tool_calibrates/"+show_id,
                    data:{
                        _token:'<?php echo e(csrf_token()); ?>'
                    },
                    cache: false,
                    dataType:"json",
                    success:function(dataResult)
                    {
                        console.log(dataResult);
                        var resultData = dataResult.data;
                        var bodyData = '';
                        function appendLeadingZeroes(n){
                            if(n <= 9){
                                return "0" + n;
                            }
                            return n
                        }
                        $.each(resultData,function(index,row){
                            let datetime = new Date(row.created_at)
                            let formatted_date = datetime.getFullYear() + "-" + appendLeadingZeroes(datetime.getMonth() + 1) + "-" + appendLeadingZeroes(datetime.getDate()) + " " + appendLeadingZeroes(datetime.getHours()) + ":" + appendLeadingZeroes(datetime.getMinutes()) + ":" + appendLeadingZeroes(datetime.getSeconds())
                            //console.log(formatted_date)
                            bodyData+="<tr>";
                            bodyData+="<td class='text-center'>"+row.CalibrateDate+"</td>";
                            bodyData+="<td class='text-center'>"+row.Calibrator+"</td>";
                            bodyData+="<td class='text-center'>"+row.Result+"</td>";
                            bodyData+="<td class='text-center'>"+row.Certificate+"</td>";
                            bodyData+="<td class='text-center'>"+row.Accuracy+"</td>";
                            bodyData+="<td class='text-center'>"+row.AcceptError+"</td>";
                            bodyData+="<td class='text-center'>"+row.Cost+"</td>";
                            if ( row.Remark !== null ) {
                                bodyData+="<td>"+row.Remark+"</td>";
                            } else {
                                bodyData+="<td></td>";
                            }
                            bodyData+="<td class='text-center'>"+row.Responsible+"</td>";
                            bodyData+="</tr>";
                        })
                        $('#bodyData').html(bodyData);
                        $('#formModal').modal('show');
                        bodyData = null;
                    }
                })
            });

            var update_id;

            $(document).on('click', '.update', function(){
                var update_id = $(this).attr('id');
                $('.select2-bootstrap4').val(null).trigger('change');
                $('#create_form_update')[0].reset();
                $('.modal-title').text('Update History');
                $('#hidden_id_update').val(update_id);
                $('#action_button_update').val('Update');
                $('#action_update').val('Update');
                $('#form_result_update').html('');
                $('#formModal_update').modal('show');
                console.log(update_id);
            });

            $('#create_form_update').on('submit', function(event){
                event.preventDefault();
                var formData = new FormData(this);
                var action_url = "/tool_calibrates";

                $.ajax({
                    type:'POST',
                    url: action_url,
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#create_form_update')[0].reset();
                        }
                        if(data.failures)
                        {
                            console.log('failures');

                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.failures.length; count++)
                            {
                                html += '<p> Row:' + data.failures[count].row +
                                ' ' + data.failures[count].errors + '</p>';
                            }
                            html += '</div>';
                            $('#create_form_update')[0].reset();
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
                             <?php if (isset($component)) { $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => '_tool_calibrate_all']); ?>
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
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#create_form_update')[0].reset();
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
                             <?php if (isset($component)) { $__componentOriginal5bbdb9bbe2c68759b1da4115ab99914b3f0589b5 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\AjaxReloadScript::class, ['tableId' => '_tool_calibrate_all']); ?>
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
                        }
                        $('#form_result_update').html(html);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });
            });

             <?php if (isset($component)) { $__componentOriginal54287947bfea0fef77130bade56aaba586af47cc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DeleteScript::class, ['deleteName' => '','url' => 'tool_calibrates']); ?>
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
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/tools/calibrate.blade.php ENDPATH**/ ?>