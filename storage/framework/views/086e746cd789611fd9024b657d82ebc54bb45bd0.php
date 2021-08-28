<?php $__env->startSection('meta_img'); ?>
    <meta property="og:image" content="<?php echo e($meta_adv_img); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .textarea-container {
            height: 100%;
        }

        .button-area {
            float: left;
            padding: 8px 25px;
            z-index: 9;
            position: relative;
            top: -72px;
            left: 14px;
        }
    </style>
    <?php $__env->stopSection(); ?>
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

            <div class="col-md-12 col-xs-12">
                <div class="bg-color-silver border-all">
                    <?php
                    $main_section =
                    \App\Http\Controllers\AdminController::get_main_sub_internal_section($adv->main_section, 1);
                    $sub_section =
                    \App\Http\Controllers\AdminController::get_main_sub_internal_section($adv->sub_section, 2);
                    $internal_section =
                    \App\Http\Controllers\AdminController::get_main_sub_internal_section($adv->internal_section, 3);
                    ?>


                    <h4 class="color-silver-darker"><a href="<?php echo e(url('/')); ?>" class="color-silver-darker">الرئيسية</a> /
                        <?php if($main_section): ?>
                            <a href="<?php echo e(url('/menu/'.$main_section->name)); ?>"
                               class="color-black"><?php echo e($main_section->name); ?></a> /
                        <?php endif; ?>
                        <?php if($sub_section): ?>
                            <a href="<?php echo e(url('/menu/'.$main_section->name.'/?sub2='.$sub_section->id.'&name2='.$sub_section->name)); ?>"
                               class="color-black"><?php echo e($sub_section->name); ?></a> /
                        <?php endif; ?>

                        <?php if($adv->internal_section != 0): ?>
                            <a href="#" class="color-black"><?php echo e($internal_section->name); ?></a> /
                        <?php endif; ?>

                        <?php if($adv->year != 0): ?>
                            <a href="#" class="color-black"><?php echo e($adv->year); ?></a> /
                        <?php endif; ?>

                        <a href="<?php echo e(url('/adv/'.$adv->id)); ?>" class="color-black"><?php echo e($adv->title); ?></a>
                    </h4>

                </div>
            </div>

            <!-- start of content -->
            <div class="col-md-9 col-xs-12">
                <div class="bg-color-white border-all mt-3">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <h3 class="string_limit2 color-gold"><?php echo e($adv->title); ?></h3>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php if(auth()->check() and auth()->user()->id == $advertiser->id): ?>
                            <?php if(\Carbon\Carbon::parse($adv->updated_at)->addHours(\App\Http\Controllers\SiteSettingsController::get_info()->hour_update) >= \Carbon\Carbon::now()): ?>
                                <button onclick="alert('لا يمكنك تحديث اعلانك الأن ... لم تنتهى الساعات المحددة بعد')"
                                        disabled
                                        class="btn btn-primary btn-block mt-4">
                                    <i class="fa fa-refresh"></i>&nbsp;&nbsp;
                                    <span class="">تحديث الإعلان</span>
                                </button>
                            <?php else: ?>
                                <form action="<?php echo e(url('/adv_update_/'.$adv->id)); ?>" method="post"
                                      class="form-group">
                                    <?php echo e(method_field('PUT')); ?>

                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary btn-block mt-4">
                                        <i class="fa fa-refresh"></i>&nbsp;&nbsp;
                                        <span class="">تحديث الإعلان</span>
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                        <?php endif; ?>
                    </div>
                    <div class="p-3">
                        <div class="col-xs-6 small_font">
                            <div class="pt-3">
                                <h4>#<?php echo e($adv->id); ?></h4>
                                <h4 class="pt-2"><i class="fa fa-map-marker"></i>
                                    <?php if($adv->city): ?>
                                        <?php echo e(($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة'); ?>

                                        <?php echo e(' , '); ?>

                                        <?php echo e(($adv->City) ? $adv->City->name : 'بدون مدينة'); ?>

                                    <?php else: ?>
                                        <?php echo e('بدون عنوان'); ?>

                                    <?php endif; ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-xs-6 small_font">
                            <div class="pull-left pt-3">
                                <h4><i class="fa fa-clock-o"></i>
                                    <span><?php echo e(App\Http\Controllers\AdvsController::calc_duration($adv->created_at)); ?></span>
                                </h4>
                                <a style="color: #000"
                                   href="<?php echo e(url('/advertiser/'.$adv->advertiser_id)); ?>">
                                    <h4 class="pt-2"><i class="fa fa-user-o "></i>
                                        <span><?php echo e(App\Http\Controllers\AdvsController::get_advertiser($adv->advertiser_id)->name); ?></span>
                                    </h4>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>


                <div class="all_adv_action bg-color-silver text-center mt-3">
                    
                    <div class="adv_action">
                        <!-- Button trigger modal -->
                        <?php if(auth()->guest()): ?>
                            <a href="<?php echo e(url('login?msg=log')); ?>" type="button"
                               class="transparent_btn color-silver-darker2 btn btn-block">
                                <i class="fa fa-envelope-o fa-lg"></i>
                            </a>
                        <?php else: ?>
                            <?php if(auth()->user()->id == $advertiser->id): ?>
                                <button onclick="alert('لا يمكنك مراسلة ذاتك');" type="button"
                                        class="transparent_btn color-silver-darker2 btn btn-block">
                                    <i class="fa fa-envelope-o fa-lg"></i>
                                </button>
                            <?php else: ?>
                                <button type="button" class="transparent_btn color-silver-darker2 btn btn-block"
                                        data-toggle="modal" data-target="#myModal1">
                                    <i class="fa fa-envelope-o fa-lg"></i>
                                </button>
                                <?php endif; ?>
                                <?php endif; ?>
                                        <!-- Modal -->
                                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLongTitle">مراسلة
                                                    <span><?php echo e($advertiser->name); ?></span></h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php echo e(route('contact_me')); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <textarea name="msg" rows="5" class="form-control"
                                                              placeholder="اكتب هنا نص الرسالة"></textarea>
                                                    <input type="hidden" name="from_id" value="<?php echo e(auth()->id()); ?>">
                                                    <input type="hidden" name="to_id" value="<?php echo e($advertiser->id); ?>">
                                                    <input type="hidden" name="parent_id" value="0">

                                                    <br>
                                                    <button type="submit" class="btn btn-success btn-block">ارسال
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>

                    
                    <?php if(auth()->guest()): ?>
                        <div class="adv_action">
                            <a href="<?php echo e(url('login?msg=log')); ?>" class="transparent_btn btn btn-block" type="button">
                                <i class="fa fa-heart-o fa-lg"></i>
                                <span class="color-gold"><?php echo e($adv_favourite_count); ?></span>
                            </a>
                        </div>
                    <?php else: ?>
                        <?php if(auth()->user()->id == $advertiser->id): ?>

                        <?php else: ?>
                            <div class="adv_action">
                                <form action="<?php echo e(url('/favourite')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="adv_id" value="<?php echo e($adv->id); ?>">
                                    <input type="hidden" name="advertiser_id" value="<?php echo e(auth()->user()->id); ?>">

                                    <?php if(\App\Http\Controllers\AdvsController::is_favourite(auth()->user()->id, $adv->id)): ?>
                                        <button class="transparent_btn btn btn-block" type="submit">
                                            <i class="fa fa-heart-o fa-lg color-gold"></i>
                                            <span class="color-gold"><?php echo e($adv_favourite_count); ?></span>
                                        </button>
                                    <?php else: ?>
                                        <button class="transparent_btn btn btn-block" type="submit">
                                            <i class="fa fa-heart-o fa-lg"></i>
                                            <span class="color-gold"><?php echo e($adv_favourite_count); ?></span>
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    
                    <?php if(auth()->guest()): ?>
                        <div class="adv_action">
                            <a href="<?php echo e(url('login?msg=log')); ?>" class="transparent_btn btn btn-block" type="button">
                                <i class="fa fa-flag-o fa-lg"></i>
                            </a>
                        </div>
                    <?php else: ?>
                        <?php if(auth()->user()->id == $advertiser->id): ?>

                        <?php else: ?>
                            <div class="adv_action">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o fa-lg"></i>
                                </a>
                                <ul class="dropdown-menu"
                                    style="right: auto !important;top: auto !important;margin-top: 10px;">
                                    <?php if($reasons->count() > 0): ?>
                                        <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="p-2">
                                                <form action="<?php echo e(route('add_reporting')); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="advertiser_id"
                                                           value="<?php echo e($adv->advertiser_id); ?>">
                                                    <input type="hidden" name="adv_id" value="<?php echo e($adv->id); ?>">
                                                    <input type="hidden" name="c_r_type" value="0">
                                                    <input type="hidden" name="c_r_id" value="0">
                                                    <input type="hidden" name="c_r_voter_id" value="0">
                                                    <input type="hidden" name="reason_id" value="<?php echo e($reason->id); ?>">
                                                    <input type="hidden" name="reporter_id"
                                                           value="<?php echo e(auth()->id()); ?>">

                                                    <button type="submit"
                                                            class="btn btn-block btn-orange"><?php echo e($reason->name); ?></button>
                                                </form>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <li class="bg-primary text-center p-3">لا توجد أسباب حتى الأن ...</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    
                    <div class="adv_action">
                        
                            
                                
                            
                        
                        <a class="transparent_btn btn btn-block" href="https://www.facebook.com/sharer/sharer.php?u=&t=" title="Share on Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;">
                            <i class="fa fa-facebook fa-lg"></i>
                        </a>
                    </div>
                    <div class="adv_action">
                        
                            
                                
                            
                        
                        <a class="transparent_btn btn btn-block" href="https://twitter.com/intent/tweet?" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=%20Check%20up%20this%20awesome%20content' + encodeURIComponent(document.title) + ':%20 ' + encodeURIComponent(document.URL)); return false;">
                            <i class="fa fa-twitter fa-lg"></i>
                        </a>
                    </div>

                    
                </div>

                
                <?php
                $iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
                $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
                $palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
                $berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
                $ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");

                $mobile_with_whatsapp = '966' . ltrim($advertiser->mobile, '0');

                // check if is a mobile
                if ($iphone || $android || $palmpre || $ipod || $berry == true) {
                    $whatsapp_url = 'https://api.whatsapp.com/send?phone=' . $mobile_with_whatsapp;
                } else {// all others
                    $whatsapp_url = 'https://web.whatsapp.com/send?phone=' . $mobile_with_whatsapp;
                }
                ?>
                <div class="bg-color-white border-all p-3 mt-3 text-center">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="col-lg-4 hidden-md hidden-sm hidden-xs"><label class="pt-4">وسيلة الإتصال</label>
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <div class="whatsapp_">
                                <label class=""><?php echo e($advertiser->mobile); ?></label>
                                <a target="_blank" href="<?php echo e($whatsapp_url); ?>">
                                    <img class="pull-left" src="<?php echo e(asset('public/img/wts.png')); ?>" alt="whatsapp">
                                </a>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-4 col-sm-12 col-xs-12" style="padding-top: 5px;line-height: 2.5;">
                        <form action="<?php echo e(route('rating')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="col-lg-3 hidden-md hidden-sm hidden-xs"><label>قيم الإعلان</label></div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="rating_now">
                                    <div class="rating_now__starts">
                                        <input type="hidden" name="rating" class="rating" value="0"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                <?php if(auth()->guest()): ?>
                                    <a href="<?php echo e(url('login?msg=log')); ?>" type="submit" class="btn btn-orange btn-block"><b>تقييم</b></a>
                                <?php else: ?>
                                    <?php if(auth()->user()->id == $advertiser->id): ?>

                                    <?php else: ?>
                                        <input type="hidden" name="adv_id" value="<?php echo e($adv->id); ?>">
                                        <input type="hidden" name="voter_id" value="<?php echo e(auth()->user()->id); ?>">
                                        <input type="hidden" name="type" value="1">
                                        <input type="hidden" name="advertiser_id" value="<?php echo e($adv->advertiser_id); ?>">
                                        <button type="submit" class="btn btn-orange btn-block"><b>تقييم</b></button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                        <ul class="list-inline pt-3">
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
                

                
                <div class="bg-color-white border-all p-3 mt-3">
                    <div><?php echo nl2br($adv->details); ?></div>
                    <div class="clearfix"></div>
                </div>
                

                
                <div class="bg-color-white border-all p-3 mt-3 text-center">
                    <?php if($adv->link != null): ?>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe
                                    class="embed-responsive-item"
                                    src="<?php echo e('https://www.youtube.com/embed/'.$vid_id); ?>" frameborder="0" allowfullscreen>
                            </iframe>
                        </div>
                    <?php else: ?>
                    <?php endif; ?>
                    <?php if(count($adv_imgs) > 0): ?>
                        <?php $__currentLoopData = $adv_imgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img alt="Preview Image 1"
                                 src="<?php echo e(asset($img->img)); ?>"
                                 data-image=""
                                 data-description="" class="img-show">
                            <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <img alt="Preview Image 1"
                             src="<?php echo e(asset('public/img/no_img.png')); ?>" data-image=""
                             data-description="" class="share-image">
                    <?php endif; ?>
                </div>
                

                <?php if($adv->allow_comment == 1): ?>
                    
                    <?php if($adv_comments->count() > 0): ?>
                        <?php $__currentLoopData = $adv_comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(App\Advertiser::find($rating->voter_id)): ?>
                                <div class="mt-3">
                                    <div class="bg-color-silver border-all pl-4">
                                        <h3><?php echo e(\App\Http\Controllers\AdvsController::get_advertiser($rating->voter_id)->name); ?></h3>
                                        <h5 class="color-silver-darker"><?php echo e(\Carbon\Carbon::parse($rating->created_at)->diffForHumans()); ?></h5>
                                    </div>
                                    <div class="bg-color-white border-all p-4">
                                        <h3><?php echo e($rating->reply); ?></h3>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="bg-color-silver p-2 mt-3 text-center">
                            <h3>لا توجد تعليقات حتى الأن ...</h3>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('rating')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="textarea-container">
                            <textarea rows="3" name="reply" class="form-control" placeholder="أكتب تعليق"
                                      required></textarea>
                            <?php if(auth()->guest()): ?>
                                <a href="<?php echo e(url('login?msg=log')); ?>" type="submit"
                                   class="button-area btn btn-orange"><span class="font-large-bold">أضف</span></a>
                            <?php else: ?>
                                <input type="hidden" name="adv_id" value="<?php echo e($adv->id); ?>">
                                <input type="hidden" name="voter_id" value="<?php echo e(auth()->user()->id); ?>">
                                <input type="hidden" name="type" value="0">
                                <input type="hidden" name="advertiser_id" value="<?php echo e($adv->advertiser_id); ?>">
                                <button type="submit" class="button-area btn btn-orange"><span class="font-large-bold">أضف</span>
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                    
                <?php endif; ?>


                
                <div class="bg-color-silver border-all p-3 mt-3">
                    <div class="col-md-6 col-xs-12">
                        <?php
                        if ($adv_ratings->count() == 0) {
                            $advs_ratings_count = 1;
                        } else {
                            $advs_ratings_count = $adv_ratings->count();
                        }
                        ?>
                        <div class="stare-rate text-center bg-wait min-height">
                            <small class="stare-rate__percent"> <?php echo e(number_format($adv_sum/$advs_ratings_count,1)); ?> </small>
                            <div class="stare-rate__starts">
                                <input type="hidden" class="rating"
                                       value="<?php echo e(number_format($adv_sum/$advs_ratings_count,1)); ?>" disabled="disabled"
                                       data-readonly/>
                            </div>
                            <div class="stare-rate__resault"><?php echo e(number_format($adv_sum/$advs_ratings_count,1)); ?> من 5
                            </div>
                            <small><?php echo e($adv_ratings->count().' '.'تقييم'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div style="margin-top: 20px;" class="progress-content bg-wait min-height">
                            <div class="row rating-desc">
                                <?php for($p=5;$p>0;$p--): ?>
                                    <div class="col-xs-2 col-md-2 text-right star_progress_digree">
                                        <span class="fa fa-star checkedd hidden-xs"></span>
                                        <span class="visible-xs"></span>
                                        <?php echo e($p); ?>

                                    </div>
                                    <div class="col-xs-7 col-md-8">
                                        <div class="progress progress-striped">
                                            <div class="progress-bar progress-bar-success" aria-valuenow="20"
                                                 aria-valuemin="0" aria-valuemax="100"
                                                 style="width: <?php echo e(number_format((\App\Http\Controllers\AdvsController::get_adv_percent($adv->id, $p)*100)/$advs_ratings_count,2)); ?>%"><?php echo e(number_format((\App\Http\Controllers\AdvsController::get_adv_percent($adv->id, $p)*100)/$advs_ratings_count,2)); ?>

                                                %
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-md-2">
                                        <span class="rating_vote hidden-xs"> ( <?php echo e(\App\Http\Controllers\AdvsController::get_adv_percent($adv->id, $p)); ?>

                                            ) </span>
                                        <span class="rating_vote visible-xs"><?php echo e(\App\Http\Controllers\AdvsController::get_adv_percent($adv->id, $p)); ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <!-- end 5 -->
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                

                
                <?php if(!is_null($adv->lat) and !is_null($adv->lon)): ?>
                    <h3 class="pt-3">موقع الاعلان ع الخريطة : </h3>
                    <!--The div element for the map -->
                    <div id="map"></div>
                    <script>
                        // Initialize and add the map
                        function initMap() {
                            // The location of Uluru
                            var uluru = {lat: <?php echo e($adv->lat); ?>, lng: <?php echo e($adv->lon); ?>};
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
                        <h3>لم يحدد المعلن موقع الاعلان على الخريطة حتى الأن</h3>
                    </div>
                <?php endif; ?>
                

            </div>

            
            <div class="col-md-3 col-xs-12">
                <div class=" bg-color-silver border-all mt-3 p-3">
                    <h3>اعلانات مشابهة</h3>
                </div>
                <div class="bg-color-white border-all mt-1 pb-2">
                    <?php $__currentLoopData = $advs_; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adv_): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(url('/adv/'.$adv_->id)); ?>">
                            <div class="border-all m-3">
                                <img style="height: 200px; width: 300px;"
                                     class="img-responsive img-rounded border-bottom pb-2"
                                     src="<?php if(is_null(\App\Http\Controllers\AdvsController::get_adv_img($adv_->id))): ?> <?php echo e(asset('public/img/no_img.png')); ?> <?php else: ?> <?php echo e(asset(\App\Http\Controllers\AdvsController::get_adv_img($adv_->id)->img)); ?> <?php endif; ?>"
                                     alt="adv" title="adv"/>

                                <p class="color-gold font-large-bold m-3"><?php echo e($adv_->title); ?></p>
                            </div>
                        </a>
                        <!-- end first item for loop -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            
            <!-- end of content -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <script type="text/javascript">
        $(function () {
            SyntaxHighlighter.all();
        });
        $(window).load(function () {
            $('#carousel').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 210,
                itemMargin: 5,
                asNavFor: '#slider'
            });

            $('#slider').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                sync: "#carousel",
                start: function (slider) {
                    $('body').removeClass('loading');
                }
            });
        });
    </script>
    </body>
    </html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>