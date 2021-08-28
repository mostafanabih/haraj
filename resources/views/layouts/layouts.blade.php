<!DOCTYPE html>
<html dir="rtl" lang="ar" prefix="og: http://ogp.me/ns#">
<head>
    <!--<meta charset="utf-8">-->
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- search engine meta edit by elfnon.com-->
    <title>{{ @$seo_title ?? 'حراج واحد'}} </title>
    <meta name="description"
          content="{{ @$seo_description ??  \App\Http\Controllers\SiteSettingsController::get_info()->description }}"/>
    <link rel="shortcut icon" href="{{ asset('public/img/favicon.ico') }}" type="image/x-icon">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="{!!  url()->current();  !!}"/>
    <meta name="robots" content="noodp">

    <link rel="alternate" hreflang="ar-sa" href="{!!  url()->current();  !!}">
    <meta name="format-detection" content="telephone=yes">

    <meta name="apple-mobile-web-app-title" content="حراج واحد">
    <meta name="application-name" content="{{ @$seo_title ?? 'حراج واحد'}}">


    <meta property="og:title" content="{{ @$seo_title ?? 'حراج واحد'}}">
    @yield('meta_img')
    <meta property="og:description"
          content="{{ @$seo_description ??  \App\Http\Controllers\SiteSettingsController::get_info()->description }}">
    <meta name="keywords" content="{{ \App\Http\Controllers\SiteSettingsController::get_info()->key_words }}"/>
    <!--<meta name="generator" content=""/>-->
    <!--<meta name="revisit-after" content="30 days"/>-->
    <!--<meta name="author" content=""/>-->
    <!--<meta name="robots" content="INDEX, FOLLOW"/>-->
    <!-- open graph meta-->
    <!-- live search -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.rtl.min.css') }}" rel="stylesheet">

    <!-- flex slider CSS -->
    <link rel="stylesheet" href="{{ asset('css/flexslider/flexslider.css') }}" type="text/css" media="screen"/>

    <!-- owl -->
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- style -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!--FONT Awesome-->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('style')

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
        <a href="{{ url('/') }}" @if(Request::path() == '/') class="active" @endif>الرئيسية </a>
        @foreach(\App\Http\Controllers\AdvsController::get_menus() as $key => $menu)
            <a href="{{ url('menu/'.$menu->name) }}"
               @if(urldecode(Request::path()) == 'menu/'.$menu->name) class="active" @endif>{{ $menu->name }}</a>
            @if($key > 4) @break @else @endif
        @endforeach
        <a id="advanced_search" style="background-color: #F7F7F7"><i class="fa fa-search"></i>&nbsp;&nbsp;البحث</a>
        <a href="{{ url('/ContactUs') }}" @if(Request::path() == 'ContactUs') class="active" @endif>اتصل بنا</a>
        <a href="{{ url('/sections-map') }}" @if(Request::path() == '/sections-map') class="active"
           @else style="background-color: #F7F7F7" @endif>أقسام أكثر ...</a>
    </div>
    <div class="col-md-2 col-xs-12 bg-color-white">
        <div class="text-center col-xs-12">
            @if(auth()->check())
                <div class="">
                    {{-- menu --}}
                    <div class="col-xs-12 color-grey2_">
                        <div class="">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <strong class="font-bold">أهلا <span>{{ auth()->user()->name }}</span></strong>
                            </a>
                            <ul class="dropdown-menu" style="right: auto !important;">
                                <li class="p-3 text-center">
                                    <img alt="logo" src="{{ asset('public/img/logo.png') }}">

                                </li>
                                <li class="divider"></li>

                                <li @if(Request::path() == 'home') class="active" @endif>
                                    <a href="{{ url('/home') }}"><i class="fa fa-user-o"></i>&nbsp;&nbsp;<b>الصفحة
                                            الشخصية</b></a>
                                </li>
                                <li class="divider"></li>

                                <li @if(Request::path() == 'AdvertiserNotifyController') class="active" @endif>
                                    <a href="{{ url('/AdvertiserNotifyController') }}">
                                        <i class="fa fa-bell-o"></i>&nbsp;&nbsp;<b>اشعارات</b>
                                        <span class="pull-left btn-orange border-r-50 pl-1 pr-1">{{ \App\Http\Controllers\AdvertiserNotifyController::get_notify(auth()->id()) }}</span>
                                    </a>
                                </li>
                                <li class="divider"></li>

                                <li @if(Request::path() == 'add_adv') class="active" @endif>
                                    <a href="{{ url('/add_adv') }}"><i
                                                class="fa fa-file"></i>&nbsp;&nbsp;<b>إعلاناتى</b></a>
                                </li>
                                <li class="divider"></li>

                                <li @if(Request::path() == 'messages') class="active" @endif>
                                    <a href="{{ url('/messages') }}">
                                        <i class="fa fa-envelope"></i>&nbsp;&nbsp;<b>الرسائل</b>
                                        <span class="pull-left btn-orange border-r-50 pl-1 pr-1">{{ \App\Http\Controllers\HomeController::get_messages() }}</span>
                                    </a>
                                </li>
                                <li class="divider"></li>

                                <li @if(Request::path() == 'add_subscription') class="active" @endif>
                                    <a href="{{ url('/add_subscription') }}"><i class="fa fa-globe"></i>&nbsp;&nbsp;<b>اشتراك
                                            بالموقع</b></a>
                                </li>
                                <li class="divider"></li>

                                <li @if(Request::path() == 'favourite') class="active" @endif>
                                    <a href="{{ url('/favourite') }}"><i
                                                class="fa fa-heart"></i>&nbsp;&nbsp;<b>الاعلانات المفضلة</b></a>
                                </li>
                                <li class="divider"></li>

                                <li @if(Request::path() == 'show_favourite_advertiser') class="active" @endif>
                                    <a href="{{ url('/show_favourite_advertiser') }}"><i
                                                class="fa fa-user-circle-o"></i>&nbsp;&nbsp;<b>المعلنين المفضلين</b></a>
                                </li>
                                <li class="divider"></li>

                                <li @if(Request::path() == 'followers') class="active" @endif>
                                    <a href="{{ url('/followers') }}"><i class="fa fa-address-book"></i>&nbsp;&nbsp;<b>عرض
                                            المتابعين</b></a>
                                </li>
                                <li class="divider"></li>

                                {{--<li @if(Request::path() == 'account_settings') class="active" @endif>--}}
                                {{--<a href="{{ url('/account_settings') }}"><i--}}
                                {{--class="fa fa-cogs"></i>&nbsp;&nbsp;<b>إعدادات الحساب</b></a>--}}
                                {{--</li>--}}
                                {{--<li class="divider"></li>--}}

                                <li @if(Request::path() == 'page/1') class="active" @endif>
                                    <a href="{{ url('/page/1') }}"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<b>الشروط
                                            و الأحكام</b></a>
                                </li>
                                <li class="divider"></li>
                                <li @if(Request::path() == 'page/2') class="active" @endif>
                                    <a href="{{ url('/page/2') }}"><i class="fa fa-thumbs-o-up"></i>&nbsp;&nbsp;<b>القسم
                                            على العمولة</b></a>
                                </li>
                                <li class="divider"></li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;<b>تسجيل
                                            الخروج</b>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <ul class="list-inline" id="social-icons">
                    <div class="color-grey2">
                        {{--<i class="fa fa-user fa-1x"></i>--}}
                        <img alt="image" src="{{ asset('public/img/admin.png') }}">
                        <a href="{{ url('/login') }}">تسجيل الدخول</a>
                    </div>
                </ul>
            @endif
        </div>
    </div>
    <div class="col-xs-12 bg-color-white pt-1"></div>
    <div class="clearfix"><br></div>

    <!-- Container -->
    <div id="section-header">
        <div class="container-fluid padding-r-l-50">
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <a href="{{url('/')}}">
                        <ul class="list-inline list-unstyled">
                            <li>
                                <img alt="logo" src="@if(is_null(\App\Http\Controllers\SiteSettingsController::get_info()->logo)) {{ asset('public/img/logo.png') }} @else {{ asset('public/img/'.\App\Http\Controllers\SiteSettingsController::get_info()->logo) }} @endif">
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
                                       value="@if(request('search')){{request('search')}}@endif"
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
                    @if(auth()->check())
                        <a href="{{ url('/add_adv/create') }}"
                           class="btn btn-orange border-r-50
                           @if(auth()->user()->roles == 1)
                               col-md-5
                           @else
                               col-md-12
                           @endif
                           col-xs-12">
                            <span class="fa fa-plus"></span>
                            &nbsp;&nbsp;<b style="">اضف اعلانك</b>
                        </a>
                    @else
                        <a href="{{ url('login?msg=log') }}"
                           class="btn btn-orange border-r-50 col-md-12 col-xs-12">
                            <span class="fa fa-plus"></span>
                            &nbsp;&nbsp;<b style="">اضف اعلانك</b>
                        </a>
                    @endif


                    @if(auth()->check() and auth()->user()->roles == 1)
                        <a href="{{ url('/dashboard') }}"
                           class="btn btn-green border-r-50 col-md-5 col-xs-12">
                            <span class="fa fa-globe"></span>
                            &nbsp;&nbsp;<b style="">لوحة التحكم</b>
                        </a>
                    @else
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    @yield('content')


            <!--Footer-->
    <section id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <a href="{{url('/')}}">
                        <ul class="list-inline list-unstyled">
                            <li>
                                <img alt="logo" src="@if(is_null(\App\Http\Controllers\SiteSettingsController::get_info()->logo)) {{ asset('public/img/logo.png') }} @else {{ asset('public/img/'.\App\Http\Controllers\SiteSettingsController::get_info()->logo) }} @endif">
                            </li>
                            <li class="">
                                <h3 class="color-gold">حراج واحد</h3>
                                <h5 class="color-gold">كل المطلوب بين يديك</h5>
                            </li>
                        </ul>
                    </a>
                    <h4 class="pt-1 color-gold">{{ \App\Http\Controllers\SiteSettingsController::get_info()->name }}</h4>

                    <p>{{ \App\Http\Controllers\SiteSettingsController::get_info()->description }}</p>
                </div>

                <div class="col-md-6 color-grey2_">
                    @php
                    $count = \App\Http\Controllers\FixedPagesController::get_pages()->count();
                    @endphp
                    @foreach(\App\Http\Controllers\FixedPagesController::get_pages() as $page)
                        <div class="col-md-6">
                            <a href="{{ url('/page/'.$page->id) }}"><h4>{{ $page->title }}</h4></a>
                        </div>
                    @endforeach
                    <div class="col-md-6">
                        <a href="{{ url('/ContactUs') }}"><h4>اتصل بنا</h4></a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ url('/find_black_list') }}"><h4>القائمة السوداء</h4></a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ Route('commission') }}"><h4> دفع العموله</h4></a>
                    </div>
                </div>

                <div class="col-md-2 color-grey2_ text-center">
                    <div class="pt-4" style="text-align: -webkit-center;">
                        <a target="_blank" href="{{ \App\Http\Controllers\SiteSettingsController::get_info()->google_play }}">
                            <img class="img-responsive" src="{{ asset('public/img/googel-play.png') }}">
                        </a>
                        <img class="img-responsive width-48" src="{{ asset('public/img/google-play-QR.jpg') }}">
                    </div>

                    <div class="pt-3" style="text-align: -webkit-center;">
                        <a target="_blank" href="{{ \App\Http\Controllers\SiteSettingsController::get_info()->app_store }}">
                            <img class="img-responsive" src="{{ asset('public/img/app-store.png') }}">
                        </a>
                        <img class="img-responsive width-48" src="{{ asset('public/img/app-store-QR.jpg') }}">
                    </div>

                    <div class="pt-3">
                        <h4 class="color-gold">تابعنا على</h4>

                        <div class="">
                            <ul class="list-inline">
                                <a target="_blank" class="color-grey"
                                   href="{{ \App\Http\Controllers\SiteSettingsController::get_info()->facebook }}">
                                    <li class="fa fa-facebook fa-lg px-2"></li>
                                </a>
                                <a target="_blank" class="color-grey"
                                   href="{{ \App\Http\Controllers\SiteSettingsController::get_info()->twitter }}">
                                    <li class="fa fa-twitter fa-lg px-2"></li>
                                </a>
                                <a target="_blank" class="color-grey"
                                   href="{{ \App\Http\Controllers\SiteSettingsController::get_info()->youtube }}">
                                    <li class="fa fa-youtube fa-lg px-2"></li>
                                </a>
                                <a target="_blank" class="color-grey"
                                   href="{{ \App\Http\Controllers\SiteSettingsController::get_info()->whatsapp }}">
                                    <li class="fa fa-whatsapp fa-lg px-2"></li>
                                </a>
                                <a target="_blank" class="color-grey"
                                   href="{{ \App\Http\Controllers\SiteSettingsController::get_info()->instagram }}">
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
                    <p>جميع الحقوق محفوظة لدى موقع <a href="{{ url('/') }}" class="color-gold">حراج واحد</a>
                        &copy; {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </section>

    @if(session()->has('update_phone') && date('Y-m-d') < date('Y-m-d', strtotime('2019-03-25')) && url()->current() != url('/account_settings'))
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
        @endif

                <!--End Footer-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
        {{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"></script>--}}
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmT97qMPjKdidWGuTUr8c9KC2l4sVUcNs&amp;libraries=places"></script>

        <script>
            /* rest of map code is at => js/script.js */
        </script>

        <script>window.jQuery || document.write('<script src="{{ asset('js/jquery-1.11.2.min.js') }}">\x3C/script>')</script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>

        <!-- live search -->
        <script src="{{ asset('js/bootstrap-select.js') }}"></script>

        <!-- stars -->
        <script src="{{ asset('js/bootstrap-rating.js') }}" type="application/javascript"></script>
        <!-- Flex Slider -->
        <script defer src="{{ asset('js/flexslider/jquery.flexslider.js') }}"></script>
        <!-- owl Slider -->
        <script src="{{ asset('js/owl.carousel.js') }}"></script>

        <!-- summernote -->
        <script src="{{ asset('js/summernote/summernote.min.js') }}"></script>
        <script src="{{ asset('js/summernote/lang/summernote-ar-AR.js') }}"></script>

        <!-- loader -->
        <script src="{{ asset('js/loader.js') }}"></script>

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
                    var city = '{{ request('city') ?? 0 }}';
                    var main_section = '{{ request('main_section') ?? 0 }}';
                    var sub_section = '{{ request('sub_section') ?? 0 }}';
                    var internal_section = '{{ request('internal_section') ?? 0 }}';

                    var url = '{{ url('/') }}' + '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section /*+ '&internal_section=' + internal_section*/;
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

@yield('footer')
