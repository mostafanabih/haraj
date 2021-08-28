<!DOCTYPE html>
<html dir="rtl" lang="ar" prefix="og: http://ogp.me/ns#">
<head>
    <!--<meta charset="utf-8">-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- search engine meta edit by elfnon.com-->
    <title>{{ @$seo_title ?? 'حراج واحد'}} </title>
    <meta name="description" content="{{ @$seo_description ??  \App\Http\Controllers\SiteSettingsController::get_info()->description }}"/>
    <link rel="shortcut icon" href="{{ asset('public/img/favicon.ico') }}" type="image/x-icon">
    <link rel="canonical" href="{!!  url()->current();  !!}" />
    <meta name="robots" content="noodp">
    <link rel="alternate" hreflang="ar-sa" href="{!!  url()->current();  !!}">
    <meta name="format-detection" content="telephone=yes">
    <meta name="apple-mobile-web-app-title" content="حراج واحد">
    <meta name="application-name" content="{{ @$seo_title ?? 'حراج واحد'}}">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:image:width" content="174">
    <meta property="og:image:height" content="91">
    <meta property="og:url" content="{!!  url()->current();  !!}">
    <meta property="og:title" content="{{ @$seo_title ?? 'حراج واحد'}}">
    <meta property="og:description" content="{{ @$seo_description ??  \App\Http\Controllers\SiteSettingsController::get_info()->description }}">
    <!--<meta name="keywords" content="{{--{{ \App\Http\Controllers\SiteSettingsController::get_info()->key_words }}--}}"/>-->
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
        <a href="{{ url('/sections-map') }}" @if(Request::path() == '/sections-map') class="active" @else style="background-color: #F7F7F7" @endif>أقسام أكثر ...</a>
    </div>
    <div class="col-md-2 col-xs-12 bg-color-white">
        <div class="text-center col-xs-12">
            <ul class="list-inline" id="social-icons">
                <div class="color-grey2">
                    {{--<i class="fa fa-user fa-1x"></i>--}}
                    <img alt="image" src="{{ asset('public/img/admin.png') }}">
                    <a href="{{ url('/login') }}">تسجيل الدخول</a>
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
</section>
<!--End Header-->

