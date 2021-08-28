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
        {{--<div class="col-sm-9"></div>--}}
        {{--<div class="col-sm-3">--}}
            {{--<a class="btn btn-green btn-block pull-left" href="{{ route('show_favourite_advertiser') }}" style="font-size: x-large"><i class="fa fa-heart"></i>&nbsp;&nbsp;المعلنين المفضلين</a>--}}
        {{--</div>--}}
        {{--<div class="col-sm-12"><br></div>--}}

        <div class="col-xs-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="{{ url('/home') }}"  class="color-silver-darker">حسابى</a> / <a href="{{ url('/favourite') }}" class="color-black">المفضلة</a></h3>
        </div>



        <div class="col-xs-12 bg-color-silver p-3 mt-2">
            <!--result units-->
            <div class="col-xs-12 no-padding-x">
                @if(count($favourite) > 0)
                @foreach($favourite as $fav)
                        <!--unit-->
                <a style="color: #000" href="{{ url('/adv/'.$fav->adv_id) }}">
                    <div class="@if(session('display') == 'tiles') col-sm-6 @endif my-3 bg-color-white py-2 overflow-hidden my_div2_">
                        <div class="col-xs-9">
                            <div class="col-xs-11">
                                <h4 class="string_limit2 color-gold">{{ \App\Http\Controllers\AdvsController::get_adv($fav->adv_id)->title }}</h4>
                            </div>
                            <div class="col-xs-1 pull-left">
                                <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ url('/favourite/'.$fav->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button type="submit" class="btn transparent_btn color-gold"><i class="fa fa-trash-o fa-2x"></i></button>
                                </form>
                            </div>
                            <div class="clearfix border-bottom"></div>

                            <div>
                                <div class="col-xs-6 small_font">
                                    <div class="pt-3">
                                        <p>{{ \App\Http\Controllers\AdvsController::get_adv_ratings($fav->adv_id).' ردود ' }}</p>
                                        <p class="pt-2"><i class="fa fa-map-marker"></i> {{ \App\Http\Controllers\AdvsController::get_adv($fav->adv_id)->City->name }}</p>
                                    </div>
                                </div>
                                <div class="col-xs-6 small_font">
                                    <div class="pull-left pt-3">
                                        <p><i class="fa fa-clock-o"></i>
                                            <small>{{ App\Http\Controllers\AdvsController::calc_duration(\App\Http\Controllers\AdvsController::get_adv($fav->adv_id)->created_at) }}</small>
                                        </p>
                                        <p>#{{$fav->adv_id}}</p>
                                        {{--<a style="color: #000" href="{{ url('/advertiser/'.\App\Http\Controllers\AdvsController::get_adv($fav->adv_id)->advertiser_id) }}">--}}
                                            {{--<p class="pt-2"><i class="fa fa-user-o "></i>--}}
                                                {{--<small>{{ App\Http\Controllers\AdvsController::get_advertiser(\App\Http\Controllers\AdvsController::get_adv($fav->adv_id)->advertiser_id)->name }}</small>--}}
                                            {{--</p>--}}
                                        {{--</a>--}}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-3">
                            <img alt="favourite adv image" class="adv_height img-responsive img-rounded" src="@if(is_null(\App\Http\Controllers\AdvsController::get_adv_img($fav->adv_id))) {{ asset('public/img/no_img.png') }} @else {{ asset(\App\Http\Controllers\AdvsController::get_adv_img($fav->adv_id)->img) }} @endif">
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
                        {{ $favourite->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
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
    <script></script>
    </body>
    </html>
@endsection