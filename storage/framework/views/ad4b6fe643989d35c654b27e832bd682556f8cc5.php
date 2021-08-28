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
        <div class="col-sm-9"></div>
        <div class="col-sm-3">
            <a class="btn btn-green btn-block pull-left" href="<?php echo e(url('/favourite')); ?>" style="font-size: x-large"><i class="fa fa-heart"></i>&nbsp;&nbsp;إعلاناتى المفضلة</a>
        </div>
        <div class="col-sm-12"><br></div>

        <div class="col-xs-12 bg-color-silver">
            <h3>&raquo; <a href="<?php echo e(url('/home')); ?>" style="color: #000">حسابى</a> / <a href="<?php echo e(route('show_favourite_advertiser')); ?>" style="color: #000">المعلنين المفضلين</a></h3>
        </div>



        <div class="col-xs-12 bg-color-silver p-3 mt-4 ">
            <!--result units-->
                <?php if(count($favourite) > 0): ?>
                <?php $__currentLoopData = $favourite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--unit-->
                    <div class="col-md-4 no-padding-x">
                        <div class="col-md-1"></div>
                        <a target="_blank" style="color: #000" href="<?php echo e(url('/advertiser/'.$fav->favourite_advertiser)); ?>">
                        <div style="background-color: #65B76D" class="col-md-11">
                            <div class="col-md-12 text-center bg-color-white" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px">
                                <h1><?php echo e(\App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->name); ?></h1>
                            </div>
                            
                                
                            
                            
                                
                            
                            
                                
                                
                                    
                                        
                                    
                                    
                                        
                                    
                                    
                                        
                                    
                                    
                                        
                                    
                                    
                                        
                                    
                                
                            

                            <div class="col-md-12 pt-5">
                                <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="<?php echo e(route('delete_favourite_advertiser')); ?>" method="post">
                                    <?php echo e(method_field('DELETE')); ?>

                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="fav_id" value="<?php echo e($fav->id); ?>">
                                    <button type="submit" class="btn btn-danger btn-block" style="font-size: large"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                </form>
                            </div>
                        </div>
                            <div class="col-md-12"><br></div>
                        </a>
                    </div>
                <!--end unit-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                        <h2>لا يوجد معلنين حتى الأن ...</h2>
                    </div>
                    <?php endif; ?>

                            <!--Pagination -->
                    <div class="col-sm-12 text-center">
                        <?php echo e($favourite->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

                    </div>
                    <!--End Pagination-->
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