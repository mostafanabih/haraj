<?php $__env->startSection('content'); ?>
    <!--End Header-->

   <?php echo $__env->make('commission_data', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
   
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>