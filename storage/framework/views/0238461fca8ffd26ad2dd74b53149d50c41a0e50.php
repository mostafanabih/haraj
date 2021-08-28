<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <div class="col-sm-12">
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

        <div class="col-sm-12 bg-color-silver">
            <h3>&raquo; <a href="<?php echo e(url('/')); ?>" style="color: #000">الرئيسية</a> / <a href="<?php echo e(url('/reset_password')); ?>" style="color: #000">إدخال كلمة مرور جديدة</a></h3>
        </div>
        <div class="col-sm-12"><br></div>

        <!-- start of content -->
        <div class="col-sm-12 bg-color-silver">
            <div class="col-sm-8 col-sm-offset-2 text-center">
                <h2 class="p-5">
                    برجاء إدخال كود استرجاع كلمة المرور وكلمة المرور الجديدة
        </h2>
                <form action="<?php echo e(url('/get_reset_password')); ?>" method="post">
                    <?php echo e(method_field('PUT')); ?>

                    <?php echo csrf_field(); ?>
                    <input class="form-control" type="text" name="code" placeholder="أدخل كود استرجلع كلمة المرور" required>
                    <br>
                    <input class="form-control" type="password" name="pass" placeholder="ادخل كلمة المرور" required>
                    <br>
                    <input class="form-control" type="password" name="pass_confirmation" placeholder="تأكيد كلمة المرور" required>
                    <br>

                    <input type="hidden" name="advertiser_id" value="<?php echo e(session('forget_id')); ?>">
                    <button type="submit" class="btn btn-green"><span style="font-size: x-large">تحديث كلمة المرور</span></button>

                    <a href="<?php echo e(url('/forget_password')); ?>" style="color: black; float: left;" >ليس لديك كود استرجاع كلمة المرور</a>

                </form>
            </div>
            <div class="col-sm-12"><br></div>
        </div>
        <!-- end of content -->
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>