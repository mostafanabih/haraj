<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <div class="col-xs-12">
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
        <div class="col-xs-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a> / <a href="<?php echo e(url('/messages')); ?>" class="color-black">الرسائل</a> / <a href="<?php echo e(url('/advertiser/'.$main_msg->from_id)); ?>" class="color-black"><?php echo e($main_msg->FromAdvertiser->name); ?></a></h3>
        </div>
        
            
            
        

        <div class="clearfix"></div>
        <div class="col-xs-12 bg-color-silver mt-5 p-3">
            <div class="border-all bg-color-silver p-3">
                <h4><?php echo e($main_msg->FromAdvertiser->name); ?></h4>
            </div>
            <div class="border-all bg-color-white p-3">
                <?php $__currentLoopData = $msgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="<?php if($msg->from_id != auth()->id()): ?> bg-color-shemez col-md-4 <?php else: ?> bg-color-silver-lighter col-md-4 col-md-push-8 <?php endif; ?> col-xs-12 border-all border-r-10 m-1">
                        <h4><?php echo e($msg->msg); ?></h4>
                        <h6 class="color-silver-darker"><?php echo e(\Carbon\Carbon::parse($msg->created_at)->diffForHumans()); ?></h6>
                    </div>
                    <div class="clearfix"></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                    
                        
                        
                    
                    
                

                <div class="clearfix pt-3"></div>
                <form action="<?php echo e(route('contact_me')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <textarea name="msg" class="form-control col-xs-11" placeholder="اكتب هنا نص الرسالة"></textarea>
                    <input type="hidden" name="from_id" value="<?php echo e(auth()->id()); ?>">
                    <?php if($main_msg->from_id == auth()->id()): ?>
                        <input type="hidden" name="to_id" value="<?php echo e($main_msg->to_id); ?>">
                        <?php else: ?>
                        <input type="hidden" name="to_id" value="<?php echo e($main_msg->from_id); ?>">
                    <?php endif; ?>
                    <input type="hidden" name="parent_id" value="<?php echo e($main_msg->id); ?>">

                    <button type="submit" class="transparent_btn color-gold btn btn-block col-xs-1">
                        <i class="fa fa-send-o fa-lg pt-3"></i>
                    </button>
                    </form>
                <div class="clearfix"></div>
            </div>
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