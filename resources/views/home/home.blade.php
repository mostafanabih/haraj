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
                <h3 class="color-silver-darker"><a href="{{ url('/') }}" class="color-silver-darker">الرئيسية</a> / <a
                            href="{{ url('/home') }}" class="color-black">الصفحة الشخصية</a></h3>
            </div>
        </div>

        <div class="col-md-12 col-xs-12">
            <div class="bg-color-white border-all p-3 mt-3">
                <h3>أهلا وسهلا</h3>

                <div class="col-md-4 col-xs-12">
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-2 bg-color-orange color-light-blue border-all text-center">
                            @if($advertiser->special == 1)
                                <img class="p-3" src="{{asset('public/img/ustar.png')}}">
                            @else
                                <i class="fa fa-user-o fa-2x p-2"></i>
                            @endif
                        </div>
                        <div class="col-md-9"><h4>{{ $advertiser->name ?? '' }}</h4></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-2 bg-color-silver-darker color-gold border-all text-center">
                            <i class="fa fa-thumbs-up fa-2x p-2"></i>
                        </div>
                        <div class="col-md-9"><h4><span>{{ $ratings->count() ?? '' }}</span> تقييم ايجابى</h4></div>
                        {{--<div class="col-md-3">--}}
                        {{--<button type="submit" class="btn btn-orange btn-block m-1"><span class="font-large-bold">مشاهدة</span></button>--}}
                        {{--</div>--}}
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="bg-color-silver border-all2 mt-3">
                        <div class="col-md-2 bg-color-silver-darker color-gold border-all text-center">
                            <i class="fa fa-rss fa-2x p-2"></i>
                        </div>
                        <div class="col-md-9"><h4><span>{{ $followers->count() ?? '' }}</span> متابع </h4></div>
                        {{--<div class="col-md-3">--}}
                        {{--<a href="{{ url('/followers') }}" type="button" class="btn btn-orange btn-block m-1"><span class="font-large-bold">مشاهدة</span></a>--}}
                        {{--</div>--}}
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="bg-color-white border-all p-5 mt-3">
                <div class=" col-md-10 col-md-offset-1 col-xs-12 color-silver-darker2">
                    <form action="{{ url('/account_settings/'.$advertiser->id) }}" method="post" class="form-group">
                        {{method_field('PUT')}}
                        @csrf
                        <div class="col-md-1 hidden-xs text-center">
                            @if($advertiser->special == 1)
                                <img src="{{asset('public/img/ustar.png')}}">
                            @else
                                <i class="fa fa-user-o fa-2x icon-register"></i>
                            @endif
                        </div>
                        <div class="col-md-11 col-xs-12">
                            <input name="name" value="{{$advertiser->name}}" type="text" class="form-control input-md"
                                   placeholder="اسم المستخدم" required>
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-1 hidden-xs text-center"><i class="fa fa-mobile fa-2x icon-register"></i>
                        </div>
                        <div class="col-md-11 col-xs-12">
                            <input name="mobile" value="{{$advertiser->mobile}}" type="number"
                                   class="form-control input-md" placeholder="صيغة الجوال المطلوبة 05xxxxxxxx" required>
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-1 hidden-xs text-center"><i class="fa fa-envelope-o fa-2x icon-register"></i>
                        </div>
                        <div class="col-md-11 col-xs-12">
                            <input name="e_mail" value="{{$advertiser->e_mail}}" type="email"
                                   class="form-control input-md" placeholder="البريد الإلكترونى" required>
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-1 hidden-xs text-center"><i class="fa fa-lock fa-2x icon-register"></i></div>
                        <div class="col-md-11 col-xs-12">
                            <input name="pass" min="6" type="password" class="input-md form-control"
                                   placeholder="كلمة المرور">
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-1 hidden-xs text-center"><i class="fa fa-lock fa-2x icon-register"></i></div>
                        <div class="col-md-11 col-xs-12">
                            <input name="pass_confirmation" min="6" type="password" class="input-md form-control"
                                   placeholder="إعادة كلمة المرور">
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <h3 class="text-center"> العنوان </h3>

                        <div class="col-md-6 col-xs-12">
                            <select class="form-control m-b input-md selectpicker" name="area" id="area"
                                    data-live-search="true" required>
                                <option value="">اختر منطقة ...</option>
                                @foreach($area as $area_)
                                    <option value="{{ $area_->id }}" @if($advertiser->area == $area_->id) {{ 'selected' }} @endif>{{ $area_->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <select class="form-control m-b input-md selectpicker" name="city" id="city"
                                    data-live-search="true" required>
                                <option value="">اختر مدينة ...</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" @if($advertiser->city == $city->id) {{ 'selected' }} @endif>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-6 col-xs-12">
                            <input name="street" value="{{$advertiser->street}}" type="text"
                                   class="input-md form-control" placeholder="الحى ..." required>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input id="autocomplete_search" name="address" value="{{$advertiser->address}}" type="text"
                                   class="input-md form-control" placeholder="ابحث هنا عن موقعك ..." >
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-6 col-xs-12">
                            <input readonly class="form-control" type="hidden" name="lat" value="{{$advertiser->lat}}" id="lat"
                                   placeholder="خط الطول هنا ..." >
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input readonly class="form-control" type="hidden" name="lon" value="{{$advertiser->lon}}" id="long"
                                   placeholder="خط العرض هنا ..." >
                        </div>
                        <div class="clearfix"></div>
                        <br>


                        <h3 class="text-center">التواصل الإجتماعى</h3>

                        <div class="col-md-6 col-xs-12">
                            <span class="icon__form">
                                <img alt="facbook" src="{{asset('public/img/f.png')}}">
                            </span>
                            <input name="facebook" value="{{$advertiser->facebook}}" type="text"
                                   class="input-md form-control" placeholder="ضع رابط الفيس بوك الخاص بك ...">
                        </div>

                        <div class="col-md-6 col-xs-12">
                            <span class="icon__form">
                                <img alt="instagram" src="{{asset('public/img/i.png')}}">
                            </span>
                            <input name="instagram" value="{{$advertiser->instagram}}" type="text"
                                   class="input-md form-control" placeholder="ضع رابط انستجرام الخاص بك ...">
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-6 col-xs-12">
                            <span class="icon__form">
                                <img alt="twitter" src="{{asset('public/img/t.png')}}">
                            </span>
                            <input name="twitter" value="{{$advertiser->twitter}}" type="text"
                                   class="input-md form-control" placeholder="ضع رابط تويتر الخاص بك ...">
                        </div>
                        <div class="clearfix"></div>
                        <br>

                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-green btn-block border-r-10"><h4>تعديل</h4></button>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end of content -->
    </div>
</div>

@endsection

@section('footer')
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
@endsection