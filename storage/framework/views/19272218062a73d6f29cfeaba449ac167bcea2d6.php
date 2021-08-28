<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container my-4">
    <div class="row">
        <!-- start of content -->
        <div class="col-xs-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a> / <a href="<?php echo e(url('/page/'.$page->id)); ?>" class="color-black"><?php echo e($page->title); ?></a></h3>
        </div>

        <div class="col-xs-12 bg-color-silver mt-3 p-3">
            <div class="col-xs-12">
                <div class="col-md-12 col-xs-12 bg-color-orange color-light-blue text-center">
                    <h2><?php echo e($page->title); ?></h2>
                </div>
                <div class="col-md-12 col-xs-12 bg-color-white pt-5 pb-5">
                    <?php echo $page->content; ?>

                </div>
            </div>
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