<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
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
        <div class="col-xs-12">
            <div class="bg-color-silver border-all">
                <h3 class="color-silver-darker"><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a> / <a
                            href="<?php echo e(url('/home')); ?>" class="color-black">الصفحة الشخصية</a></h3>
            </div>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="bg-color-white border-all p-3 mt-3">
                <h3>أهلا وسهلا</h3>

                <div class="col-md-4 col-xs-12">
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-2 bg-color-orange color-light-blue border-all text-center">
                            <?php if($advertiser->special == 1): ?>
                                <img class="p-3" src="<?php echo e(asset('public/img/ustar.png')); ?>">
                            <?php else: ?>
                                <i class="fa fa-user-o fa-2x p-2"></i>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9"><h4><?php echo e($advertiser->name ?? ''); ?></h4></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-2 bg-color-silver-darker color-gold border-all text-center">
                            <i class="fa fa-thumbs-up fa-2x p-2"></i>
                        </div>
                        <div class="col-md-9"><h4><span><?php echo e($ratings->count() ?? ''); ?></span> تقييم ايجابى</h4></div>
                        
                        
                        
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-2 bg-color-silver-darker color-gold border-all text-center">
                            <i class="fa fa-rss fa-2x p-2"></i>
                        </div>
                        <div class="col-md-9"><h4><span><?php echo e($followers->count() ?? ''); ?></span> متابع </h4></div>
                        
                        
                        
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="bg-color-white border-all p-5 mt-3">
                <div class=" col-md-10 col-md-offset-1 col-xs-12 color-silver-darker2">
                    <form action="<?php echo e(url('/account_settings/'.$advertiser->id)); ?>" method="post" class="form-group">
                        <?php echo e(method_field('PUT')); ?>

                        <?php echo csrf_field(); ?>
                        <div class="col-md-1 hidden-xs text-center">
                            <?php if($advertiser->special == 1): ?>
                                <img src="<?php echo e(asset('public/img/ustar.png')); ?>">
                            <?php else: ?>
                                <i class="fa fa-user-o fa-2x icon-register"></i>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-11 col-xs-12">
                            <input name="name" value="<?php echo e($advertiser->name); ?>" type="text" class="form-control input-md"
                                   placeholder="اسم المستخدم" required>
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-1 hidden-xs text-center"><i class="fa fa-mobile fa-2x icon-register"></i>
                        </div>
                        <div class="col-md-11 col-xs-12">
                            <input name="mobile" value="<?php echo e($advertiser->mobile); ?>" type="number"
                                   class="form-control input-md" placeholder="صيغة الجوال المطلوبة 05xxxxxxxx" required>
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-1 hidden-xs text-center"><i class="fa fa-envelope-o fa-2x icon-register"></i>
                        </div>
                        <div class="col-md-11 col-xs-12">
                            <input name="e_mail" value="<?php echo e($advertiser->e_mail); ?>" type="email"
                                   class="form-control input-md" placeholder="البريد الإلكترونى" required>
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-1 hidden-xs text-center"><i class="fa fa-lock fa-2x icon-register"></i></div>
                        <div class="col-md-11 col-xs-12">
                            <input name="pass" min="6" type="password" class="input-md form-control"
                                   placeholder="كلمة المرور">
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-1 hidden-xs text-center"><i class="fa fa-lock fa-2x icon-register"></i></div>
                        <div class="col-md-11 col-xs-12">
                            <input name="pass_confirmation" min="6" type="password" class="input-md form-control"
                                   placeholder="إعادة كلمة المرور">
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <h3 class="text-center"> العنوان </h3>

                        <div class="col-md-6 col-xs-12">
                            <select class="form-control m-b input-md selectpicker" name="area" id="area"
                                    data-live-search="true" required>
                                <option value="">اختر منطقة ...</option>
                                <?php $__currentLoopData = $area; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area_): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($area_->id); ?>" <?php if($advertiser->area == $area_->id): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($area_->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <select class="form-control m-b input-md selectpicker" name="city" id="city"
                                    data-live-search="true" required>
                                <option value="">اختر مدينة ...</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($city->id); ?>" <?php if($advertiser->city == $city->id): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-6 col-xs-12">
                            <input name="street" value="<?php echo e($advertiser->street); ?>" type="text"
                                   class="input-md form-control" placeholder="الحى ..." required>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input id="autocomplete_search" name="address" value="<?php echo e($advertiser->address); ?>" type="text"
                                   class="input-md form-control" placeholder="ابحث هنا عن موقعك ..." >
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-6 col-xs-12">
                            <input readonly class="form-control" type="hidden" name="lat" value="<?php echo e($advertiser->lat); ?>" id="lat"
                                   placeholder="خط الطول هنا ..." >
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input readonly class="form-control" type="hidden" name="lon" value="<?php echo e($advertiser->lon); ?>" id="long"
                                   placeholder="خط العرض هنا ..." >
                        </div>
                        <div class="clearfix"></div>
                        <br>


                        <h3 class="text-center">التواصل الإجتماعى</h3>

                        <div class="col-md-6 col-xs-12">
                            <span class="icon__form">
                                <img alt="facbook" src="<?php echo e(asset('public/img/f.png')); ?>">
                            </span>
                            <input name="facebook" value="<?php echo e($advertiser->facebook); ?>" type="text"
                                   class="input-md form-control" placeholder="ضع رابط الفيس بوك الخاص بك ...">
                        </div>

                        <div class="col-md-6 col-xs-12">
                            <span class="icon__form">
                                <img alt="instagram" src="<?php echo e(asset('public/img/i.png')); ?>">
                            </span>
                            <input name="instagram" value="<?php echo e($advertiser->instagram); ?>" type="text"
                                   class="input-md form-control" placeholder="ضع رابط انستجرام الخاص بك ...">
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-6 col-xs-12">
                            <span class="icon__form">
                                <img alt="twitter" src="<?php echo e(asset('public/img/t.png')); ?>">
                            </span>
                            <input name="twitter" value="<?php echo e($advertiser->twitter); ?>" type="text"
                                   class="input-md form-control" placeholder="ضع رابط تويتر الخاص بك ...">
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-green btn-block border-r-10"><h4>تعديل</h4></button>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end of content -->
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script>
        // area -> city
        $(function () {
            $('#area').on('change', function () {
                var area_id = $('#area option:selected').val();

                $.ajax({
                    url: "<?php echo e(url('/bottom_filter3_')); ?>",
                    type: "post",
                    data: {
                        'area_id': area_id,
                        '_token': '<?php echo e(csrf_token()); ?>'
                    },
                    beforeSend: function () {
                        $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                    },
                    success: function (data) {
                        $('#city').empty().append(data[0]);
                        $('.selectpicker').selectpicker('refresh');
                    },
                    complete: function () {
                        $(".loading_me").empty();
                    }
                });
            });
        });
    </script>


    </body>
    </html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>