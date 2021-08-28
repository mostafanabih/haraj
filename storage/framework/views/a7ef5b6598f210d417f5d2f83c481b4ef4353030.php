<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>لوحة التحكم</title>
    <link rel="shortcut icon" href="<?php echo e(asset('public/img/favicon.ico')); ?>" type="image/x-icon">

    <!-- live search -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-select.css')); ?>">
    <link href="<?php echo e(asset('css/font-awesome.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">

    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo e(asset('css/summernote/summernote.css')); ?>">

    <!-- calendar -->
    <link href="<?php echo e(asset('css/calenders/jquery.calendars.picker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/calenders/bootstrap-datetimepicker-standalone.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/calenders/datepicker3.css')); ?>" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/bootstrap.rtl.min.css')); ?>" rel="stylesheet">

    <!--FONT Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- style -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">



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
<section id="section-header" class="container-fluid CF" style="padding-top: 5px;">
    <!-- Container -->
    <div class="container-fluid">
        <div class="row" id="header-main">
            <div class="col-md-4 col-xs-12" id="header-logo">
                <a href="<?php echo e(url('/')); ?>">
                    <img alt="logo" src="<?php echo e(asset('public/img/logo.png')); ?>" width="45%" class="main-img">
                </a>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="text-center">
                    <?php if(auth()->check()): ?>
                        <div class="pulling-left">
                            <div class="">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret" style="color:#0473C0"></span>
                                    <strong class="font-bold" style="color:#0473C0">أهلا <span><?php echo e(auth()->user()->name); ?></span></strong>
                                </a>
                                <ul class="dropdown-menu" style="right: auto;">


                                    <li <?php if(Request::path() == 'home'): ?> class="active" <?php endif; ?>>
                                        <a href="<?php echo e(url('/home')); ?>">حسابى</a>
                                    </li>
                                    <li <?php if(Request::path() == 'add_adv'): ?> class="active" <?php endif; ?>>
                                        <a href="<?php echo e(url('/add_adv')); ?>">إعلاناتى</a>
                                    </li>

                                    <?php if(\App\Advertiser::can_me(10)): ?>
                                        <li <?php if(Request::path() == 'site_settings'): ?> class="active" <?php endif; ?>>
                                            <a href="<?php echo e(url('/site_settings')); ?>">اعدادات الموقع </a>
                                        </li>
                                        <li class="divider"></li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <?php if(\App\Advertiser::can_me(11)): ?>
                                        <li <?php if(Request::path() == 'black_list'): ?> class="active" <?php endif; ?>>
                                            <a href="<?php echo e(url('/black_list')); ?>">القائمة السوداء</a>
                                        </li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <?php if(\App\Advertiser::can_me(12)): ?>
                                        <li <?php if(Request::path() == 'contact_us'): ?> class="active" <?php endif; ?>>
                                            <a href="<?php echo e(url('/contact_us')); ?>">رسائل التواصل معنا</a>
                                        </li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    
                                        
                                            
                                        
                                        
                                    
                                    

                                    <?php if(\App\Advertiser::can_me(14)): ?>
                                        <li <?php if(Request::path() == 'reporting_reasons'): ?> class="active" <?php endif; ?>>
                                            <a href="<?php echo e(url('/reporting_reasons')); ?>">أسباب البلاغات</a>
                                        </li>
                                        <li class="divider"></li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">تسجيل الخروج
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
                </div>
            <div class="col-md-4 col-xs-12">
                <ul class="nav navbar-left pt-2">
                    <li><a href="<?php echo e(url('/')); ?>" class="btn btn-green border-r-50"><span
                                    class="fa fa-globe px-2"></span>الموقع</a></li>
                </ul>
            </div>
            </div>
                <!-- /.navbar-collapse -->
        <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-default mt-1">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <!--<a class="navbar-brand" href="#">Brand</a>-->
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="scrollmenu collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li><a href="<?php echo e(url('/dashboard')); ?>">الرئيسيه</a></li>
                                    <?php if(\App\Advertiser::can_me(1)): ?>
                                        <li><a href="<?php echo e(url('/adv_action')); ?>">الاعلانات</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <?php if(\App\Advertiser::can_me(2)): ?>
                                        <li><a href="<?php echo e(url('/main-sections')); ?>">الاقسام </a></li>
                                    <?php else: ?>
                                    <?php endif; ?>
                                    <?php if(\App\Advertiser::can_me(15)): ?>
                                        <li><a href="<?php echo e(url('/area')); ?>">المناطق</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>
                                    <?php if(\App\Advertiser::can_me(3)): ?>
                                        <li><a href="<?php echo e(url('/cities')); ?>">المدن </a></li>
                                    <?php else: ?>
                                    <?php endif; ?>
                                    <?php if(\App\Advertiser::can_me(4)): ?>
                                        <li><a href="<?php echo e(url('/advertisers')); ?>">المستخدمين</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>
                                    <?php if(\App\Advertiser::can_me(5)): ?>
                                        <li><a href="<?php echo e(url('/notification')); ?>">اشعارات</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <?php if(\App\Advertiser::can_me(6)): ?>
                                        <li><a href="<?php echo e(url('/register-request')); ?>">طلبات الاشتراك</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <?php if(\App\Advertiser::can_me(7)): ?>
                                        <li><a href="<?php echo e(url('/packages')); ?>">باقات الاشتراك</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <?php if(\App\Advertiser::can_me(8)): ?>
                                        <li><a href="<?php echo e(url('/fixed_pages')); ?>">الصفحات الثابتة</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <?php if(\App\Advertiser::can_me(9)): ?>
                                        <li><a href="<?php echo e(url('/reports')); ?>">البلاغات</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>

                                    <?php if(\App\Advertiser::can_me(123)): ?>
                                        <li><a href="<?php echo e(url('/permissions')); ?>">صلاحيات المشرفين</a></li>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </ul>
                            </div><!-- /.container-fluid -->
                        </div>
                    </nav>
                </div>
            <?php else: ?>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php echo $__env->yieldContent('content'); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo e(asset('js/jquery-1.11.2.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/script.js')); ?>"></script>
