    
<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container my-4">
    <div class="row">
        <div class="col-md-12 col-xs-12">
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


        <!-- start of content -->
        <div class="col-md-12 col-xs-12 bg-color-silver">
            <h3>&raquo; <a href="<?php echo e(url('/')); ?>" style="color: #000">الرئيسية</a> / <a href="<?php echo e(url('/followers')); ?>" style="color: #C7A34B">المتابعين</a></h3>
        </div>
        <div class="col-md-12 col-xs-12"><br></div>


        <div class="col-md-12 col-xs-12 bg-color-silver">
            
            <?php if($followers->count() > 0): ?>
                <?php $__currentLoopData = $followers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="col-md-3 col-xs-12">
                        <div class="special">

                            <a class="color-black" href="<?php echo e(url('/advertiser/'.$follower->advertiser->id)); ?>">
                                
                                
                                     
                                      
                                     
                                       
                                     
                                <h3 class="text-center bg-color-white">
                                    <?php echo e($follower->advertiser->name); ?>

                                </h3>
                                
                            </a>

                        </div>
                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <div class="col-xs-12 text-center">
                    <h3>لا يوجد متابعين حتى الأن ...</h3>
                </div>
            <?php endif; ?>
            
        </div>
        <div class="col-md-12 col-xs-12"><br></div>
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