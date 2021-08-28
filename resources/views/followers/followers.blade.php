    @extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->

<div class="container my-4">
    <div class="row">
        <div class="col-md-12 col-xs-12">
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
        </div>


        <!-- start of content -->
        <div class="col-md-12 col-xs-12 bg-color-silver">
            <h3>&raquo; <a href="{{ url('/') }}" style="color: #000">الرئيسية</a> / <a href="{{ url('/followers') }}" style="color: #C7A34B">المتابعين</a></h3>
        </div>
        <div class="col-md-12 col-xs-12"><br></div>


        <div class="col-md-12 col-xs-12 bg-color-silver">
            {{-- test unit --}}
            @if($followers->count() > 0)
                @foreach($followers as $follower)

                    <div class="col-md-3 col-xs-12">
                        <div class="special">

                            <a class="color-black" href="{{ url('/advertiser/'.$follower->advertiser->id) }}">
                                {{--<div class="special pt-4">--}}
                                {{--<img alt="advertiser image"--}}
                                     {{--src="@if(is_null(asset('public/img/advertiser_imgs/'.$follower->advertiser->img))) {{--}}
                                      {{--asset('public/img/logo2.png') }} @else--}}
                                     {{--{{ asset('public/img/advertiser_imgs/'.$follower->advertiser->img)--}}
                                       {{--}} @endif"--}}
                                     {{--class="img-responsive specsial center-block">--}}
                                <h3 class="text-center bg-color-white">
                                    {{ $follower->advertiser->name }}
                                </h3>
                                {{--</div>--}}
                            </a>

                        </div>
                    </div>

                @endforeach
                @else
                <div class="col-xs-12 text-center">
                    <h3>لا يوجد متابعين حتى الأن ...</h3>
                </div>
            @endif
            {{-- test unit --}}
        </div>
        <div class="col-md-12 col-xs-12"><br></div>
        <!-- end of content -->
    </div>
</div>

@endsection

@section('footer')
    <script></script>
    </body>
    </html>
@endsection