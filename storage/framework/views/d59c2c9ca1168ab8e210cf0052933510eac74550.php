<div class="row">
    <div class="col-12">
        <div class="card <?php echo e($color); ?> <?php echo e($collapseCard); ?>">
            <div class="card-header">
                <h3 class="card-title"><?php echo e($title); ?></h3>
                <div class="card-tools">
                    <?php echo e($tool); ?>

                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-<?php echo e($collapseButton); ?>"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <table id="data_table<?php echo e($tableId); ?>" class="table table-bordered table-striped table-sm">
                    <thead>
                        <?php echo e($slot); ?>

                    </thead>
                </table>
                <?php echo e($othertable); ?>

            </div>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\smm-srk\storage\framework\views/f3213ee99d8eea9e8d6b501e10b8e6de83544d3d.blade.php ENDPATH**/ ?>