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
            <h3 class="color-silver-darker"><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a> / <a href="<?php echo e(url('/AdvertiserNotifyController')); ?>" class="color-black">اشعارات</a></h3>
        </div>

        
            
                
                    
                        
                            
                                
                                
                                
                            
                        
                    
                        
                            
                                
                                
                                
                            
                        
                    
                        
                            
                                
                                
                                
                            
                        
                    
                        
                            
                                
                                
                                
                            
                        
                    
                        
                            
                                
                                
                                
                            
                        
                    
                        
                            
                                
                                
                                
                            
                        
                    
                
            
                
            
        

        <div class="clearfix"></div>
        <div class="col-xs-12 bg-color-silver mt-5 p-3">
            <div class="border-all bg-color-white p-3">
                <?php if($notify->count() > 0): ?>
                    <?php $__currentLoopData = $notify; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(url('/AdvertiserNotifyController/'.$n->id)); ?>">
                            <div class="bg-color-silver-lighter <?php if($n->reading == 1): ?> color-silver-darker <?php else: ?> color-black <?php endif; ?> mb-3">
                                <div class="col-md-2 col-xs-3 bg-color-silver-darker text-center p-1">
                                    <?php if($n->reading == 1): ?>
                                        <i class="fa fa-bell-o fa-4x"></i>
                                    <?php else: ?>
                                        <i class="fa fa-bell-o color-gold fa-4x"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-10 col-xs-9">
                                    <h4><?php echo e($n->content); ?></h4>
                                    <h6>
                                        <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span><?php echo e(\Carbon\Carbon::parse($n->created_at)->format('Y-m-d')); ?></span>
                                        <i class="fa fa-clock-o pl-5"></i>&nbsp;&nbsp;<span><?php echo e(\Carbon\Carbon::parse($n->created_at)->format('h:i')); ?></span>
                                    </h6>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <div class="text-center"><h4>لا توجد إشعارات حتى الأن</h4></div>
                <?php endif; ?>
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