<?php $__env->startSection('content'); ?>
    <div class="container-fluid padding-r-l-50 " style="background: #F0F3F8;">

        <div class="col-sm-12" style="padding-top: 20px;">
            <a href="<?php echo e(url('/fixed_pages/'.$page->id.'/edit')); ?>" class="btn btn-info pull-left"><i class="fa fa-pencil"></i>&nbsp;&nbsp; تعديل</a>
        </div>
        <div class="col-sm-12"><h2>صفحة <span style="color: #ff0000"><?php echo e($page->title); ?></span> :</h2><hr></div>
        <div class="col-sm-12">
            <?php echo $page->content; ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script></script>
    </body>
    </html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>