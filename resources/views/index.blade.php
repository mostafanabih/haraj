@extends('layouts.layouts')

@section('content')
    <!--End Header-->


    <div class="container-fluid padding-r-l-50">
        <div class="row my_div">
            <!--Sidebar-->

            <div class="col-md-3 mt-1 mb-1">
                <div class="row">
                    <div class="text-center">
                        <!--filter-->
                        <div id="div-filter">
                            <h2 class="color-grey">أبحث هنا</h2>
                            <div class="col-sm-12">
                                <form class="form-group">
                                    <div class="form-group pb-3">
                                        <select class="form-control m-b selectpicker" name="car_brand" id="car_brand"
                                                data-live-search="true" required>
                                            <option value="">اختر ماركة السيارة ...</option>
                                            @foreach($sub_sections as $sub)
                                                <option @if(request('car_brand') == $sub->id) selected
                                                        @endif value="{{ $sub->id }}">{{ $sub->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group pb-3">
                                        <select class="form-control m-b selectpicker car_type" name="car_type" id="car_type" required>
                                            <option value="0">اختر نوع السيارة</option>
                                            @foreach(\App\Http\Controllers\AdvsController::get_menus_internal(1, request('car_type')) as $internal_)
                                                <option @if(request('car_type') == $internal_->id) selected
                                                        @endif value="{{$internal_->id}}">{{$internal_->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group pb-3">
                                        <select class="form-control m-b selectpicker" name="car_year" data-live-search="true" required>
                                            <option @if(request('car_year') == 0) selected @endif value="0">كل الموديلات</option>
                                            @for($y=\Carbon\Carbon::now()->year;$y>1969;$y--)
                                                <option @if(request('car_year') == $y) selected
                                                        @endif value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <button style="background-color: #9D752F;border-color: #9D752F; !important;" class="btn btn-orange-darker text-center btn-block border-r-10">بحث&nbsp;&nbsp;<i class="fa fa-search px-2"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <!--End filter-->
                    </div>
                    <div class="clearfix pb-1"></div>


                    <!--brand Box-->
                    <div id="brands" class="overflow-hidden bg-white">
                        @foreach($sub_sections as $key => $sub)
                            <div class="col-md-4 col-xs-4 brand-logo">
                                <a href="{{url('menu/'.$sub->MainSection->name.'/?sub2='.$sub->id.'&name2='.$sub->name)}}">
                                    <img alt="image" style="height: 75px; width: 75px;" class="img-responsive img-rounded" src="{{ $sub->img }}"></a>
                            </div>
                            @if($key > 13)
                                <div class="clearfix"></div>
                                <a href="{{ url('menu/'.$sub->MainSection->name) }}" class="color-gold pull-left p-3"><b>المزيد</b></a>
                                @break
                                @else
                            @endif
                        @endforeach
                    </div>
                    <div class="clearfix pb-3"></div>

                    @foreach(\App\Http\Controllers\AdvsController::get_menus_sub(2) as $sub_sec_)
                        <div class="other-sections">
                            <a class="color-black" href="{{ url('menu/'.$sub_sec_->MainSection->name.'/?sub2='.$sub_sec_->id.'&name2='.$sub_sec_->name) }}">
                                <h4>{{ $sub_sec_->name }}</h4>
                            </a>
                        </div>
                    @endforeach

                    <!-- brand Box -->
                    {{--@foreach($side_advs as $side)
                        <div class="mt-4 m-1">
                            <a href="{{ $side->link }}" target="_blank">
                                <img src="{{ asset('public/img/side_advs/'.$side->img) }}"
                                     style="width: 100%; height: 350px">
                            </a>
                        </div>
                    @endforeach--}}
                <!-- end brand Box -->
                </div>
            </div>
            <!--End Sidebar-->
            <!-- ============================
                Page Content
             ================================-->
            <div class="col-md-9 my-3">
                <div class="bg-color-silver p-3 text-center">

                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-md-3 hidden-xs pt-3">اختر المدينة</label>
                            <select class="form-control m-b selectpicker col-md-9 col-xs-12" name="city" id="city"
                                    data-live-search="true" required >
                                <option value="0"> كل المدن</option>
                                @foreach($cities as $city)
                                    <option @if(request('city') == $city->id) selected
                                            @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-push-1">
                        @if(session()->has('display'))
                        @else
                            {{ session(['display' => 'list']) }}
                        @endif
                        @if(request('display') == 'list')
                            {{ session(['display' => 'list']) }}
                        @endif
                        @if(request('display') == 'tiles')
                            {{ session(['display' => 'tiles']) }}
                        @endif
                        <form class="display">
                            <button type="submit" name="display" value="list"
                                    class="tiles-list @if(session('display') == 'list') active @endif">
                                <i class="fa fa-th-list font-size-1-5em"></i>
                            </button>
                            <button type="submit" name="display" value="tiles"
                                    class="tiles-list @if(session('display') == 'tiles') active @endif">
                                <i class="fa fa-th font-size-1-5em"></i>
                            </button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="divider-darker"></div>

                <div class="bg-color-silver p-3">
                    @foreach(\App\Http\Controllers\AdvsController::get_menus() as $key => $menu)
                        <div class="col-md-3 section_ color-grey2_ @if($menu->id == request('main_section')) active @endif">
                            <button class="main_section_" value="{{ $menu->id }}"><span class="">{{ $menu->name }}</span></button>
                        </div>
                        @if($key > 1) @break @else @endif
                    @endforeach
                    <div class="col-md-2 section_ color-grey2_ @if(urldecode(Request::path()) == 'sections-map') active @endif">
                        <a href="{{ url('/sections-map') }}"><span class="">كل الأقسام</span></a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                @if(request('main_section') != 0)
                    <div class="bg-color-silver p-3">
                        <div class="scrollmenu_sub col-xs-12">
                            @foreach(\App\Http\Controllers\AdvsController::get_menus_sub(request('main_section')) as $sub)
                                <button class="sub_section_ @if($sub->id == request('sub_section')) active @endif" value="{{ $sub->id }}"><span class="">{{ $sub->name }}</span></button>
                            @endforeach
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    @if(request('sub_section') != 0)
                        <div class="bg-color-silver p-3">
                            <div class="scrollmenu_sub col-xs-12">
                                @foreach(\App\Http\Controllers\AdvsController::get_menus_internal(request('main_section'), request('sub_section')) as $internal)
                                    <button class="internal_section_ @if($internal->id == request('internal_section')) active @endif" value="{{ $internal->id }}"><span class="">{{ $internal->name }}</span></button>
                                @endforeach
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    @endif
                @endif

                <!--Filter and result-->
                <div class="bg-color-silver mt-4">
                    <!--result units-->
                    <div class="col-md-12 no-padding-x" id="result">
                    @include('index_render')
                    </div>
                    <div class="clearfix"></div>

                    @if($all_advs->count() > 10)
                    <!--Pagination -->
                        <div class="col-md-12 col-xs-12 text-center p-5">
                            <button id="btn_more" type="button" class="btn btn-lg btn-block btn-outline-orange col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                                <b>مشاهدة المزيد</b>
                            </button>
                            {{--{{ $advs->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}--}}
                        </div>
                    <!--End Pagination-->
                    @endif


                    <!--end result units-->
                </div>
                <!--End filter and result-->


            </div>
            <!-- ============================
               End Page Content
            ================================-->
        </div>
    </div>

<input type="hidden" value="0" id="isClicked">

@endsection

@section('footer')
    <script>
        $(function () {
            {{--$.ajaxSetup({--}}
            {{--headers: {--}}
            {{--'X-CSRF-TOKEN': '{{ csrf_token() }}',--}}
            {{--type: "GET",--}}
            {{--data: null,--}}
            {{--contentType: false,--}}
            {{--cache: false,--}}
            {{--processData: false,--}}
            {{--timeout: 3000,--}}
            {{--}--}}
            {{--});--}}

            $('#car_brand').on('change', function () {
                var car_brand_id = $('#car_brand option:selected').val();

                $.ajax({
                    url: "{{ url('/car_filter') }}",
                    type: "post",
                    data: {'car_brand_id': car_brand_id, '_token': '{{ csrf_token() }}'},
                    beforeSend: function () {
//                        $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                    },
                    success: function (data) {
                        $('#car_type').empty().append(data);
                        $('.selectpicker').selectpicker('refresh');
                    },
                    error: function (xhr) {
//                    var error = '<ul class="alert alert-danger">';
//                    $.each(xhr.responseJSON.errors, function (index, value) {
//                        error += '<li>' + value + '</li>';
//                    });
//                    error += "</ul>";
//                    $('#currentErrorMessage').append(error);
//                    console.log(data)
                    },
                    complete: function () {
                        $(".loading_me").empty();
                    }
                });
            });


// bottom filter
//city
$('#city').on('change', function () {
    var city = $('#city option:selected').val();
    var search = $('#search').val();
    var main_section = '{{ request('main_section') ?? 0 }}';
    var sub_section = '{{ request('sub_section') ?? 0 }}';
    var internal_section = '{{ request('internal_section') ?? 0 }}';

    var url = '{{ url('/') }}' + '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section /*+ '&internal_section=' + internal_section*/;
    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
    window.location.href = url;

});
//main sections
$(document).on('click', '.main_section_', function () {
    var city = $('#city option:selected').val();
    var search = $('#search').val();
    var main_section = $(this).val();
    {{--var sub_section = '{{ request('sub_section') ?? 0 }}';--}}
    {{--var internal_section = '{{ request('internal_section') ?? 0 }}';--}}
    var sub_section = 0;
    var internal_section = 0;

    var url = '{{ url('/') }}' + '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section /*+ '&internal_section=' + internal_section*/;
    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
    window.location.href = url;

});
//sub sections
$(document).on('click', '.sub_section_', function () {
    var city = $('#city option:selected').val();
    var search = $('#search').val();
    var main_section = '{{ request('main_section') ?? 0 }}';
    var sub_section = $(this).val();
    {{--var internal_section = '{{ request('internal_section') ?? 0 }}';--}}
    var internal_section = 0;

    var url = '{{ url('/') }}' + '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section /*+ '&internal_section=' + internal_section*/;
    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
    window.location.href = url;

});
//internal sections
$(document).on('click', '.internal_section_', function () {
    var city = $('#city option:selected').val();
    var search = $('#search').val();
    var main_section = '{{ request('main_section') ?? 0 }}';
    var sub_section = '{{ request('sub_section') ?? 0 }}';
    var internal_section = $(this).val();

    var url = '{{ url('/') }}' + '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section + '&internal_section=' + internal_section;
    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
    window.location.href = url;

});

        });
    </script>

    <script>
        $(document).ready(function () {
            var car_brand_id = '{{ request('car_brand') }}';
            var car_type_id = '{{ request('car_type')}}';

            $.ajax({
                url: "{{ url('/car_filter2') }}",
                type: "post",
                data: {'car_brand_id': car_brand_id, 'car_type_id': car_type_id, '_token': '{{ csrf_token() }}'},
                beforeSend: function () {
//                    $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                },
                success: function (data) {
                    $('#car_type').empty().append(data);
                    $('.selectpicker').selectpicker('refresh');
                },
                complete: function () {
                    $(".loading_me").empty();
                }
            });
        });
    </script>

{{--  --}}
<script type="text/javascript">
        var page = 1;
        $(window).scroll(function() {
            var check = $('#isClicked').val();
            if(check == 1){
                if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                    page++;
                    loadMoreData(page);
                }
            }

        });

        $(document).on('click', '#btn_more', function(){
            page++;
            loadMoreData(page);
            $('#isClicked').val(1);
            $(this).remove();
        })

        function loadMoreData(page){
            var city = $('#city option:selected').val();
            var search = $('#search').val();
            var main_section = '{{ request('main_section') ?? 0 }}';
            var sub_section = '{{ request('sub_section') ?? 0 }}';
            var internal_section = '{{ request('internal_section') ?? 0 }}';

            var car_brand = '{{ request('car_brand') ?? 0 }}';
            var car_type = '{{ request('car_type') ?? 0 }}';
            var car_year = '{{ request('car_year') ?? 0 }}';
            if(car_brand == 0){
                var url_ = '?search=' + search + '&city=' + city + '&main_section=' + main_section + '&sub_section=' + sub_section + /* '&internal_section=' + internal_section*/ '&page=' + page;
            }else{
                var url_ = '?car_brand=' + car_brand + '&car_type=' + car_type + '&car_year=' + car_year + '&page=' + page;
            }
            $.ajax(
                    {
                        url: url_,
                        type: "get",
                        beforeSend: function()
                        {
                            $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                        }
                    })
                    .done(function(data)
                    {
                        if(data.html == " "){
                            $('.ajax-load').html("No more records found");
                            return;
                        }
//                        $('.ajax-load').hide();
                        $("#result").append(data.html);
                        $(".loading_me").empty();
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError)
                    {

                    });
        }
    </script>
    </body>
    </html>
@endsection
