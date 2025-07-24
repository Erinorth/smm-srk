<div id="formModal<?php echo e($nameID); ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo e($modalTitle); ?></h4> <!-- -->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_result<?php echo e($nameID); ?>"></span>
                <form method="post" id="create_form<?php echo e($nameID); ?>" class="form-horizontal">
                    <?php echo csrf_field(); ?>
                    <?php echo e($slot); ?>

                    <div class="form-group text-center">
                        <?php echo e($othervalue); ?>

                        <input type="hidden" name="action<?php echo e($nameID); ?>" id="action<?php echo e($nameID); ?>" value="Add" />
                        <input type="hidden" name="hidden_id<?php echo e($nameID); ?>" id="hidden_id<?php echo e($nameID); ?>" />
                        <input type="submit" name="action_button<?php echo e($nameID); ?>" id="action_button<?php echo e($nameID); ?>" class="btn btn-success" value="Add" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\smm-srk\storage\framework\views/52fd7cef64ecd4b1e4d10eb6b933da4e71cce89e.blade.php ENDPATH**/ ?>