<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <!-- start of content -->
        <div class="col-sm-12">
            <h2>رؤية رسالة <span style="color: #ff0000"><?php echo e($contact_us->name); ?></span> :</h2>
            <hr>
        </div>

        <div class="col-sm-12">
            <h4><i class="fa fa-mobile"></i>&nbsp;&nbsp;<span><?php echo e($contact_us->mobile); ?></span></h4>
            <h4><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;<span><?php echo e($contact_us->e_mail); ?></span></h4>
            <h4><?php echo e(Carbon\Carbon::parse($contact_us->created_at)->format('Y-m-d >> h:i A')); ?></h4>
            
            <h3 class="text-justify"><?php echo e($contact_us->msg); ?></h3>
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
<?php echo $__env->make('layouts.dash-header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>