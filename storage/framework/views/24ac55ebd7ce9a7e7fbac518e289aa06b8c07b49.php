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
        </div>


        <!-- start of content -->
        <div class="col-xs-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="<?php echo e(url('/home')); ?>" class="color-silver-darker">حسابى</a> / <a href="<?php echo e(url('/messages')); ?>" class="color-black">الرسائل</a></h3>
        </div>


        <div class="col-xs-12 bg-color-silver p-4 mt-4">
            <?php if(count($messages) > 0): ?>
                <?php for($i=0;$i<$messages->count();$i++): ?>
                    <div class="clearfix pt-5">
                        <div class="col-xs-12 border-all2 bg-color-silver">
                            <div class="col-md-9 col-xs-12">
                                <?php if($messages[$i]->from_id == auth()->id()): ?>
                                    <h4 class="string_limit2"><?php echo e($messages[$i]->ToAdvertiser->name); ?></h4>
                                    <?php else: ?>
                                    <h4 class="string_limit2"><?php echo e($messages[$i]->FromAdvertiser->name); ?></h4>
                                <?php endif; ?>
                                <h5><?php echo e(\Carbon\Carbon::parse($messages[$i]->created_at)->diffForHumans()); ?></h5>
                            </div>
                            <div class="col-md-3 col-xs-12 p-2">
                                <div class="col-xs-6">
                                    <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="<?php echo e(route('messages')); ?>" method="post">
                                        <?php echo e(method_field('DELETE')); ?>

                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="msg_id" value="<?php echo e($messages[$i]->id); ?>">
                                        <button type="submit" class="btn btn-danger btn-block">
                                            <i class="fa fa-trash"></i><span class="hidden-xs">&nbsp;&nbsp;حذف</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-xs-6">
                                    <a href="<?php echo e(url('/reply/'.$messages[$i]->id)); ?>" type="button" class="btn btn-success btn-block">
                                        <i class="fa fa-reply"></i><span class="hidden-xs">&nbsp;&nbsp;رد</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 border-all2 bg-color-white">
                            
                            <h5><?php echo e($messages[$i]->msg); ?></h5>
                        </div>
                    </div>
                <?php endfor; ?>
                <?php else: ?>
                <div class="col-xs-12 border-all bg-color-white text-center">
                    <h2>لا توجد رسائل متاحة حتى الأن ...</h2>
                </div>
            <?php endif; ?>

            <!--Pagination -->
            <div class="col-sm-12 text-center">
            <?php echo e($messages->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

            </div>
            <!--End Pagination-->

            <!--result units-->
            
                
                    
                        
                            
                            
                                
                                
                                
                                
                                
                                
                            
                            
                            
                            
                                
                                    
                                        
                                        
                                        
                                        
                                        
                                        
                                            
                                                
                                                
                                                
                                                
                                            
                                        
                                    
                                
                            
                                
                                    
                                        
                                    
                                
                            
                            
                        
                    
                

                
                    
                        
                    
                

            
            <!--end result units-->
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