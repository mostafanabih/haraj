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

        <div class="col-sm-12"><h2>تحويل العضو <span style="color: #ff0000"><?php echo e($advertiser->name); ?></span> لمشترك :</h2></div>
        <form action="<?php echo e(url('/advertisers')); ?>" method="post" class="form-group">
            <?php echo csrf_field(); ?>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>من :</label>
                    <input type="text" name="from" value="<?php echo e(date('Y-m-d')); ?>" class="form-control date" required>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>إلى :</label>
                    <input type="text" name="to" value="<?php echo e(date('Y-m-d', strtotime('+3 days'))); ?>" class="form-control date" required>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>

            <input type="hidden" name="advertiser_id" value="<?php echo e($advertiser->id); ?>">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>&nbsp;&nbsp;أضف</button>
        </form>
        <!-- end of content -->


    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>