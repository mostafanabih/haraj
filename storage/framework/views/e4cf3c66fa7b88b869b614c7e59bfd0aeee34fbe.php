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
                <h3 class="color-silver-darker"><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a> / <a href="<?php echo e(url('/advertiser/'.$advertiser->id)); ?>" class="color-black">المعلن <?php echo e($advertiser->name); ?></a></h3>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="border-all mt-4">
                <div class="bg-color-silver border-all">
                    <div class="col-md-2 bg-color-orange color-light-blue text-center">
                        <?php if($advertiser->special == 1): ?>
                            <img class="p-3" src="<?php echo e(asset('public/img/ustar.png')); ?>">
                        <?php else: ?>
                            <i class="fa fa-user-o fa-2x p-2"></i>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8"><h4><?php echo e($advertiser->name ?? ''); ?></h4></div>
                    <div class="col-md-2 text-center">
                        <?php if(auth()->guest()): ?>
                            <a href="<?php echo e(url('login?msg=log')); ?>">
                                <i class="fa fa-heart-o fa-lg color-silver-darker"></i>
                            </a>
                        <?php else: ?>
                            <?php if(auth()->user()->id == $advertiser->id): ?>

                            <?php else: ?>
                                <form action="<?php echo e(route('favourite_advertiser')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="favourite_advertiser" value="<?php echo e($advertiser->id); ?>">
                                    <input type="hidden" name="advertiser_id" value="<?php echo e(auth()->id()); ?>">
                                    <?php if(\App\Http\Controllers\AdvsController::is_advertiser_favourite(auth()->id(), $advertiser->id)): ?>
                                        <button class="transparent_btn btn btn-block" type="submit">
                                            <i class="fa fa-heart-o fa-lg color-gold"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="transparent_btn btn btn-block" type="submit">
                                            <i class="fa fa-heart-o fa-lg color-silver-darker"></i>
                                        </button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="bg-color-white p-3">
                    <h4>أخر ظهور <span><?php echo e(\Carbon\Carbon::parse($advertiser->last_activity)->diffForHumans() ?? ''); ?></span></h4>
                    
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-3 bg-color-silver-darker color-gold border-all text-center">
                            <i class="fa fa-thumbs-up fa-2x p-2"></i>
                        </div>
                        <div class="col-md-5"><h4><span><?php echo e($ratings->count() ?? ''); ?></span> تقييم ايجابى</h4></div>
                        <div class="col-md-4">
                            <?php if(auth()->guest()): ?>
                                <a href="<?php echo e(url('login?msg=log')); ?>" type="button" class="btn btn-orange btn-block m-1">
                                    <span class="font-large-bold">قيم</span>
                                </a>
                            <?php else: ?>
                                <?php if(auth()->user()->id == $advertiser->id): ?>

                                <?php else: ?>
                                    <!-- Button trigger modal -->
                                <button type="button" class="btn btn-orange btn-block m-1" data-toggle="modal" data-target="#myModal2">
                                    <span class="font-large-bold">قيم</span>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLongTitle">تقييم <span><?php echo e($advertiser->name); ?></span></h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <form action="<?php echo e(route('advertiser_rating')); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="rating_now__starts">
                                                        <input type="hidden" name="rating" class="rating" value="0"  />
                                                    </div>
                                                    <input type="hidden" name="advertiser_id" value="<?php echo e($advertiser->id); ?>">
                                                    <input type="hidden" name="voter_id" value="<?php echo e(auth()->user()->id); ?>">
                                                    <button type="submit" class="btn btn-orange btn-block">قيم</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-3 bg-color-silver-darker color-green border-all text-center">
                            <i class="fa fa-whatsapp fa-2x p-2"></i>
                        </div>
                        <?php
                        $mobile_with_whatsapp = '966'.ltrim($advertiser->mobile, '0');
                        ?>
                        <div class="col-md-5" id="MyText"><h4><?php echo e($mobile_with_whatsapp ?? ''); ?></h4></div>
                        <div class="col-md-4">
                            <button onclick="MyCopy()" class="btn btn-orange btn-block m-1">
                                <span class="font-large-bold">نسخ</span>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-3 bg-color-silver-darker color-gold border-all text-center">
                            <i class="fa fa-rss fa-2x p-2"></i>
                        </div>
                        <div class="col-md-5"><h4><span><?php echo e($followers->count() ?? ''); ?></span> متابع</h4></div>
                        <div class="col-md-4">
                            <?php if(auth()->guest()): ?>
                                <a href="<?php echo e(url('login?msg=log')); ?>" type="button" class="btn btn-orange btn-block m-1">
                                    <span class="font-large-bold">متابعة</span>
                                </a>
                            <?php else: ?>
                                <?php if(auth()->user()->id == $advertiser->id): ?>

                                <?php else: ?>
                                    <form action="<?php echo e(route('follow_me')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="advertiser_id" value="<?php echo e($advertiser->id); ?>">
                                        <input type="hidden" name="follower_id" value="<?php echo e(auth()->user()->id); ?>">

                                        <?php if(\App\Http\Controllers\AdvsController::is_follow($advertiser->id, auth()->user()->id)): ?>
                                            <button type="submit" class="btn btn-orange btn-block m-1">
                                                <span>تم المتابعة</span>
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-orange btn-block m-1">
                                                <span class="font-large-bold">متابعة</span>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="text-center">
                        <?php if(auth()->guest()): ?>
                            <h4><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;أرسل رسالتك للمعلن</h4>
                            <textarea name="msg" rows="5" class="form-control" placeholder="اكتب هنا نص الرسالة"></textarea>
                            <a href="<?php echo e(url('login?msg=log')); ?>" type="button" class="btn btn-green_1 btn-block mt-2"><span class="font-large-bold">ارسال</span></a>
                        <?php else: ?>
                            <?php if(auth()->user()->id == $advertiser->id): ?>

                            <?php else: ?>
                                <h4><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;أرسل رسالتك للمعلن</h4>
                                <form action="<?php echo e(route('contact_me')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <textarea name="msg" rows="5" class="form-control" placeholder="اكتب هنا نص الرسالة"></textarea>
                                    <input type="hidden" name="from_id" value="<?php echo e(auth()->id()); ?>">
                                    <input type="hidden" name="to_id" value="<?php echo e($advertiser->id); ?>">
                                    <input type="hidden" name="parent_id" value="0">

                                    <button type="submit" class="btn btn-orange btn-block mt-2"><span class="font-large-bold">ارسال</span></button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>

                        <ul class="list-inline pt-5">
                            <a target="_blank" class="pl-5 color-silver-darker2" href="<?php echo e($advertiser->facebook); ?>">
                                <li class="fa fa-facebook fa-2x"></li>
                            </a>
                            <a target="_blank" class="pl-5 color-silver-darker2" href="<?php echo e($advertiser->twitter); ?>">
                                <li class="fa fa-twitter fa-2x"></li>
                            </a>
                            <a target="_blank" class="pl-5 color-silver-darker2" href="<?php echo e($advertiser->instagram); ?>">
                                <li class="fa fa-instagram fa-2x"></li>
                            </a>
                            
                                
                            
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <!--start of Filter-->
            <div class="col-xs-12 bg-color-silver p-3 mt-4 mb-1">
                <div class="">
                    <div class="col-md-6 col-xs-12">
                        <label class="font-large-bold pt-3 col-md-4 hidden-xs">التصنيف</label>
                        <select class="form-control col-md-8 col-xs-12 m-b selectpicker" name="main_section" id="main_section" data-live-search="true" required>
                            <option value="0">اختر القسم الرئيسى</option>
                            <?php $__currentLoopData = $main_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if(request('main_section') == $main->id): ?> selected
                                        <?php endif; ?> value="<?php echo e($main->id); ?>"><?php echo e($main->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 br_">
                        <label class="font-large-bold pt-3 col-md-4 hidden-xs">اختر المدينة</label>
                        <select class="form-control col-md-8 col-xs-12 m-b selectpicker" name="city" id="city" data-live-search="true" required>
                            <option value="0">كل المدن</option>
                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if(request('city') == $city->id): ?> selected
                                        <?php endif; ?> value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--end Filter-->

            <!--result-->
            <div class="col-xs-12 bg-color-silver p-3 mt-4 mb-4">
                <div class="">
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
                                                        <?php if($advertiser->special == 1): ?>
                                                            <img src="<?php echo e(asset('public/img/ustar.png')); ?>">
                                                        <?php else: ?>
                                                            <i class="fa fa-user-o"></i>
                                                        <?php endif; ?>
                                                        <small><?php echo e($advertiser->name ?? ''); ?></small>
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
            </div>
            <!--End filter and result-->

            <?php if(!is_null($advertiser->lat) and !is_null($advertiser->lon)): ?>
                <h3 class="pt-3">موقع المعلن ع الخريطة : </h3>
                <!--The div element for the map -->
                <div id="map"></div>
                <script>
                    // Initialize and add the map
                    function initMap() {
                        // The location of Uluru
                        var uluru = {lat: <?php echo e($advertiser->lat); ?>, lng: <?php echo e($advertiser->lon); ?>};
                        // The map
                        var map = new google.maps.Map(
                                document.getElementById('map'), {zoom: 4, center: uluru});
                        // The marker, positioned at Uluru
                        var marker = new google.maps.Marker({position: uluru, map: map});
                    }
                </script>
                <!--Load the API from the specified URL
                * The async attribute allows the browser to render the page while the API loads
                * The key parameter will contain your own API key (which is not needed for this tutorial)
                * The callback parameter executes the initMap() function
                -->
                <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmT97qMPjKdidWGuTUr8c9KC2l4sVUcNs&callback=initMap">
                </script>
                <?php else: ?>
                <div class="clearfix"></div>
                <div class="text-center bg-info p-3 mt-5">
                    <h3>لم يحدد المعلن موقعه على الخريطة حتى الأن</h3>
                </div>
            <?php endif; ?>

        </div>
        <!-- end of content -->
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script>
        $(function () {
            // case 1
            $('#main_section, #city').on('change', function () {
                var main_section_id = $('#main_section option:selected').val();
                var city_id = $('#city option:selected').val();
                var advertiser_id = '<?php echo e($advertiser->id); ?>';

                $.ajax({
                    url: "<?php echo e(url('/bottom_filter1_123_')); ?>",
                    type: "post",
                    data: {
                        'main_section_id': main_section_id,
                        'city_id': city_id,
                        'advertiser_id': advertiser_id,
                        '_token': '<?php echo e(csrf_token()); ?>'
                    },
                    beforeSend: function () {
                        $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                    },
                    success: function (data) {
                        $('#result').empty().append(data[0]);
                    },
                    complete: function () {
                        $(".loading_me").empty();
                    }
                });
            });

        });

        function MyCopy(){
            var copyText = document.getElementById("MyText");
            var textArea = document.createElement("textarea");
            textArea.value = copyText.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            textArea.remove();
        }
    </script>
    </body>
    </html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>