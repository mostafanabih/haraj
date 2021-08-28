
<!DOCTYPE html>
<html dir="rtl" lang="ar" prefix="og: http://ogp.me/ns#">
<head>
    <!-- Bootstrap -->
    <link href="<?php echo e(secure_asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(secure_asset('css/bootstrap.rtl.min.css')); ?>" rel="stylesheet">

    <!-- style -->
    <link href="<?php echo e(secure_asset('css/style.css')); ?>" rel="stylesheet">
</head>
<body>
    
<?php echo $__env->make('commission_data', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>window.jQuery || document.write('<script src="<?php echo e(secure_asset('js/jquery-1.11.2.min.js')); ?>">\x3C/script>')</script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo e(secure_asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(secure_asset('js/script.js')); ?>"></script>
</body>
</html>
