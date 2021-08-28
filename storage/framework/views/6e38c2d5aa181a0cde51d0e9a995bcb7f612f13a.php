<!DOCTYPE html>
<html dir="rtl" lang="ar" prefix="og: http://ogp.me/ns#">
<head>
    <!--<meta charset="utf-8">-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- search engine meta edit by elfnon.com-->
    <title><?php echo e(@$seo_title ?? 'حراج واحد'); ?> </title>
    <meta name="description" content="<?php echo e(@$seo_description ??  \App\Http\Controllers\SiteSettingsController::get_info()->description); ?>"/>
    <link rel="shortcut icon" href="<?php echo e(asset('public/img/favicon.ico')); ?>" type="image/x-icon">
    <link rel="canonical" href="<?php echo url()->current();; ?>" />
    <meta name="robots" content="noodp">
    <link rel="alternate" hreflang="ar-sa" href="<?php echo url()->current();; ?>">
    <meta name="format-detection" content="telephone=yes">
    <meta name="apple-mobile-web-app-title" content="حراج واحد">
    <meta name="application-name" content="<?php echo e(@$seo_title ?? 'حراج واحد'); ?>">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:image:width" content="174">
    <meta property="og:image:height" content="91">
    <meta property="og:url" content="<?php echo url()->current();; ?>">
    <meta property="og:title" content="<?php echo e(@$seo_title ?? 'حراج واحد'); ?>">
    <meta property="og:description" content="<?php echo e(@$seo_description ??  \App\Http\Controllers\SiteSettingsController::get_info()->description); ?>">
    <!--<meta name="keywords" content=""/>-->
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
        <a href="<?php echo e(url('/sections-map')); ?>" <?php if(Request::path() == '/sections-map'): ?> class="active" <?php else: ?> style="background-color: #F7F7F7" <?php endif; ?>>أقسام أكثر ...</a>
    </div>
    <div class="col-md-2 col-xs-12 bg-color-white">
        <div class="text-center col-xs-12">
            <ul class="list-inline" id="social-icons">
                <div class="color-grey2">
                    
                    <img alt="image" src="<?php echo e(asset('public/img/admin.png')); ?>">
                    <a href="<?php echo e(url('/login')); ?>">تسجيل الدخول</a>
                </div>
            </ul>
        </div>
    </div>
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
</section>
<!--End Header-->

<div class="container-fluid login_ register_bg">
        <div class="row">
            <?php if(request('msg')): ?>
                <div class="flash alert alert-danger" align="center" role="alert">يجب تسجيل الدخول أولا حتى تتم العملية
                    بنجاح
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="flash alert alert-danger" align="center" role="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php if(session('success')): ?>
                <div class="flash alert alert-success" align="center" role="alert"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('resend')): ?>
                <div class="alert alert-danger" align="center" role="alert">
                    <?php echo e(session('resend').' ... '); ?><a class="color-light-blue"
                                                      href="<?php echo e(url('/resend_active_code/'.session('msg1'))); ?>">التفعيل
                        الان</a>
                </div>
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
    <div class="col-md-6 col-md-offset-3 col-xs-12 register_div">
        <h3 class="text-center color-black">تسجيل الدخول<span class="pull-left font-large-bold">></span></h3>
        <form class="form-group" action="<?php echo e(route('do-login')); ?>" method="post">
            <?php echo csrf_field(); ?>


            <div class="form-group">
                <div class="row">
                    <label class="col-md-1 col-xs-2 text-center"><i class="fa fa-mobile fa-2x color-gold"></i></label>
                    <input name="name" type="text" class="form-control register_input col-md-11 col-xs-10" value="<?php echo e(old('name')); ?>"
                           placeholder="البريد الالكترونى أو الجوال" required="">
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="col-md-1 col-xs-2 text-center"><i class="fa fa-lock fa-2x color-gold"></i></label>
                    <input name="pass" type="password" class="form-control register_input col-md-11 col-xs-10" placeholder="كلمة المرور"
                           required="">
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 col-md-push-1 col-xs-6">
                        <label class="font-large-bold">
                            <input type="checkbox" name="remember_me" value="1">&nbsp;&nbsp;<span class="color-gold">تذكرنى</span>
                        </label>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <a class="color-gold pull-left" href="<?php echo e(url('/forget_password')); ?>">
                            <h4>نسيت كلمة المرور</h4>
                        </a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <button type="submit" class="btn btn-green btn-block">
                            <span class="font-large-bold hidden-xs">تسجيل الدخول</span>
                            <span class="visible-xs">تسجيل الدخول</span>
                        </button>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <a href="<?php echo e(url('/register')); ?>" type="button" class="btn btn-orange btn-block">
                            <span class="font-large-bold hidden-xs">انشاء حساب جديد</span>
                            <span class="visible-xs">انشاء حساب جديد</span>
                        </a>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <!-- end of content -->
    </div>


<!--Footer-->
<section id="footer-licence">
    <div class="container">
        <div class="row pt-1">
            <div class="text-center pt-3">
                <p>جميع الحقوق محفوظة لدى موقع <a href="<?php echo e(url('/')); ?>" class="color-gold">حراج واحد</a> &copy; <?php echo e(date('Y')); ?></p>
            </div>
        </div>
    </div>
</section>
<!--End Footer-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->


<script>window.jQuery || document.write('<script src="<?php echo e(asset('js/jquery-1.11.2.min.js')); ?>">\x3C/script>')</script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/script.js')); ?>"></script>

<!-- live search -->
<script src="<?php echo e(asset('js/bootstrap-select.js')); ?>"></script>

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
    $(document).ready(function(){
        $('#openModal').click();
    });
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135967571-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
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
            

            var url = '<?php echo e(url('/')); ?>' + '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section;
            $(".loading_me").empty().append('<div class="se-pre-con"></div>');
            window.location.href = url;
//            this.form.submit();
        });

        $('#advanced_search').on('click', function () {
            $('#search').focus();
        });
    });
</script>
</body>
</html>
