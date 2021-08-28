@extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <div class="col-sm-12">
            @if(session('error'))
                <div class="flash alert alert-danger" align="center" role="alert">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="flash alert alert-success" align="center" role="alert">{{ session('success') }}</div>
            @endif
        </div>
        <!-- start of content -->
        <div class="col-xs-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="{{ url('/home') }}" class="color-silver-darker">حسابى</a> / <a href="{{ url('/add_adv') }}" class="color-black">إعلاناتى</a></h3>
        </div>

        <div class="col-md-12 col-xs-12 bg-color-silver p-3 mt-4 mb-1">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-6 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-3 col-xs-12">التصنيف</label>
                    <select class="form-control col-md-9 col-xs-12 m-b selectpicker" name="main_section" id="main_section" data-live-search="true" required>
                        <option value="0">اختر القسم الرئيسى ...</option>
                        @foreach($main_sections as $main)
                            <option @if(request('main_section') == $main->id) selected @endif value="{{ $main->id }}">{{ $main->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 col-xs-12">
                    <label class="font-large-bold pt-3 col-md-3 col-xs-12">اختر مدينة</label>
                    <select class="form-control col-md-9 col-xs-12 m-b selectpicker" name="city" id="city" data-live-search="true" required>
                        <option value="0">كل المدن</option>
                        @foreach($cities as $city)
                            <option @if(request('city') == $city->id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xs-12 bg-color-silver p-3">
            <!--result units-->
            <div class="col-md-12 col-xs-12 no-padding-x" id="result">
                @if(count($advs) > 0)
                @foreach($advs as $adv)
                        <!--unit-->
                <a style="color: #000" href="{{ url('/adv/'.$adv->id) }}">
                    <div class="@if(session('display') == 'tiles') col-sm-6 @endif my-3 bg-color-white py-2 overflow-hidden my_div2 my_div2_">
                        <div class="col-md-10 col-xs-10">
                            <div class="col-md-12 col-xs-12">
                                <h4 class="string_limit2 color-gold">{{ $adv->title }}</h4>
                            </div>
                            <div class="clearfix border-bottom"></div>

                            <div>
                                <div class="col-md-5 col-xs-6 small_font">
                                    <div class="pt-3">
                                        <p>{{ \App\Http\Controllers\AdvsController::get_count_ratings($adv->id).' ردود ' }}</p>
                                        <p class="pt-2"><i class="fa fa-map-marker"></i>
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
                                <div class="col-md-4 col-xs-6 small_font">
                                    <div class="pull-left pt-3">
                                        <p><i class="fa fa-clock-o"></i>
                                            <small>{{ App\Http\Controllers\AdvsController::calc_duration($adv->created_at) }}</small>
                                        </p>
                                        <p>{{ '#'.$adv->id }}</p>
                                        {{--<a style="color: #000" href="{{ url('/advertiser/'.$adv->advertiser_id) }}">--}}
                                            {{--<p class="pt-2 string_limit"><i class="fa fa-user-o "></i>--}}
                                                {{--<small>{{ App\Http\Controllers\AdvsController::get_advertiser($adv->advertiser_id)->name }}</small>--}}
                                            {{--</p>--}}
                                        {{--</a>--}}
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="">
                                        <div class="col-md-12 col-xs-6 pt-2">
                                            <a href="{{ url('/add_adv/'.$adv->id.'/edit') }}" class="btn btn-green btn-block border-r-10">
                                                <span class="hidden-xs hidden-sm font-large-bold">تعديل الإعلان&nbsp;&nbsp;</span><i class="fa fa-edit fa-lg"></i>
                                            </a>
                                        </div>

                                        <div class="col-md-12 col-xs-6 pt-2">
                                            <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ url('/add_adv/'.$adv->id) }}" method="post">
                                                {{ method_field('DELETE') }}
                                                @csrf
                                                <button type="button" class="del_ btn btn-orange btn-block border-r-10">
                                                    <span class="hidden-xs hidden-sm font-large-bold">حذف الإعلان&nbsp;&nbsp;</span><i class="fa fa-trash fa-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2">
                            <img alt="adv image" class="adv_height img-responsive img-rounded" src="@if(is_null(\App\Http\Controllers\AdvsController::get_small_img($adv->id))) {{ asset('public/img/no_img.png') }} @else {{asset(\App\Http\Controllers\AdvsController::get_small_img($adv->id))}} @endif">
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
        <!-- end of content -->


    </div>
</div>

@endsection
@section('footer')
<script>
    $(function() {
        $(document).on('click', '.del_', function () {
            if (confirm('هل تريد الحذف بالتأكيد ؟')) {
                this.form.submit();
            } else {
                // Do nothing!
            }

        });
    });

    // case 1
    $('#main_section, #city').on('change', function () {
        var main_section_id = $('#main_section option:selected').val();
        var city_id = $('#city option:selected').val();

        $.ajax({
            url: "{{ url('/bottom_filter1_123') }}",
            type: "post",
            data: {
                'main_section_id': main_section_id,
                'city_id': city_id,
                '_token': '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $(".loading_me").empty().append('<div class="se-pre-con"></div>');
            },
            success: function (data) {
                $('#result').empty().append(data[0]);
                $('.selectpicker').selectpicker('refresh');
//                alert(data[0]);
            },
            complete: function () {
                $(".loading_me").empty();
            }
        });
    });
</script>
</body>
</html>
@endsection
