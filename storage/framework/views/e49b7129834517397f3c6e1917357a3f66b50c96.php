<?php $__env->startSection('content'); ?>
</section>
<!--End Header-->



<div class="container-fluid padding-r-l-50 pt-3">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a></li>
            <li><span class="color-black">الأقسام</span></li>
            <li class="active"> <?php echo e($main_sections->name); ?> </li>
        </ol>
        <!-- start of content -->
        <div class="col-sm-12">
            
                
                    
                        
                        
                            
                                
                            
                        
                    
                
                
                
                    
                        
                    
                
                
                    
                        
                            
                            
                                
                            
                        
                    
                
                
                    
                        
                            
                        
                    
                
                
                    
                    
                        
                    
                    
                        
                    
                    
                        
                    
                    
                        
                        
                        
                    
                
                
                    
                
            

            <!--start of Filter-->
            <div class="col-md-12 col-xs-12 bg-color-silver p-3 mt-4 mb-1">
                <div class="col-md-4 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-4 hidden-sm hidden-xs">اختر المدينة</label>
                    <select class="form-control col-md-8 col-sm-12 col-xs-12 m-b br_ selectpicker" name="city" id="city" data-live-search="true" required>
                        <option value="0"> كل المدن</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if(request('city') == $city->id): ?> selected <?php endif; ?> value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-4 hidden-sm hidden-xs">تصنيف فرعى</label>
                    <select class="form-control col-md-8 col-sm-12 col-xs-12 m-b br_ selectpicker" name="sub_section" id="sub_section" data-live-search="true" required>
                        <option value="0">كل الاقسام الفرعية</option>
                        <?php $__currentLoopData = $sub_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if(request('sub_section') == $sub->id): ?> selected <?php endif; ?> value="<?php echo e($sub->id); ?>"><?php echo e($sub->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-4 hidden-sm hidden-xs">تصنيف داخلى</label>
                    <select class="form-control col-md-8 col-sm-12 col-xs-12 m-b br_ selectpicker" name="internal_section" id="internal_section" data-live-search="true" required>
                        <option value="0">كل الاقسام الداخلية</option>
                    </select>
                </div>
            </div>
            <!--end Filter-->
            <!--result-->
            <div class="col-md-12 col-xs-12 bg-color-silver p-3 mt-4 ">
                <!--result units-->
                <div class="col-md-12 col-xs-12 no-padding-x" id="result">
                    <?php if(count($advs) > 0): ?>
                    <?php $__currentLoopData = $advs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!--unit-->
                    <a style="color: #000" href="<?php echo e(url('/adv/'.$adv->id)); ?>">
                        <div class="my-3 bg-color-white py-2 overflow-hidden my_div2">
                            <div class="col-md-10 col-xs-10">
                                <div class="border-bottom">
                                    <h4 class="string_limit2 color-gold"><?php echo e($adv->title ?? ''); ?></h4>
                                </div>
                                <div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pt-3">
                                            <p><?php echo e(\App\Http\Controllers\AdvsController::get_count_ratings($adv->id).' ردود '  ?? ''); ?></p>
                                            <p class="string_limit pt-2"><i class="fa fa-map-marker"></i>
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
                                    <div class="col-xs-6 small_font">
                                        <div class="pull-left pt-3">
                                            <p><i class="fa fa-clock-o"></i>
                                                <small><?php echo e(App\Http\Controllers\AdvsController::calc_duration($adv->created_at) ?? ''); ?></small>
                                            </p>
                                            <a style="color: #000" href="<?php echo e(url('/advertiser/'.$adv->advertiser_id)); ?>">
                                                <p class="pt-2 string_limit">
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
                            <div class="col-md-2 col-xs-2">
                                <img alt="image" class="adv_height adv-hi img-responsive img-rounded" src="<?php if(is_null(\App\Http\Controllers\AdvsController::get_small_img($adv->id))): ?> <?php echo e(asset('public/img/no_img.png')); ?> <?php else: ?> <?php echo e(asset(\App\Http\Controllers\AdvsController::get_small_img($adv->id))); ?> <?php endif; ?>">
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
            <!--End filter and result-->

        </div>
        <!-- end of content -->
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<script>
    $(function() {
// buttom filter
// case 1
    $('#city').on('change', function () {
        var main_section_id = '<?php echo e($main_sections->id); ?>';
        var city_id = $('#city option:selected').val();
        var search = $('#search').val();

        $.ajax({
            url: "<?php echo e(url('/bottom_filter1')); ?>",
            type: "post",
            data: {'main_section_id': main_section_id,
                'city_id': city_id,
                'search': search,
                '_token': '<?php echo e(csrf_token()); ?>'},
            beforeSend: function () {
                $(".loading_me").empty().append('<div class="se-pre-con"></div>');
            },
            success: function (data) {
                $('#sub_section').empty().append(data[0]);
                $('#internal_section').empty().append(data[1]);
                $('#result').empty().append(data[2]);
                $('#years').empty().append(data[3]);
                $('.selectpicker').selectpicker('refresh');
            },
            complete: function () {
                $(".loading_me").empty();
            }
        });
    });
    // case 2
    $('#sub_section').on('change', function () {
        var main_section_id = '<?php echo e($main_sections->id); ?>';
        var sub_section_id = $('#sub_section option:selected').val();

        if(sub_section_id == 0){var sub_section_name = '';}
        else{var sub_section_name = $('#sub_section option:selected').text();}

        var city_id = $('#city option:selected').val();
        var search = $('#search').val();

        $.ajax({
            url: "<?php echo e(url('/bottom_filter2')); ?>",
            type: "post",
            data: {'main_section_id': main_section_id,
                'sub_section_id': sub_section_id,
                'city_id': city_id,
                'search': search,
                '_token': '<?php echo e(csrf_token()); ?>'},
            beforeSend: function () {
                $(".loading_me").empty().append('<div class="se-pre-con"></div>');
            },
            success: function (data) {
                $('#sub_section').empty().append(data[0]);
                $('#internal_section').empty().append(data[1]);
                $('#result').empty().append(data[2]);
                $('#navgate').empty().append(sub_section_name);
                $('.selectpicker').selectpicker('refresh');
            },
            complete: function () {
                $(".loading_me").empty();
            }
        });
    });
    // case 3
    $('#internal_section').on('change', function () {
        var main_section_id = '<?php echo e($main_sections->id); ?>';
        var sub_section_id = $('#sub_section option:selected').val();
        var sub_section_name = $('#sub_section option:selected').text();
        var internal_section_id = $('#internal_section option:selected').val();
        var internal_section_name = $('#internal_section option:selected').text();
        var city_id = $('#city option:selected').val();
        var search = $('#search').val();

        $.ajax({
            url: "<?php echo e(url('/bottom_filter3')); ?>",
            type: "post",
            data: {'main_section_id': main_section_id,
                'sub_section_id': sub_section_id,
                'internal_section_id': internal_section_id,
                'city_id': city_id,
                'search': search,
                '_token': '<?php echo e(csrf_token()); ?>'},
            beforeSend: function () {
                $(".loading_me").empty().append('<div class="se-pre-con"></div>');
            },
            success: function (data) {
                $('#sub_section').empty().append(data[0]);
                $('#internal_section').empty().append(data[1]);
                $('#result').empty().append(data[2]);
                $('#navgate').empty().append(sub_section_name+' / '+internal_section_name);
                $('.selectpicker').selectpicker('refresh');
            },
            complete: function () {
                $(".loading_me").empty();
            }
        });
    });


    $(document).ready(function () {
        var main_section_id = '<?php echo e($main_sections->id); ?>';
        var sub_section_id = '<?php echo e(request('sub2')); ?>';
        var sub_section_name = '<?php echo e(request('name2')); ?>';
        var city_id = 0;
        var search = '';

        if(sub_section_id){
            $.ajax({
                url: "<?php echo e(url('/bottom_filter2')); ?>",
                type: "post",
                data: {
                    'main_section_id': main_section_id,
                    'sub_section_id': sub_section_id,
                    'city_id': city_id,
                    'search': search,
                    '_token': '<?php echo e(csrf_token()); ?>'
                },
                beforeSend: function () {
                    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                },
                success: function (data) {
                    $('#sub_section').empty().append(data[0]);
                    $('#internal_section').empty().append(data[1]);
                    $('#result').empty().append(data[2]);
                    $('#navgate').empty().append(sub_section_name);
                    $('.selectpicker').selectpicker('refresh');
                },
                complete: function () {
                    $(".loading_me").empty();
                }
            });
        }

    });


    });
</script>
</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>