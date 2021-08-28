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
        <div class="col-xs-12 bg-color-silver">
            <h3>&raquo; <a href="<?php echo e(url('/home')); ?>" style="color: #000">حسابى</a> / <a
                        href="<?php echo e(url('/add_subscription')); ?>" style="color: #000">اشتراك بالموقع</a></h3>
        </div>


        <div class="col-xs-12 bg-color-silver p-3 mt-4 ">
            <!--result units-->
            <div class="col-xs-12 no-padding-x">
                <div class="col-md-12">
                    <?php if($subscription && $subscription->package): ?>
                        <?php if($subscription->start_date == null or $subscription->end_date == null): ?>
                            <div class="alert alert-info text-center">
                                <h3>باقتك <span style="color: #ff0000"><?php echo e($subscription->package->name); ?></span> تحت
                                    المراجعة للموافقة عليها</h3>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success text-center">
                                <h3>انت الأن على باقة <span
                                            style="color: #ff0000"><?php if($subscription->package_id == 0): ?> <?php echo e('الباقة التجريبية'); ?> <?php else: ?> <?php echo e($subscription->package->name); ?> <?php endif; ?></span> (متبقى :
                                    <span style="color: #ff0000"><?php echo e(\App\Http\Controllers\AdvsController::calc_duration($subscription->end_date)); ?></span>
                                    )</h3>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-danger text-center">
                            <h3>ليس لديك باقة حتى الأن !</h3>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-12">
                    
                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4">
                            <div class="adv_data text-center">
                                <h2 class="adv_data_1"><?php echo e($package->name); ?></h2>

                                <p class="p_justify"><?php echo e($package->details); ?></p>
                                <hr>
                                <h3 class="font-bold">
                                    <?php if($package->duration == 1): ?> <?php echo e('شهر'); ?> <?php elseif($package->duration == 12): ?> <?php echo e(' عام '); ?> <?php else: ?> <?php echo e($package->duration.' شهور'); ?> <?php endif; ?>
                                </h3>
                                <hr>
                                <h2 class="font-bold"><?php echo e($package->price.' $'); ?></h2>

                                <form action="<?php echo e(route('add_subscription')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="advertiser_id" value="<?php echo e(auth()->id()); ?>">
                                    <input type="hidden" name="package_id" value="<?php echo e($package->id); ?>">
                                    <?php if($subscription): ?>
                                        <?php if($subscription->package_id == $package->id): ?>
                                            <button type="button" class="btn btn-block button_me btn-success"><i
                                                        class="fa fa-check-circle"></i>&nbsp;&nbsp;تم الاختيار
                                            </button>
                                        <?php else: ?>
                                            <?php if($subscription->start_date == null or $subscription->end_date == null): ?>
                                                <button type="submit" class="btn btn-block button_me">اشترك الأن!</button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-block button_me"><i
                                                            class="fa fa-close"></i>&nbsp;&nbsp;غير متاح الأن</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-block button_me">اشترك الأن!</button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>

                        <?php if($loop->iteration % 3 == 0): ?>
                            <div class="col-md-12 clearfix"></div>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </div>
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