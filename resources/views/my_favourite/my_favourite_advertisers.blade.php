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
        <div class="col-sm-9"></div>
        <div class="col-sm-3">
            <a class="btn btn-green btn-block pull-left" href="{{ url('/favourite') }}" style="font-size: x-large"><i class="fa fa-heart"></i>&nbsp;&nbsp;إعلاناتى المفضلة</a>
        </div>
        <div class="col-sm-12"><br></div>

        <div class="col-xs-12 bg-color-silver">
            <h3>&raquo; <a href="{{ url('/home') }}" style="color: #000">حسابى</a> / <a href="{{ route('show_favourite_advertiser') }}" style="color: #000">المعلنين المفضلين</a></h3>
        </div>



        <div class="col-xs-12 bg-color-silver p-3 mt-4 ">
            <!--result units-->
                @if(count($favourite) > 0)
                @foreach($favourite as $fav)
                        <!--unit-->
                    <div class="col-md-4 no-padding-x">
                        <div class="col-md-1"></div>
                        <a target="_blank" style="color: #000" href="{{ url('/advertiser/'.$fav->favourite_advertiser) }}">
                        <div style="background-color: #65B76D" class="col-md-11">
                            <div class="col-md-12 text-center bg-color-white" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px">
                                <h1>{{ \App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->name }}</h1>
                            </div>
                            {{--<div class="col-md-12">--}}
                                {{--<h3><i class="fa fa-mobile"></i>&nbsp;&nbsp;<span>{{ \App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->mobile }} + </span></h3>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-12">--}}
                                {{--<h3><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<span>{{ \App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->address }}</span></h3>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-12">--}}
                                {{--<hr>--}}
                                {{--<ul class="color-grey">--}}
                                    {{--<a target="_blank" href="{{ \App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->whatsapp }}">--}}
                                        {{--<li class="fa fa-whatsapp fa-2x"></li>--}}
                                    {{--</a>--}}
                                    {{--<a target="_blank" href="{{ \App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->facebook }}">--}}
                                        {{--<li class="fa fa-facebook fa-2x"></li>--}}
                                    {{--</a>--}}
                                    {{--<a target="_blank" href="{{ \App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->twitter }}">--}}
                                        {{--<li class="fa fa-twitter fa-2x"></li>--}}
                                    {{--</a>--}}
                                    {{--<a target="_blank" href="{{ \App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->instagram }}">--}}
                                        {{--<li class="fa fa-instagram fa-2x"></li>--}}
                                    {{--</a>--}}
                                    {{--<a target="_blank" href="{{ \App\Http\Controllers\AdvsController::get_advertiser($fav->favourite_advertiser)->youtube }}">--}}
                                        {{--<li class="fa fa-youtube fa-2x"></li>--}}
                                    {{--</a>--}}
                                {{--</ul>--}}
                            {{--</div>--}}

                            <div class="col-md-12 pt-5">
                                <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ route('delete_favourite_advertiser') }}" method="post">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <input type="hidden" name="fav_id" value="{{ $fav->id }}">
                                    <button type="submit" class="btn btn-danger btn-block" style="font-size: large"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                </form>
                            </div>
                        </div>
                            <div class="col-md-12"><br></div>
                        </a>
                    </div>
                <!--end unit-->
                @endforeach
                @else
                    <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
                        <h2>لا يوجد معلنين حتى الأن ...</h2>
                    </div>
                    @endif

                            <!--Pagination -->
                    <div class="col-sm-12 text-center">
                        {{ $favourite->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
                    </div>
                    <!--End Pagination-->
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