<div class="container-fluid pt-5 register_bg">
    <div class="row">
        @if(session('error'))
            <div class="flash alert alert-danger" align="center" role="alert">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="flash alert alert-success" align="center" role="alert">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="text-center alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- start of content -->
        <div class="col-md-6 col-md-offset-3 col-xs-12 register_div">
            <h3 class="text-center color-black">إنشاء حساب جديد<span class="pull-left font-large-bold">></span></h3>
            <form id="my_form" action="{{ route('do-register') }}" method="post" class="form-group">
                @csrf

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-1 col-xs-2 text-center"><i class="fa fa-user-o fa-2x color-gold"></i></label>
                        <input name="name" value="{{ old('name') }}" type="text" class="form-control register_input col-md-11 col-xs-10" placeholder="اسم المعلن" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-1 col-xs-2 text-center"><i class="fa fa-mobile fa-2x color-gold"></i></label>
                        <input name="mobile" value="{{ old('mobile') }}" type="text" class="form-control register_input col-md-11 col-xs-10" placeholder="الجوال">
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-1 col-xs-2 text-center"><i class="fa fa-envelope-o fa-2x color-gold"></i></label>
                        <input name="e_mail" value="{{ old('e_mail') }}" type="text" class="form-control register_input col-md-11 col-xs-10" placeholder="  البريد الالكتروني" required>
                    </div>
                </div>

                {{--<h3 class="text-center color-black">العنوان و الموقع على الخريطة</h3>--}}

                {{--<div class="col-md-6 col-xs-12">--}}
                    {{--<select class="form-control m-b selectpicker register_input" name="area" id="area"--}}
                            {{--data-live-search="true" required>--}}
                        {{--<option value="">اختر منطقة ...</option>--}}
                        {{--@foreach(\App\Http\Controllers\AreaController::getArea() as $area_)--}}
                            {{--<option value="{{ $area_->id }}" --}}{{--@if(old('area') == $area_->id) {{ 'selected' }} @endif--}}{{-->{{ $area_->name }}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class="col-md-6 col-xs-12 br_">--}}
                    {{--<select class="form-control m-b selectpicker register_input" name="city" id="city"--}}
                            {{--data-live-search="true" required>--}}
                        {{--<option value="">اختر مدينة ...</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class="clearfix"></div>--}}
                {{--<br>--}}

                {{--<div class="col-md-6 col-xs-12">--}}
                    {{--<input name="street" value="{{old('street')}}" type="text"--}}
                           {{--class="form-control register_input" placeholder="الحى ..." required>--}}
                {{--</div>--}}
                {{--<div class="col-md-6 col-xs-12 br_">--}}
                    {{--<input id="autocomplete_search" name="address" value="{{old('address')}}" type="text"--}}
                           {{--class="form-control register_input" placeholder="ابحث هنا عن موقعك ..." >--}}
                {{--</div>--}}
                {{--<div class="clearfix"></div>--}}
                {{--<br>--}}

                {{--<div class="col-md-6 col-xs-12">--}}
                    {{--<input readonly class="form-control register_input" type="hidden" name="lat" value="{{old('lat')}}" id="lat"--}}
                           {{--placeholder="خط الطول هنا ..." >--}}
                {{--</div>--}}
                {{--<div class="col-md-6 col-xs-12">--}}
                    {{--<input readonly class="form-control register_input" type="hidden" name="lon" value="{{old('lon')}}" id="long"--}}
                           {{--placeholder="خط العرض هنا ..." >--}}
                {{--</div>--}}
                {{--<div class="clearfix"></div>--}}
                {{--<br>--}}

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-1 col-xs-2 text-center"><i class="fa fa-lock fa-2x color-gold"></i></label>
                        <input name="pass" type="password" class="form-control register_input col-md-11 col-xs-10" placeholder="كلمة المرور" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-1 col-xs-2 text-center"><i class="fa fa-lock fa-2x color-gold"></i></label>
                        <input name="pass_confirmation" min="6" type="password" class="form-control register_input col-md-11 col-xs-10" placeholder="إعادة كلمة المرور" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-11 col-md-push-1 col-xs-12 font-large-bold">
                            <input type="checkbox" id="rules" name="rules" value="1" required>&nbsp;&nbsp;<span class="color-black">أوافق على جميع </span><a href="{{ url('/page/1') }}" target="_blank" class="color-gold" style="text-decoration: underline;">الشروط و الأحكام</a>
                        </label>
                    </div>

                    {{--<div class="color-black">{{ session('success').' - '.session('active_code').' - '.session('id').' - '.'DASFASDF' }}</div>--}}
                </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-xs-12">
                        <button type="button" id="my_btn" class="btn btn-green btn-block border-r-10"><h4>إنشاء</h4></button>
                    </div>
                </div>

            </form>
        </div>
        <!-- end of content -->

        @if(session('active_code') and session('id') and (session('success') or session('error')))
            <button type="button" id="openModal" class="hidden" data-toggle="modal"
                    data-target="#myModal"></button>

            {{-- enter code --}}
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <img alt="sms" src="{{ url('public/img/sms.png') }}">
                            @if(session('success'))
                                <h2 class="text-info">{{ session('success') }}</h2>
                            @endif
                            @if(session('error'))
                                <h2 class="text-danger">{{ session('error') }}</h2>
                            @endif
                            <h4 class="color-silver-darker">برجاء إدخال الكود المرسل اليكم</h4>
                            <form action="{{ route('confirm') }}" method="post">
                                @csrf
                                <input class="form-control mb-3" type="text" name="confirm_" placeholder="######" required>

                                <input type="hidden" name="advertiser_id" value="{{ session('id') }}">
                                <button type="submit" class="btn btn-green pr-5 pl-5"><span class="font-large-bold">ادخال</span></button>

                                {{--<a class="pull-left color-gold border-r-10" href="{{ url('/mail_confirm') }}">ليس لديك كود التفعيل</a>--}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success_login'))
            <button type="button" id="openModal" class="hidden" data-toggle="modal"
                    data-target="#myModal"></button>

            <!-- code is OK -->
            <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content">
            <div class="modal-body text-center">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <img alt="sms" src="{{ url('public/img/congrate.png') }}">
            <h3 class="color-black"><span class="color-gold">تهانينا </span>تم ادخال الكود بطريقة صحيحة</h3>
            <h3 class="color-gold">يمكنك تسجيل الدخول الأن</h3>
            <a href="{{ url('/login') }}" type="button" class="btn btn-green pr-5 pl-5 border-r-10"><span class="font-large-bold">تسجيل الدخول</span></a>
            </div>
            </div>
            <!-- end Modal content -->
            </div>
            </div>
        @endif
    </div>
</div>

<!--Footer-->
<section id="footer-licence">
    <div class="container">
        <div class="row pt-1">
            <div class="text-center pt-3">
                <p>جميع الحقوق محفوظة لدى موقع <a href="{{ url('/') }}" class="color-gold">حراج واحد</a> &copy; {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</section>
<!--End Footer-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}

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
    $(document).on('click', '#my_btn', function () {
        if (document.getElementById('rules').checked == false){
            alert('يجب الموافقة على الشروط والأحكام أولا');
        }else{
            $('#my_btn').html('<p class="text-center h4"><i class="fa fa-spinner fa-spin"></i> جاري الحفظ .....</p>');
            $('#my_form').submit();
        }
    });
</script>
<script>
    $(function () {
// seearch filter
        $('#btn_search').on('click', function () {
            var search = $('#search').val();
            var city = '{{ request('city') ?? 0 }}';
            var main_section = '{{ request('main_section') ?? 0 }}';
            var sub_section = '{{ request('sub_section') ?? 0 }}';
            {{--var internal_section = '{{ request('internal_section') ?? 0 }}';--}}

            var url = '{{ url('/') }}' + '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section;
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
    // area -> city
    $(function () {
        $('#area').on('change', function () {
            var area_id = $('#area option:selected').val();

            $.ajax({
                url: "{{ url('/bottom_filter3_') }}",
                type: "post",
                data: {
                    'area_id': area_id,
                    '_token': '{{ csrf_token() }}'
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
