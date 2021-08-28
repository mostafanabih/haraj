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
            <h3 class="color-silver-darker"><a href="<?php echo e(url('/home')); ?>" class="color-silver-darker">حسابى</a> / <a href="<?php echo e(url('/add_adv')); ?>" class="color-black">إعلاناتى</a></h3>
        </div>

        <div class="col-md-12 col-xs-12 bg-color-silver p-3 mt-4 mb-1">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-6 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-3 col-xs-12">التصنيف</label>
                    <select class="form-control col-md-9 col-xs-12 m-b selectpicker" name="main_section" id="main_section" data-live-search="true" required>
                        <option value="0">اختر القسم الرئيسى ...</option>
                        <?php $__currentLoopData = $main_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if(request('main_section') == $main->id): ?> selected <?php endif; ?> value="<?php echo e($main->id); ?>"><?php echo e($main->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-3 col-xs-12">اختر مدينة</label>
                    <select class="form-control col-md-9 col-xs-12 m-b selectpicker" name="city" id="city" data-live-search="true" required>
                        <option value="0">كل المدن</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if(request('city') == $city->id): ?> selected <?php endif; ?> value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xs-12 bg-color-silver p-3">
            <!--result units-->
            <div class="col-md-12 col-xs-12 no-padding-x" id="result">
                <?php if(count($advs) > 0): ?>
                <?php $__currentLoopData = $advs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--unit-->
                <a style="color: #000" href="<?php echo e(url('/adv/'.$adv->id)); ?>">
                    <div class="<?php if(session('display') == 'tiles'): ?> col-sm-6 <?php endif; ?> my-3 bg-color-white py-2 overflow-hidden my_div2 my_div2_">
                        <div class="col-md-10 col-xs-10">
                            <div class="col-md-12 col-xs-12">
                                <h4 class="string_limit2 color-gold"><?php echo e($adv->title); ?></h4>
                            </div>
                            <div class="clearfix border-bottom"></div>

                            <div>
                                <div class="col-md-5 col-xs-6 small_font">
                                    <div class="pt-3">
                                        <p><?php echo e(\App\Http\Controllers\AdvsController::get_count_ratings($adv->id).' ردود '); ?></p>
                                        <p class="pt-2"><i class="fa fa-map-marker"></i>
                                            <?php if($adv->city): ?>
                                                <?php echo e(($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة'); ?>

                                                <?php echo e(' , '); ?>

                                                <?php echo e(($adv->City) ? $adv->City->name : 'بدون مدينة'); ?>

                                            <?php else: ?>
                                                <?php echo e('بدون عنوان'); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-6 small_font">
                                    <div class="pull-left pt-3">
                                        <p><i class="fa fa-clock-o"></i>
                                            <small><?php echo e(App\Http\Controllers\AdvsController::calc_duration($adv->created_at)); ?></small>
                                        </p>
                                        <p><?php echo e('#'.$adv->id); ?></p>
                                        
                                            
                                                
                                            
                                        
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="">
                                        <div class="col-md-12 col-xs-6 pt-2">
                                            <a href="<?php echo e(url('/add_adv/'.$adv->id.'/edit')); ?>" class="btn btn-green btn-block border-r-10">
                                                <span class="hidden-xs hidden-sm font-large-bold">تعديل الإعلان&nbsp;&nbsp;</span><i class="fa fa-edit fa-lg"></i>
                                            </a>
                                        </div>

                                        <div class="col-md-12 col-xs-6 pt-2">
                                            <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="<?php echo e(url('/add_adv/'.$adv->id)); ?>" method="post">
                                                <?php echo e(method_field('DELETE')); ?>

                                                <?php echo csrf_field(); ?>
                                                <button type="button" class="del_ btn btn-orange btn-block border-r-10">
                                                    <span class="hidden-xs hidden-sm font-large-bold">حذف الإعلان&nbsp;&nbsp;</span><i class="fa fa-trash fa-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2">
                            <img alt="adv image" class="adv_height img-responsive img-rounded" src="<?php if(is_null(\App\Http\Controllers\AdvsController::get_small_img($adv->id))): ?> <?php echo e(asset('public/img/no_img.png')); ?> <?php else: ?> <?php echo e(asset(\App\Http\Controllers\AdvsController::get_small_img($adv->id))); ?> <?php endif; ?>">
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
                        <?php echo e($advs->onEachSide(1)->appends(Request::capture()->except('page'))->render()); ?>

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
<script>
    $(function() {
        $(document).on('click', '.del_', function () {
            if (confirm('هل تريد الحذف بالتأكيد ؟')) {
                this.form.submit();
            } else {
                // Do nothing!
            }

        });
    });

    // case 1
    $('#main_section, #city').on('change', function () {
        var main_section_id = $('#main_section option:selected').val();
        var city_id = $('#city option:selected').val();

        $.ajax({
            url: "<?php echo e(url('/bottom_filter1_123')); ?>",
            type: "post",
            data: {
                'main_section_id': main_section_id,
                'city_id': city_id,
                '_token': '<?php echo e(csrf_token()); ?>'
            },
            beforeSend: function () {
                $(".loading_me").empty().append('<div class="se-pre-con"></div>');
            },
            success: function (data) {
                $('#result').empty().append(data[0]);
                $('.selectpicker').selectpicker('refresh');
//                alert(data[0]);
            },
            complete: function () {
                $(".loading_me").empty();
            }
        });
    });
</script>
</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>