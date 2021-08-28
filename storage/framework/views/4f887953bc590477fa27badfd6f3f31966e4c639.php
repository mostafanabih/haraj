<?php if(count($advs) > 0): ?>
<?php $__currentLoopData = $advs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!--unit-->
<a style="color: #000;" href="<?php echo e(url('/adv/'.$adv->id)); ?>">
    <div class="<?php if(session('display') == 'tiles'): ?> col-md-6 <?php endif; ?> mb-3 bg-color-white overflow-hidden my_div2">
        <div class="col-md-9 col-xs-9">
            <div class="col-xs-12">
                <?php
                $adv_title = $adv->title ?? '' ;
                ?>
                <h4 class="string_limit2 color-gold" title="<?php echo e($adv_title); ?>"><?php echo e($adv_title); ?></h4>
            </div>
            <div class="p-3">
                <div class="col-xs-6 small_font">
                    <div class="pt-3">
                        <?php
                        $adv_reply = \App\Http\Controllers\AdvsController::get_count_ratings($adv->id).' ردود ';

                        if($adv->city){
                            $adv_city = ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة';
                            $adv_area = ($adv->City) ? $adv->City->name : 'بدون مدينة' ;
                            $adv_city_area = $adv_area.' , '.$adv_city;
                        }else{
                            $adv_city_area = 'بدون عنوان';
                        }
                        ?>
                        <p title="<?php echo e($adv_reply); ?>"><?php echo e($adv_reply); ?></p>
                        <p title="<?php echo e($adv_city_area); ?>" class="string_limit pt-2"><i class="fa fa-map-marker"></i>
                            <?php echo e($adv_city_area); ?>

                        </p>
                    </div>
                </div>
                <div class="col-xs-6 small_font">
                    <div class="pull-left pt-3">
                        <?php
                        $adv_date = App\Http\Controllers\AdvsController::calc_duration($adv->created_at) ?? '' ;
                        ?>
                        <p title="<?php echo e($adv_date); ?>">
                            <i class="fa fa-clock-o"></i>
                            <small><?php echo e($adv_date); ?></small>
                        </p>
                        <a style="color: #000"
                           href="<?php echo e(url('/advertiser/'.$adv->advertiser_id)); ?>">
                            <p class="pt-2 string_limit" title="<?php echo e($adv->Advertiser->name ?? ''); ?>">
                                <?php if($adv->Advertiser->special == 1): ?>
                                    <img src="<?php echo e(asset('public/img/ustar.png')); ?>">
                                <?php else: ?>
                                    <i class="fa fa-user-o "></i>
                                <?php endif; ?>
                                <small><?php echo e($adv->Advertiser->name ?? ''); ?></small>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-3">
            <img alt="<?php echo e($adv->title ?? ''); ?>" class="adv_height img-responsive img-rounded"
                 src="<?php if(is_null(\App\Http\Controllers\AdvsController::get_small_img($adv->id))): ?> <?php echo e(asset('public/img/no_img.png')); ?> <?php else: ?> <?php echo e(asset(\App\Http\Controllers\AdvsController::get_small_img($adv->id))); ?> <?php endif; ?>">
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