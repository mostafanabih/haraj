@extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->
{{--@if(request('sub')) $req_sub = request('search'); @endif--}}
{{--@if(request('name')) {{ request('search') }} @endif--}}

<div class="container-fluid padding-r-l-50 pt-3">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}" class="color-silver-darker">الرئيسية</a></li>
            <li><span class="color-black">الأقسام</span></li>
            <li class="active"> {{ $main_sections->name }} </li>
        </ol>
        <!-- start of content -->
        <div class="col-sm-12">
            {{--<div class="col-sm-12 bg-color-silver" id="search-box">--}}
                {{--<form>--}}
                    {{--<div class="input-group">--}}
                        {{--<input id="search" name="search" value="@if(request('search')) {{ request('search') }} @endif" class="form-control border-r-10" type="text" placeholder="ابحث عن سلعة..">--}}
                        {{--<span class="input-group-btn">--}}
                            {{--<button class="btn btn-default ic-search" type="submit">--}}
                                {{--<i class="fa fa-search"></i>--}}
                            {{--</button>--}}
                        {{--</span>--}}
                    {{--</div>--}}
                {{--</form>--}}
                {{--<div class="col-sm-12"><br></div>--}}
                {{--<div class="col-sm-8">--}}
                    {{--<div class="form-group">--}}
                        {{--<select class="form-control m-b selectpicker" name="city" id="city" data-live-search="true" required>
                            <option value="0">كل المدن</option>
                            @foreach($cities as $city)
                                <option @if(request('city') == $city->id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-4">--}}
                    {{--<div class="form-group">--}}
                        {{--<select class="form-control m-b selectpicker" name="sub_section" id="sub_section" data-live-search="true" required>--}}
                            {{--<option value="">اختر القسم الفرعى ...</option>--}}
                            {{--@foreach($sub_sections as $sub)--}}
                                {{--<option @if(request('sub_section') == $sub->id) selected @endif value="{{ $sub->id }}">{{ $sub->name }}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-8">--}}
                    {{--<div class="form-group">--}}
                        {{--<select class="form-control selectpicker" name="internal_section" id="internal_section" required>--}}
                            {{--<option value="0">اختر القسم الداخلى ...</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-4 text-center">--}}
                    {{--@if(session()->has('display'))--}}
                    {{--@else--}}
                        {{--{{ session(['display' => 'list']) }}--}}
                    {{--@endif--}}
                    {{--@if(request('display') == 'list')--}}
                        {{--{{ session(['display' => 'list']) }}--}}
                    {{--@endif--}}
                    {{--@if(request('display') == 'tiles')--}}
                        {{--{{ session(['display' => 'tiles']) }}--}}
                    {{--@endif--}}
                    {{--<form class="display">--}}
                        {{--<span class="pb-1"> طريقة عرض السلع</span>--}}
                        {{--<button type="submit" name = "display" value = "list" class="btn btn-default @if(session('display') == 'list') active @endif"> <i class="fa fa-th-list font-size-1-5em" ></i></button>--}}
                        {{--<button type="submit" name = "display" value = "tiles" class="btn btn-default @if(session('display') == 'tiles') active @endif"> <i class="fa fa-th font-size-1-5em" ></i></button>--}}
                    {{--</form>--}}
                {{--</div>--}}
                {{--<div class="col-sm-12 clearfix">--}}
                    {{--<div class="form-group" id="years"></div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <!--start of Filter-->
            <div class="col-md-12 col-xs-12 bg-color-silver p-3 mt-4 mb-1">
                <div class="col-md-4 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-4 hidden-sm hidden-xs">اختر المدينة</label>
                    <select class="form-control col-md-8 col-sm-12 col-xs-12 m-b br_ selectpicker" name="city" id="city" data-live-search="true" required>
                        <option value="0"> كل المدن</option>
                        @foreach($cities as $city)
                            <option @if(request('city') == $city->id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-4 hidden-sm hidden-xs">تصنيف فرعى</label>
                    <select class="form-control col-md-8 col-sm-12 col-xs-12 m-b br_ selectpicker" name="sub_section" id="sub_section" data-live-search="true" required>
                        <option value="0">كل الاقسام الفرعية</option>
                        @foreach($sub_sections as $sub)
                            <option @if(request('sub_section') == $sub->id) selected @endif value="{{ $sub->id }}">{{ $sub->name }}</option>
                        @endforeach
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
                    @if(count($advs) > 0)
                    @foreach($advs as $adv)
                            <!--unit-->
                    <a style="color: #000" href="{{ url('/adv/'.$adv->id) }}">
                        <div class="my-3 bg-color-white py-2 overflow-hidden my_div2">
                            <div class="col-md-10 col-xs-10">
                                <div class="border-bottom">
                                    <h4 class="string_limit2 color-gold">{{ $adv->title ?? '' }}</h4>
                                </div>
                                <div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pt-3">
                                            <p>{{ \App\Http\Controllers\AdvsController::get_count_ratings($adv->id).' ردود '  ?? ''}}</p>
                                            <p class="string_limit pt-2"><i class="fa fa-map-marker"></i>
                                                @if($adv->city)
                                                    {{ ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة' }}
                                                    {{ ' , ' }}
                                                    {{ ($adv->City) ? $adv->City->name : 'بدون مدينة' }}
                                                @else
                                                    {{ 'بدون عنوان' }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 small_font">
                                        <div class="pull-left pt-3">
                                            <p><i class="fa fa-clock-o"></i>
                                                <small>{{ App\Http\Controllers\AdvsController::calc_duration($adv->created_at) ?? '' }}</small>
                                            </p>
                                            <a style="color: #000" href="{{ url('/advertiser/'.$adv->advertiser_id) }}">
                                                <p class="pt-2 string_limit">
                                                    @if($adv->Advertiser->special == 1)
                                                        <img src="{{asset('public/img/ustar.png')}}">
                                                    @else
                                                        <i class="fa fa-user-o "></i>
                                                    @endif
                                                    <small>{{ $adv->Advertiser->name ?? '' }}</small>
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2 col-xs-2">
                                <img alt="image" class="adv_height adv-hi img-responsive img-rounded" src="@if(is_null(\App\Http\Controllers\AdvsController::get_small_img($adv->id))) {{ asset('public/img/no_img.png') }} @else {{asset(\App\Http\Controllers\AdvsController::get_small_img($adv->id))}} @endif">
                            </div>
                        </div>
                    </a>
                    <!--end unit-->
                    @endforeach
                        @else
                        <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                            <h2>لا توجد إعلانات متاحة حتى الأن ...</h2>
                        </div>
                    @endif

                            <!--Pagination -->
                    <div class="col-sm-12 text-center">
                        {{ $advs->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
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


@endsection

@section('footer')
<script>
    $(function() {
// buttom filter
// case 1
    $('#city').on('change', function () {
        var main_section_id = '{{ $main_sections->id }}';
        var city_id = $('#city option:selected').val();
        var search = $('#search').val();

        $.ajax({
            url: "{{ url('/bottom_filter1') }}",
            type: "post",
            data: {'main_section_id': main_section_id,
                'city_id': city_id,
                'search': search,
                '_token': '{{ csrf_token() }}'},
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
        var main_section_id = '{{ $main_sections->id }}';
        var sub_section_id = $('#sub_section option:selected').val();

        if(sub_section_id == 0){var sub_section_name = '';}
        else{var sub_section_name = $('#sub_section option:selected').text();}

        var city_id = $('#city option:selected').val();
        var search = $('#search').val();

        $.ajax({
            url: "{{ url('/bottom_filter2') }}",
            type: "post",
            data: {'main_section_id': main_section_id,
                'sub_section_id': sub_section_id,
                'city_id': city_id,
                'search': search,
                '_token': '{{ csrf_token() }}'},
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
        var main_section_id = '{{ $main_sections->id }}';
        var sub_section_id = $('#sub_section option:selected').val();
        var sub_section_name = $('#sub_section option:selected').text();
        var internal_section_id = $('#internal_section option:selected').val();
        var internal_section_name = $('#internal_section option:selected').text();
        var city_id = $('#city option:selected').val();
        var search = $('#search').val();

        $.ajax({
            url: "{{ url('/bottom_filter3') }}",
            type: "post",
            data: {'main_section_id': main_section_id,
                'sub_section_id': sub_section_id,
                'internal_section_id': internal_section_id,
                'city_id': city_id,
                'search': search,
                '_token': '{{ csrf_token() }}'},
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
        var main_section_id = '{{ $main_sections->id }}';
        var sub_section_id = '{{ request('sub2') }}';
        var sub_section_name = '{{ request('name2') }}';
        var city_id = 0;
        var search = '';

        if(sub_section_id){
            $.ajax({
                url: "{{ url('/bottom_filter2') }}",
                type: "post",
                data: {
                    'main_section_id': main_section_id,
                    'sub_section_id': sub_section_id,
                    'city_id': city_id,
                    'search': search,
                    '_token': '{{ csrf_token() }}'
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
@endsection
