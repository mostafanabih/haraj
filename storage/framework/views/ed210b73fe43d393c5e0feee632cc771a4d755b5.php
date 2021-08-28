<?php $__env->startSection('content'); ?>
    <div class="container-fluid padding-r-l-50 " style="background: #F0F3F8;">
        <div class="col-md-12 " style="margin-top: 10px;">
            <?php if(session('error')): ?>
                <div class="flash alert alert-danger" align="center" role="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php if(session('success')): ?>
                <div class="flash alert alert-success" align="center" role="alert"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="text-center alert alert-danger">
                    <ul class="list-unstyled">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-sm-12">
            <h2>تعديل صلاحيات المشرف <span style="color: #ff0000"><?php echo e($admin->name); ?></span> :</h2>
            <br>
        </div>
        <form action="<?php echo e(url('/permissions/'.$admin->id)); ?>" method="post" class="form-group">
            <?php echo e(method_field('PUT')); ?>

            <?php echo csrf_field(); ?>
            <?php if($permissions->count() > 0): ?>
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 col-xs-12">
                        <label><input type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>" <?php if(in_array($permission->id, $permission_role_)): ?> <?php echo e('checked'); ?> <?php else: ?> <?php echo e(''); ?> <?php endif; ?>>&nbsp;&nbsp;<?php echo e($permission->name); ?></label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <?php echo e('لا يوجد صلاحيات لإعطائها للمشرف'); ?>

            <?php endif; ?>

            <input type="hidden" name="admin_id" value="<?php echo e($admin->id); ?>">
            <div class="col-md-12 col-xs-12 clearfix"><br></div>
            <button type="submit" class="btn col-md-6 col-md-offset-3 btn-primary btn-block"><i class="fa fa-edit"></i>&nbsp;&nbsp;تعديل الصلاحيات</button>
        </form>
        <!-- end of content -->
        <div class="col-md-12 col-xs-12 clearfix"><br></div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>