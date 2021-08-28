@extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
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
        <div class="col-xs-12">
            <div class="bg-color-silver border-all">
                <h3 class="color-silver-darker"><a href="{{ url('/') }}" class="color-silver-darker">الرئيسية</a> / <a href="{{ url('/advertiser/'.$advertiser->id) }}" class="color-black">المعلن {{ $advertiser->name }}</a></h3>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="border-all mt-4">
                <div class="bg-color-silver border-all">
                    <div class="col-md-2 bg-color-orange color-light-blue text-center">
                        @if($advertiser->special == 1)
                            <img class="p-3" src="{{asset('public/img/ustar.png')}}">
                        @else
                            <i class="fa fa-user-o fa-2x p-2"></i>
                        @endif
                    </div>
                    <div class="col-md-8"><h4>{{ $advertiser->name ?? ''}}</h4></div>
                    <div class="col-md-2 text-center">
                        @if(auth()->guest())
                            <a href="{{ url('login?msg=log') }}">
                                <i class="fa fa-heart-o fa-lg color-silver-darker"></i>
                            </a>
                        @else
                            @if(auth()->user()->id == $advertiser->id)

                            @else
                                <form action="{{ route('favourite_advertiser') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="favourite_advertiser" value="{{ $advertiser->id }}">
                                    <input type="hidden" name="advertiser_id" value="{{ auth()->id() }}">
                                    @if(\App\Http\Controllers\AdvsController::is_advertiser_favourite(auth()->id(), $advertiser->id))
                                        <button class="transparent_btn btn btn-block" type="submit">
                                            <i class="fa fa-heart-o fa-lg color-gold"></i>
                                        </button>
                                    @else
                                        <button class="transparent_btn btn btn-block" type="submit">
                                            <i class="fa fa-heart-o fa-lg color-silver-darker"></i>
                                        </button>
                                    @endif
                                </form>
                            @endif
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="bg-color-white p-3">
                    <h4>أخر ظهور <span>{{ \Carbon\Carbon::parse($advertiser->last_activity)->diffForHumans() ?? '' }}</span></h4>
                    
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-3 bg-color-silver-darker color-gold border-all text-center">
                            <i class="fa fa-thumbs-up fa-2x p-2"></i>
                        </div>
                        <div class="col-md-5"><h4><span>{{ $ratings->count() ?? '' }}</span> تقييم ايجابى</h4></div>
                        <div class="col-md-4">
                            @if(auth()->guest())
                                <a href="{{ url('login?msg=log') }}" type="button" class="btn btn-orange btn-block m-1">
                                    <span class="font-large-bold">قيم</span>
                                </a>
                            @else
                                @if(auth()->user()->id == $advertiser->id)

                                @else
                                    <!-- Button trigger modal -->
                                <button type="button" class="btn btn-orange btn-block m-1" data-toggle="modal" data-target="#myModal2">
                                    <span class="font-large-bold">قيم</span>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLongTitle">تقييم <span>{{ $advertiser->name }}</span></h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <form action="{{ route('advertiser_rating') }}" method="post">
                                                    @csrf
                                                    <div class="rating_now__starts">
                                                        <input type="hidden" name="rating" class="rating" value="0"  />
                                                    </div>
                                                    <input type="hidden" name="advertiser_id" value="{{ $advertiser->id }}">
                                                    <input type="hidden" name="voter_id" value="{{ auth()->user()->id }}">
                                                    <button type="submit" class="btn btn-orange btn-block">قيم</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-3 bg-color-silver-darker color-green border-all text-center">
                            <i class="fa fa-whatsapp fa-2x p-2"></i>
                        </div>
                        <?php
                        $mobile_with_whatsapp = '966'.ltrim($advertiser->mobile, '0');
                        ?>
                        <div class="col-md-5" id="MyText"><h4>{{ $mobile_with_whatsapp ?? '' }}</h4></div>
                        <div class="col-md-4">
                            <button onclick="MyCopy()" class="btn btn-orange btn-block m-1">
                                <span class="font-large-bold">نسخ</span>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-3 bg-color-silver-darker color-gold border-all text-center">
                            <i class="fa fa-rss fa-2x p-2"></i>
                        </div>
                        <div class="col-md-5"><h4><span>{{ $followers->count() ?? '' }}</span> متابع</h4></div>
                        <div class="col-md-4">
                            @if(auth()->guest())
                                <a href="{{ url('login?msg=log') }}" type="button" class="btn btn-orange btn-block m-1">
                                    <span class="font-large-bold">متابعة</span>
                                </a>
                            @else
                                @if(auth()->user()->id == $advertiser->id)

                                @else
                                    <form action="{{ route('follow_me') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="advertiser_id" value="{{ $advertiser->id }}">
                                        <input type="hidden" name="follower_id" value="{{ auth()->user()->id }}">

                                        @if(\App\Http\Controllers\AdvsController::is_follow($advertiser->id, auth()->user()->id))
                                            <button type="submit" class="btn btn-orange btn-block m-1">
                                                <span>تم المتابعة</span>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-orange btn-block m-1">
                                                <span class="font-large-bold">متابعة</span>
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="text-center">
                        @if(auth()->guest())
                            <h4><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;أرسل رسالتك للمعلن</h4>
                            <textarea name="msg" rows="5" class="form-control" placeholder="اكتب هنا نص الرسالة"></textarea>
                            <a href="{{ url('login?msg=log') }}" type="button" class="btn btn-green_1 btn-block mt-2"><span class="font-large-bold">ارسال</span></a>
                        @else
                            @if(auth()->user()->id == $advertiser->id)

                            @else
                                <h4><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;أرسل رسالتك للمعلن</h4>
                                <form action="{{ route('contact_me') }}" method="post">
                                    @csrf
                                    <textarea name="msg" rows="5" class="form-control" placeholder="اكتب هنا نص الرسالة"></textarea>
                                    <input type="hidden" name="from_id" value="{{ auth()->id() }}">
                                    <input type="hidden" name="to_id" value="{{ $advertiser->id }}">
                                    <input type="hidden" name="parent_id" value="0">

                                    <button type="submit" class="btn btn-orange btn-block mt-2"><span class="font-large-bold">ارسال</span></button>
                                </form>
                            @endif
                        @endif

                        <ul class="list-inline pt-5">
                            <a target="_blank" class="pl-5 color-silver-darker2" href="{{ $advertiser->facebook }}">
                                <li class="fa fa-facebook fa-2x"></li>
                            </a>
                            <a target="_blank" class="pl-5 color-silver-darker2" href="{{ $advertiser->twitter }}">
                                <li class="fa fa-twitter fa-2x"></li>
                            </a>
                            <a target="_blank" class="pl-5 color-silver-darker2" href="{{ $advertiser->instagram }}">
                                <li class="fa fa-instagram fa-2x"></li>
                            </a>
                            {{--<a target="_blank" class="pl-5 color-silver-darker2" href="{{ $advertiser->youtube }}">--}}
                                {{--<li class="fa fa-youtube fa-2x"></li>--}}
                            {{--</a>--}}
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <!--start of Filter-->
            <div class="col-xs-12 bg-color-silver p-3 mt-4 mb-1">
                <div class="">
                    <div class="col-md-6 col-xs-12">
                        <label class="font-large-bold pt-3 col-md-4 hidden-xs">التصنيف</label>
                        <select class="form-control col-md-8 col-xs-12 m-b selectpicker" name="main_section" id="main_section" data-live-search="true" required>
                            <option value="0">اختر القسم الرئيسى</option>
                            @foreach($main_sections as $main)
                                <option @if(request('main_section') == $main->id) selected
                                        @endif value="{{ $main->id }}">{{ $main->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xs-12 br_">
                        <label class="font-large-bold pt-3 col-md-4 hidden-xs">اختر المدينة</label>
                        <select class="form-control col-md-8 col-xs-12 m-b selectpicker" name="city" id="city" data-live-search="true" required>
                            <option value="0">كل المدن</option>
                            @foreach($cities as $city)
                                <option @if(request('city') == $city->id) selected
                                        @endif value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--end Filter-->

            <!--result-->
            <div class="col-xs-12 bg-color-silver p-3 mt-4 mb-4">
                <div class="">
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
                                                        @if($advertiser->special == 1)
                                                            <img src="{{asset('public/img/ustar.png')}}">
                                                        @else
                                                            <i class="fa fa-user-o"></i>
                                                        @endif
                                                        <small>{{ $advertiser->name ?? '' }}</small>
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
            </div>
            <!--End filter and result-->

            @if(!is_null($advertiser->lat) and !is_null($advertiser->lon))
                <h3 class="pt-3">موقع المعلن ع الخريطة : </h3>
                <!--The div element for the map -->
                <div id="map"></div>
                <script>
                    // Initialize and add the map
                    function initMap() {
                        // The location of Uluru
                        var uluru = {lat: {{$advertiser->lat}}, lng: {{$advertiser->lon}}};
                        // The map
                        var map = new google.maps.Map(
                                document.getElementById('map'), {zoom: 4, center: uluru});
                        // The marker, positioned at Uluru
                        var marker = new google.maps.Marker({position: uluru, map: map});
                    }
                </script>
                <!--Load the API from the specified URL
                * The async attribute allows the browser to render the page while the API loads
                * The key parameter will contain your own API key (which is not needed for this tutorial)
                * The callback parameter executes the initMap() function
                -->
                <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmT97qMPjKdidWGuTUr8c9KC2l4sVUcNs&callback=initMap">
                </script>
                @else
                <div class="clearfix"></div>
                <div class="text-center bg-info p-3 mt-5">
                    <h3>لم يحدد المعلن موقعه على الخريطة حتى الأن</h3>
                </div>
            @endif

        </div>
        <!-- end of content -->
    </div>
</div>


@endsection

@section('footer')
    <script>
        $(function () {
            // case 1
            $('#main_section, #city').on('change', function () {
                var main_section_id = $('#main_section option:selected').val();
                var city_id = $('#city option:selected').val();
                var advertiser_id = '{{ $advertiser->id }}';

                $.ajax({
                    url: "{{ url('/bottom_filter1_123_') }}",
                    type: "post",
                    data: {
                        'main_section_id': main_section_id,
                        'city_id': city_id,
                        'advertiser_id': advertiser_id,
                        '_token': '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".loading_me").empty().append('<div class="se-pre-con"></div>');
                    },
                    success: function (data) {
                        $('#result').empty().append(data[0]);
                    },
                    complete: function () {
                        $(".loading_me").empty();
                    }
                });
            });

        });

        function MyCopy(){
            var copyText = document.getElementById("MyText");
            var textArea = document.createElement("textarea");
            textArea.value = copyText.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            textArea.remove();
        }
    </script>
    </body>
    </html>
@endsection