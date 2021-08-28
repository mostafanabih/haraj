<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <?php if(session('error')): ?>
            <div class="flash alert alert-danger" align="center" role="alert"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        <?php if(session('success')): ?>
            <div class="flash alert alert-success" align="center" role="alert"><?php echo e(session('success')); ?></div>
        <?php endif; ?>


    </div>
    <!-- start of content -->
    <div class="col-md-12">
        <h2>البحث فى القائمة السوداء :</h2>
        <h4 style="color: gray">القائمة السوداء هي قائمة بإرقام حسابات وأرقام جوالات من يقومون بإساءة إستخدام الموقع
            لأغراض ممنوعه مثل الغش أو الأحتيال أو مخالفة قوانين الموقع</h4>
        <br>

        <?php if($advertiser == ''): ?>
        <?php else: ?>
            <?php if($advertiser == 'error'): ?>
                <div class="alert alert-info text-center">
                    <h2>رقم الهاتف أو البريد الإلكترونى غير موجود فى القائمة السوداء</h2>
                </div>
            <?php else: ?>
                <?php if($advertiser == 'error2'): ?>
                    <div class="alert alert-info text-center">
                        <h2>رقم الهاتف أو البريد الإلكترونى غير موجود فى القائمة السوداء</h2>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger text-center">
                        <h2>يوجد لدينا هذا الشخص : <span><?php echo e($advertiser->name); ?></span></h2>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <form>
            <input class="form-control" name="search"
                   value="<?php if(request('search')): ?> <?php echo e(request('search')); ?> <?php endif; ?>"
                   type="text" placeholder="أدخل رقم الجوال أو البريد الإلكترونى ..." required>
            <button type="submit" class="btn btn-green" style="font-size: large; margin-top: 10px"><i
                        class="fa fa-search"></i>&nbsp;&nbsp;فحص
            </button>
        </form>
    </div>

    <!-- end of content -->
</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script type="text/javascript"></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>