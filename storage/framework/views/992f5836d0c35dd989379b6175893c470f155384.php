

<?php $__env->startSection('title','Tool'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark">PM Tool</h1>
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
                    <div class="form-group">
                        <label>PM Plan</label>
                        <form class="form-horizontal" method="POST" action="<?php echo e(url('/tool_pm_plan')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row">
                                        <label class="control-label" >Year</label> <!-- -->
                                        <div class="col">
                                            <input type="text" class="form-control" name="year" id="year">
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\DefaultDataTable::class, ['color' => '','collapseCard' => '','title' => 'PM Tool','collapseButton' => 'minus','tableId' => '']); ?>
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
        <th>Activity</th>
        <th>Lastest PM Date</th>
        <th>Next PM Date</th>
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
                                <th>PM Date</th>
                                <th>หน่วยงาน / ผู้ดำเนินการ</th>
                                <th>ค่าใช้จ่าย</th>
                                <th>ผลการดำเนินการ</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody id="bodyData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="formModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4> <!-- -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result2"></span>
                    <form method="post" id="update_form" class="form-horizontal">
                        <?php echo csrf_field(); ?>

                         <?php if (isset($component)) { $__componentOriginal13fd1c3f629e2052ad9f622b945be51001fe716c = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Date::class, ['title' => 'PM Date','nameId' => 'PMDate']); ?>
<?php $component->withName('input.date'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal13fd1c3f629e2052ad9f622b945be51001fe716c)): ?>
<?php $component = $__componentOriginal13fd1c3f629e2052ad9f622b945be51001fe716c; ?>
<?php unset($__componentOriginal13fd1c3f629e2052ad9f622b945be51001fe716c); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                         <?php if (isset($component)) { $__componentOriginalb315ec937ed627cf93c2fa6ea77e995d58919b1a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Text::class, ['title' => 'หน่วยงาน / ผู้ดำเนินการ','nameId' => 'Operator']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\Input\Text::class, ['title' => 'ค่าใช้จ่าย','nameId' => 'Cost']); ?>
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

                         <?php if (isset($component)) { $__componentOriginala333468cfb7bc2b6ed03464a1a46d6fc5eb9ab65 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\TextArea::class, ['title' => 'ผลการดำเนินการ','nameId' => 'Result']); ?>
<?php $component->withName('input.text-area'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginala333468cfb7bc2b6ed03464a1a46d6fc5eb9ab65)): ?>
<?php $component = $__componentOriginala333468cfb7bc2b6ed03464a1a46d6fc5eb9ab65; ?>
<?php unset($__componentOriginala333468cfb7bc2b6ed03464a1a46d6fc5eb9ab65); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                         <?php if (isset($component)) { $__componentOriginala333468cfb7bc2b6ed03464a1a46d6fc5eb9ab65 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Input\TextArea::class, ['title' => 'Remark','nameId' => 'Remark']); ?>
<?php $component->withName('input.text-area'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginala333468cfb7bc2b6ed03464a1a46d6fc5eb9ab65)): ?>
<?php $component = $__componentOriginala333468cfb7bc2b6ed03464a1a46d6fc5eb9ab65; ?>
<?php unset($__componentOriginala333468cfb7bc2b6ed03464a1a46d6fc5eb9ab65); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

                        <div class="form-group text-center">
                            <input type="hidden" name="action2" id="action2" value="Update History" />
                            <input type="hidden" name="update_id" id="update_id" />
                            <input type="submit" name="action_button2" id="action_button2" class="btn btn-success" value="Update History" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function(){

            function nl2br (str, replaceMode, isXhtml) {
                var breakTag = (isXhtml) ? '<br />' : '<br>';
                var replaceStr = (replaceMode) ? '$1'+ breakTag : '$1'+ breakTag +'$2';
                return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
            }

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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'Activity']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'PMDate']); ?>
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
<?php $component = $__env->getContainer()->make(App\View\Components\DataTable\ColumnScript::class, ['columnName' => 'NextPM']); ?>
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
                    url :"/tool_PMs/"+show_id,
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
                            bodyData+="<td class='text-center'>"+row.PMDate+"</td>";
                            bodyData+="<td class='text-center'>"+row.Operator+"</td>";
                            bodyData+="<td class='text-center'>"+row.Cost+"</td>";
                            bodyData+="<td>"+nl2br(row.Result)+"</td>";
                            if ( row.Remark !== null ) {
                                bodyData+="<td>"+nl2br(row.Remark)+"</td>";
                            } else {
                                bodyData+="<td></td>";
                            }
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
                $('#update_form')[0].reset();
                $('.modal-title').text('Update History');
                $('#update_id').val(update_id);
                $('#action_button2').val('Update');
                $('#action2').val('Update');
                $('#form_result2').html('');
                $('#formModal2').modal('show');
            });

            $('#update_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url: "/tool_PMs",
                    method:"POST",
                    data:$(this).serialize(),
                    dataType:"json",
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
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('.select2-bootstrap4').val(null).trigger('change');
                            $('#update_form')[0].reset();
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
                        }
                        $('#form_result2').html(html);
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/tools/PM.blade.php ENDPATH**/ ?>