<!-- live search -->
<script src="<?php echo e(asset('js/bootstrap-select.js')); ?>"></script>

<!-- calendar -->
<script src="<?php echo e(asset('js/calenders/jquery.calendars.js')); ?>"></script>
<script src="<?php echo e(asset('js/calenders/jquery.calendars.plus.js')); ?>"></script>
<script src="<?php echo e(asset('js/calenders/jquery.plugin.js')); ?>"></script>
<script src="<?php echo e(asset('js/calenders/jquery.calendars.picker.js')); ?>"></script>
<script src="<?php echo e(asset('js/calenders/jquery.calendars.ummalqura.js')); ?>"></script>
<script src="<?php echo e(asset('js/calenders/jquery.calendars.ummalqura-ar.js')); ?>"></script>

<!-- summernote -->
<script src="<?php echo e(asset('js/summernote/summernote.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/summernote/lang/summernote-ar-AR.js')); ?>"></script>

<!-- loader -->
<script src="<?php echo e(asset('js/loader.js')); ?>"></script>

<script>
    $(function () {
        $(".date").calendarsPicker({
            calendar: $.calendars.instance('gregorian'),
            dateFormat: 'Y-mm-dd',
            defaultDate: '0',
            alignment: 'bottom',
            firstDay: 6,
            isRTL: true,
            selectDefaultDate: false
        });
    })
</script>
<script>
    $(document).on('click', '#my_submit_form_btn', function () {
        $('#my_submit_form_btn').html('<p class="text-center h4"><i class="fa fa-spinner fa-spin"></i> جاري الحفظ .....</p>');
        $('#my_submit_form').submit();
    });
</script>
<?php echo $__env->yieldContent('footer'); ?>
