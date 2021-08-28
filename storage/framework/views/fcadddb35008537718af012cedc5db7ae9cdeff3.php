<!DOCTYPE html>
<html dir="rtl" lang="ar" prefix="og: http://ogp.me/ns#">
<head>
    <!--<meta charset="utf-8">-->
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- search engine meta edit by elfnon.com-->
    <title><?php echo e(@$seo_title ?? 'حراج واحد'); ?> </title>
    <meta name="description"
          content="<?php echo e(@$seo_description ??  \App\Http\Controllers\SiteSettingsController::get_info()->description); ?>"/>
    <link rel="shortcut icon" href="<?php echo e(asset('public/img/favicon.ico')); ?>" type="image/x-icon">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="<?php echo url()->current();; ?>"/>
    <meta name="robots" content="noodp">

    <link rel="alternate" hreflang="ar-sa" href="<?php echo url()->current();; ?>">
    <meta name="format-detection" content="telephone=yes">

    <meta name="apple-mobile-web-app-title" content="حراج واحد">
    <meta name="application-name" content="<?php echo e(@$seo_title ?? 'حراج واحد'); ?>">


    <meta property="og:title" content="<?php echo e(@$seo_title ?? 'حراج واحد'); ?>">
    <?php echo $__env->yieldContent('meta_img'); ?>
    <meta property="og:description"
          content="<?php echo e(@$seo_description ??  \App\Http\Controllers\SiteSettingsController::get_info()->description); ?>">
    <meta name="keywords" content="<?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->key_words); ?>"/>
    <!--<meta name="generator" content=""/>-->
    <!--<meta name="revisit-after" content="30 days"/>-->
    <!--<meta name="author" content=""/>-->
    <!--<meta name="robots" content="INDEX, FOLLOW"/>-->
    <!-- open graph meta-->
    <!-- live search -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-select.css')); ?>">

    <!-- Bootstrap -->
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/bootstrap.rtl.min.css')); ?>" rel="stylesheet">

    <!-- flex slider CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/flexslider/flexslider.css')); ?>" type="text/css" media="screen"/>

    <!-- owl -->
    <link href="<?php echo e(asset('css/owl.carousel.min.css')); ?>" rel="stylesheet">

    <!-- style -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">

    <!--FONT Awesome-->
    <link href="<?php echo e(asset('font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php echo $__env->yieldContent('style'); ?>

    <script>
        window.setTimeout(function () {
            $(".flash").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 3000);
    </script>
</head>
<body>
<div class="se-pre-con"></div>
<div class="loading_me"></div>
<!--Header-->
<section>
    <!-- Menu & login -->
    <div class="scrollmenu col-md-10 col-xs-12">
        <a href="<?php echo e(url('/')); ?>" <?php if(Request::path() == '/'): ?> class="active" <?php endif; ?>>الرئيسية </a>
        <?php $__currentLoopData = \App\Http\Controllers\AdvsController::get_menus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(url('menu/'.$menu->name)); ?>"
               <?php if(urldecode(Request::path()) == 'menu/'.$menu->name): ?> class="active" <?php endif; ?>><?php echo e($menu->name); ?></a>
            <?php if($key > 4): ?> <?php break; ?> <?php else: ?> <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <a id="advanced_search" style="background-color: #F7F7F7"><i class="fa fa-search"></i>&nbsp;&nbsp;البحث</a>
        <a href="<?php echo e(url('/ContactUs')); ?>" <?php if(Request::path() == 'ContactUs'): ?> class="active" <?php endif; ?>>اتصل بنا</a>
        <a href="<?php echo e(url('/sections-map')); ?>" <?php if(Request::path() == '/sections-map'): ?> class="active"
           <?php else: ?> style="background-color: #F7F7F7" <?php endif; ?>>أقسام أكثر ...</a>
    </div>
    <div class="col-md-2 col-xs-12 bg-color-white">
        <div class="text-center col-xs-12">
            <?php if(auth()->check()): ?>
                <div class="">
                    
                    <div class="col-xs-12 color-grey2_">
                        <div class="">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <strong class="font-bold">أهلا <span><?php echo e(auth()->user()->name); ?></span></strong>
                            </a>
                            <ul class="dropdown-menu" style="right: auto !important;">
                                <li class="p-3 text-center">
                                    <img alt="logo" src="<?php echo e(asset('public/img/logo.png')); ?>">

                                </li>
                                <li class="divider"></li>

                                <li <?php if(Request::path() == 'home'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/home')); ?>"><i class="fa fa-user-o"></i>&nbsp;&nbsp;<b>الصفحة
                                            الشخصية</b></a>
                                </li>
                                <li class="divider"></li>

                                <li <?php if(Request::path() == 'AdvertiserNotifyController'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/AdvertiserNotifyController')); ?>">
                                        <i class="fa fa-bell-o"></i>&nbsp;&nbsp;<b>اشعارات</b>
                                        <span class="pull-left btn-orange border-r-50 pl-1 pr-1"><?php echo e(\App\Http\Controllers\AdvertiserNotifyController::get_notify(auth()->id())); ?></span>
                                    </a>
                                </li>
                                <li class="divider"></li>

                                <li <?php if(Request::path() == 'add_adv'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/add_adv')); ?>"><i
                                                class="fa fa-file"></i>&nbsp;&nbsp;<b>إعلاناتى</b></a>
                                </li>
                                <li class="divider"></li>

                                <li <?php if(Request::path() == 'messages'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/messages')); ?>">
                                        <i class="fa fa-envelope"></i>&nbsp;&nbsp;<b>الرسائل</b>
                                        <span class="pull-left btn-orange border-r-50 pl-1 pr-1"><?php echo e(\App\Http\Controllers\HomeController::get_messages()); ?></span>
                                    </a>
                                </li>
                                <li class="divider"></li>

                                <li <?php if(Request::path() == 'add_subscription'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/add_subscription')); ?>"><i class="fa fa-globe"></i>&nbsp;&nbsp;<b>اشتراك
                                            بالموقع</b></a>
                                </li>
                                <li class="divider"></li>

                                <li <?php if(Request::path() == 'favourite'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/favourite')); ?>"><i
                                                class="fa fa-heart"></i>&nbsp;&nbsp;<b>الاعلانات المفضلة</b></a>
                                </li>
                                <li class="divider"></li>

                                <li <?php if(Request::path() == 'show_favourite_advertiser'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/show_favourite_advertiser')); ?>"><i
                                                class="fa fa-user-circle-o"></i>&nbsp;&nbsp;<b>المعلنين المفضلين</b></a>
                                </li>
                                <li class="divider"></li>

                                <li <?php if(Request::path() == 'followers'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/followers')); ?>"><i class="fa fa-address-book"></i>&nbsp;&nbsp;<b>عرض
                                            المتابعين</b></a>
                                </li>
                                <li class="divider"></li>

                                
                                
                                
                                
                                

                                <li <?php if(Request::path() == 'page/1'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/page/1')); ?>"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<b>الشروط
                                            و الأحكام</b></a>
                                </li>
                                <li class="divider"></li>
                                <li <?php if(Request::path() == 'page/2'): ?> class="active" <?php endif; ?>>
                                    <a href="<?php echo e(url('/page/2')); ?>"><i class="fa fa-thumbs-o-up"></i>&nbsp;&nbsp;<b>القسم
                                            على العمولة</b></a>
                                </li>
                                <li class="divider"></li>

                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;<b>تسجيل
                                            الخروج</b>
                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <ul class="list-inline" id="social-icons">
                    <div class="color-grey2">
                        
                        <img alt="image" src="<?php echo e(asset('public/img/admin.png')); ?>">
                        <a href="<?php echo e(url('/login')); ?>">تسجيل الدخول</a>
                    </div>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-xs-12 bg-color-white pt-1"></div>
    <div class="clearfix"><br></div>

    <!-- Container -->
    <div id="section-header">
        <div class="container-fluid padding-r-l-50">
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <a href="<?php echo e(url('/')); ?>">
                        <ul class="list-inline list-unstyled">
                            <li>
                                <img alt="logo" src="<?php if(is_null(\App\Http\Controllers\SiteSettingsController::get_info()->logo)): ?> <?php echo e(asset('public/img/logo.png')); ?> <?php else: ?> <?php echo e(asset('public/img/'.\App\Http\Controllers\SiteSettingsController::get_info()->logo)); ?> <?php endif; ?>">
                            </li>
                            <li class="">
                                <h3 class="color-gold">حراج واحد</h3>
                                <h5 class="color-gold">كل المطلوب بين يديك</h5>
                            </li>
                        </ul>
                    </a>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 br_bottom text-center padding-top-20">
                    <div class="relative">
                        <form>
                            <div class="input-group">
                                <input id="search" name="search"
                                       value="<?php if(request('search')): ?><?php echo e(request('search')); ?><?php endif; ?>"
                                       class="form-control bg-search input-lg" type="text"
                                       placeholder="ابحث هنا ...">
                                    <span class="input-group-btn">
                                    <button id="btn_search" class="btn btn-default bg-search" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12 btn--sec text-center padding-top-20">
                    <?php if(auth()->check()): ?>
                        <a href="<?php echo e(url('/add_adv/create')); ?>"
                           class="btn btn-orange border-r-50
                           <?php if(auth()->user()->roles == 1): ?>
                               col-md-5
                           <?php else: ?>
                               col-md-12
                           <?php endif; ?>
                           col-xs-12">
                            <span class="fa fa-plus"></span>
                            &nbsp;&nbsp;<b style="">اضف اعلانك</b>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(url('login?msg=log')); ?>"
                           class="btn btn-orange border-r-50 col-md-12 col-xs-12">
                            <span class="fa fa-plus"></span>
                            &nbsp;&nbsp;<b style="">اضف اعلانك</b>
                        </a>
                    <?php endif; ?>


                    <?php if(auth()->check() and auth()->user()->roles == 1): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>"
                           class="btn btn-green border-r-50 col-md-5 col-xs-12">
                            <span class="fa fa-globe"></span>
                            &nbsp;&nbsp;<b style="">لوحة التحكم</b>
                        </a>
                    <?php else: ?>
                    <?php endif; ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    <?php echo $__env->yieldContent('content'); ?>


            <!--Footer-->
    <section id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <a href="<?php echo e(url('/')); ?>">
                        <ul class="list-inline list-unstyled">
                            <li>
                                <img alt="logo" src="<?php if(is_null(\App\Http\Controllers\SiteSettingsController::get_info()->logo)): ?> <?php echo e(asset('public/img/logo.png')); ?> <?php else: ?> <?php echo e(asset('public/img/'.\App\Http\Controllers\SiteSettingsController::get_info()->logo)); ?> <?php endif; ?>">
                            </li>
                            <li class="">
                                <h3 class="color-gold">حراج واحد</h3>
                                <h5 class="color-gold">كل المطلوب بين يديك</h5>
                            </li>
                        </ul>
                    </a>
                    <h4 class="pt-1 color-gold"><?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->name); ?></h4>

                    <p><?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->description); ?></p>
                </div>

                <div class="col-md-6 color-grey2_">
                    <?php
                    $count = \App\Http\Controllers\FixedPagesController::get_pages()->count();
                    ?>
                    <?php $__currentLoopData = \App\Http\Controllers\FixedPagesController::get_pages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <a href="<?php echo e(url('/page/'.$page->id)); ?>"><h4><?php echo e($page->title); ?></h4></a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <a href="<?php echo e(url('/ContactUs')); ?>"><h4>اتصل بنا</h4></a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo e(url('/find_black_list')); ?>"><h4>القائمة السوداء</h4></a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo e(Route('commission')); ?>"><h4> دفع العموله</h4></a>
                    </div>
                </div>

                <div class="col-md-2 color-grey2_ text-center">
                    <div class="pt-4" style="text-align: -webkit-center;">
                        <a target="_blank" href="<?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->google_play); ?>">
                            <img class="img-responsive" src="<?php echo e(asset('public/img/googel-play.png')); ?>">
                        </a>
                        <img class="img-responsive width-48" src="<?php echo e(asset('public/img/google-play-QR.jpg')); ?>">
                    </div>

                    <div class="pt-3" style="text-align: -webkit-center;">
                        <a target="_blank" href="<?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->app_store); ?>">
                            <img class="img-responsive" src="<?php echo e(asset('public/img/app-store.png')); ?>">
                        </a>
                        <img class="img-responsive width-48" src="<?php echo e(asset('public/img/app-store-QR.jpg')); ?>">
                    </div>

                    <div class="pt-3">
                        <h4 class="color-gold">تابعنا على</h4>

                        <div class="">
                            <ul class="list-inline">
                                <a target="_blank" class="color-grey"
                                   href="<?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->facebook); ?>">
                                    <li class="fa fa-facebook fa-lg px-2"></li>
                                </a>
                                <a target="_blank" class="color-grey"
                                   href="<?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->twitter); ?>">
                                    <li class="fa fa-twitter fa-lg px-2"></li>
                                </a>
                                <a target="_blank" class="color-grey"
                                   href="<?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->youtube); ?>">
                                    <li class="fa fa-youtube fa-lg px-2"></li>
                                </a>
                                <a target="_blank" class="color-grey"
                                   href="<?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->whatsapp); ?>">
                                    <li class="fa fa-whatsapp fa-lg px-2"></li>
                                </a>
                                <a target="_blank" class="color-grey"
                                   href="<?php echo e(\App\Http\Controllers\SiteSettingsController::get_info()->instagram); ?>">
                                    <li class="fa fa-instagram fa-lg px-2"></li>
                                </a>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section id="footer-licence">
        <div class="container-fluid padding-r-l-50">
            <div class="row">
                <div class="text-center pt-3">
                    <p>جميع الحقوق محفوظة لدى موقع <a href="<?php echo e(url('/')); ?>" class="color-gold">حراج واحد</a>
                        &copy; <?php echo e(date('Y')); ?></p>
                </div>
            </div>
        </div>
    </section>

    <?php if(session()->has('update_phone') && date('Y-m-d') < date('Y-m-d', strtotime('2019-03-25')) && url()->current() != url('/account_settings')): ?>
        <button type="button" id="openModal" class="hidden" data-toggle="modal"
                data-target="#myModal"></button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <p class="text-danger text-center">يرجي الذهاب الي اعدادات الحساب وتأكيد رقم الجوال قبل
                            2019-03-25 حتي لا يتم ايقاف الحساب</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                    </div>
                </div>

            </div>
        </div>
        <?php endif; ?>

                <!--End Footer-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        
        
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmT97qMPjKdidWGuTUr8c9KC2l4sVUcNs&amp;libraries=places"></script>

        <script>
            /* rest of map code is at => js/script.js */
        </script>

        <script>window.jQuery || document.write('<script src="<?php echo e(asset('js/jquery-1.11.2.min.js')); ?>">\x3C/script>')</script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/script.js')); ?>"></script>

        <!-- live search -->
        <script src="<?php echo e(asset('js/bootstrap-select.js')); ?>"></script>

        <!-- stars -->
        <script src="<?php echo e(asset('js/bootstrap-rating.js')); ?>" type="application/javascript"></script>
        <!-- Flex Slider -->
        <script defer src="<?php echo e(asset('js/flexslider/jquery.flexslider.js')); ?>"></script>
        <!-- owl Slider -->
        <script src="<?php echo e(asset('js/owl.carousel.js')); ?>"></script>

        <!-- summernote -->
        <script src="<?php echo e(asset('js/summernote/summernote.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/summernote/lang/summernote-ar-AR.js')); ?>"></script>

        <!-- loader -->
        <script src="<?php echo e(asset('js/loader.js')); ?>"></script>

        <script>
            $(document).ready(function () {
                var z = $('ul.pagination').find('li').length;
                $('ul.pagination').find('li').each(function (i) {

                    if (i == 0) {
                        $(this).find('span').html('<< <span class="hidden-xs">السابق</span>');
                        $(this).find('a').html('<< <span class="hidden-xs">السابق</span>');
                        // $(this).find('a')addClass('pag-f').text('<< السابق');
                    }
                    if (i == z - 1) {
                        $(this).find('span').html('<span class="hidden-xs">التالي</span> >>');
                        $(this).find('a').html('<span class="hidden-xs">التالي</span> >>');
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#openModal').click();
            });
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135967571-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-135967571-1');
        </script>
        <script>
            $(function () {
// seearch filter
                $('#btn_search').on('click', function () {
                    var search = $('#search').val();
                    var city = '<?php echo e(request('city') ?? 0); ?>';
                    var main_section = '<?php echo e(request('main_section') ?? 0); ?>';
                    var sub_section = '<?php echo e(request('sub_section') ?? 0); ?>';
                    var internal_section = '<?php echo e(request('internal_section') ?? 0); ?>';

                    var url = '<?php echo e(url('/')); ?>' + '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section /*+ '&internal_section=' + internal_section*/;
                    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                    window.location.href = url;
//            this.form.submit();
                });

                $('#advanced_search').on('click', function () {
                    $('#search').focus();
                });
            });
        </script>
        <script>
            $(document).on('click', '#my_submit_form_btn', function () {
                $('#my_submit_form_btn').html('<p class="text-center h4"><i class="fa fa-spinner fa-spin"></i> جاري الحفظ .....</p>');
                $('#my_submit_form').submit();
            });
        </script>

<?php echo $__env->yieldContent('footer'); ?>
