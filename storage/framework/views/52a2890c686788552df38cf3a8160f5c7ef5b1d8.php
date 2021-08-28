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
            <h3 class="color-silver-darker"><a href="<?php echo e(url('/home')); ?>"  class="color-silver-darker">حسابى</a> / <a href="<?php echo e(url('/favourite')); ?>" class="color-black">المفضلة</a></h3>
        </div>



        <div class="col-xs-12 bg-color-silver p-3 mt-2">
            <!--result units-->
            <div class="col-xs-12 no-padding-x">
                <?php if(count($favourite) > 0): ?>
                <?php $__currentLoopData = $favourite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--unit-->
                <a style="color: #000" href="<?php echo e(url('/adv/'.$fav->adv_id)); ?>">
                    <div class="<?php if(session('display') == 'tiles'): ?> col-sm-6 <?php endif; ?> my-3 bg-color-white py-2 overflow-hidden my_div2_">
                        <div class="col-xs-9">
                            <div class="col-xs-11">
                                <h4 class="string_limit2 color-gold"><?php echo e(\App\Http\Controllers\AdvsController::get_adv($fav->adv_id)->title); ?></h4>
                            </div>
                            <div class="col-xs-1 pull-left">
                                <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="<?php echo e(url('/favourite/'.$fav->id)); ?>" method="post">
                                    <?php echo e(method_field('DELETE')); ?>

                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn transparent_btn color-gold"><i class="fa fa-trash-o fa-2x"></i></button>
                                </form>
                            </div>
                            <div class="clearfix border-bottom"></div>

                            <div>
                                <div class="col-xs-6 small_font">
                                    <div class="pt-3">
                                        <p><?php echo e(\App\Http\Controllers\AdvsController::get_adv_ratings($fav->adv_id).' ردود '); ?></p>
                                        <p class="pt-2"><i class="fa fa-map-marker"></i> <?php echo e(\App\Http\Controllers\AdvsController::get_adv($fav->adv_id)->City->name); ?></p>
                                    </div>
                                </div>
                                <div class="col-xs-6 small_font">
                                    <div class="pull-left pt-3">
                                        <p><i class="fa fa-clock-o"></i>
                                            <small><?php echo e(App\Http\Controllers\AdvsController::calc_duration(\App\Http\Controllers\AdvsController::get_adv($fav->adv_id)->created_at)); ?></small>
                                        </p>
                                        <p>#<?php echo e($fav->adv_id); ?></p>
                                        
                                            
                                                
                                            
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-3">
                            <img alt="favourite adv image" class="adv_height img-responsive img-rounded" src="<?php if(is_null(\App\Http\Controllers\AdvsController::get_adv_img($fav->adv_id))): ?> <?php echo e(asset('public/img/no_img.png')); ?> <?php else: ?> <?php echo e(asset(\App\Http\Controllers\AdvsController::get_adv_img($fav->adv_id)->img)); ?> <?php endif; ?>">
                        </div>
                    </div>
                </a>
                <!--end unit-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                        <h2>لا توجد إعلانات متاحة حتى الأن ...</h2>
                    </div>
                    <?php endif; ?>

                            <!--Pagination -->
                    <div class="col-sm-12 text-center">
                        <?php echo e($favourite->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

                    </div>
                    <!--End Pagination-->

            </div>
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