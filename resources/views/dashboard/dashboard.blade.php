@extends('layouts.dash-header')
@section('content')
    <div class="container-fluid padding-r-l-50" style="background-color: #F0F3F8">
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
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12 label label-success" style="font-size: 16px !important;margin-bottom: 10px;margin-top:30px;">
                <div class="row">
                    <div>
                        <label>عدد طلبات الاشتراك </label>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4" style="float: right;">
                                <label for="" class="badge">{{ $requests->count() }}</label>
                            </div>
                            <div class="col-md-4 " style="float: left;">
                                <label for=""> طلب</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-xs-12 label label-primary" style="font-size: 16px !important;margin-bottom: 10px;margin-top:30px;">
                <div class="row">
                    {{--<div class="col-md-10 col-md-offset-2">--}}
                    <div>
                        <label>عدد الاعلانات</label>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4" style="float: right;">
                                <label for="" class="badge">{{ $advs }}</label>
                            </div>
                            <div class="col-md-4 " style="float: left;">
                                <label for=""> اعلان</label>
                            </div>
                        </div>

                        {{--</div>--}}
                    </div>
                </div>

            </div>

            <div class="col-md-4 col-xs-12 label label-info" style="font-size: 16px !important;margin-bottom: 10px;margin-top:30px;">
                <div class="row">
                    {{--<div class="col-md-10 col-md-offset-2">--}}
                    <div>
                        <label>عدد الزوار </label>
                    </div>
                    <div class="col-md-12 ">
                        <div class="row">
                            <div class="col-md-4" style="float: right;">
                                <label for="" class="badge">{{ $visits }}</label>
                            </div>
                            <div class="col-md-4 " style="float: left;">
                                <label for=""> زائر</label>
                            </div>
                        </div>
                    </div>
                    {{--</div>--}}
                </div>

            </div>
        </div>
    </div>
        <div class="col-md-12 col-xs-12" style="margin-top: 30px;">
            <div class="row">
                <div class="col-md-4 col-xs-12 left-cont"
                     style="padding-left: 35px; border-radius: 5px; margin-bottom: 20px;">
                    <div class="row box_one" style="border-bottom:3px solid #2D9AF5 ;">
                        <div class="col-md-12 col-xs-12" style="background-color: #2D9AF5; border-radius: 10px;">
                            <label for="" class="text-center  btn-block col-md-12" style="color: white">اخر طلبات الاشتراك</label>
                        </div>

                        @if(\App\Advertiser::can_me(6))
                            <div class="">
                                {{-- 1 --}}
                                @if(count($requests_) > 0)
                                    @foreach($requests_ as $req)  
                                    @if($req->package)
                                        <div class="col-md-12 col-xs-12" style=" background-color:#ffffff">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12 show_details" id="{{ $loop->iteration }}">
                                                    <div class="row">
                                                        <div class="col-md-6 col-xs-6 pull-right">
                                                            <label class="col-md-12" for=""><span
                                                                        class="glyphicon glyphicon-triangle-bottom"></span>{{ $req->advertiser->name }}
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6 col-xs-6 pull-left">
                                                            <div class="col-md-6 col-xs-6">
                                                              
                                                                <form onsubmit="return confirm('هل تريد الموافقة على طلب الاشتراك بالفعل ؟');" action="{{ url('/add_subscription/'.$req->id) }}"
                                                                      method="post" class="form-group">
                                                                    {{method_field('PUT')}}
                                                                    @csrf
                                                                    <input type="hidden" name="duration"
                                                                           value="{{ $req->package->duration }}">
                                                                    <input type="hidden" name="advertiser_id"
                                                                           value="{{ $req->advertiser_id }}">
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                                class="fa fa-thumbs-up"></i></button>
                                                                </form>
                                                               
                                                            </div>
                                                            <div class="col-md-6 col-xs-6">
                                                                <form onsubmit="return confirm('هل تريد الإلغاء بالفعل؟');" action="{{ url('/add_subscription/'.$req->id) }}"
                                                                      method="post">
                                                                    {{ method_field('DELETE') }}
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger"><i
                                                                                class="fa fa-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12 hidden p_details" id="{{ 'b'.$loop->iteration }}">
                                                    <div class="row">
                                                        <div class="col-md-12 col-xs-12">
                                                            <label>تاريخ الطلب :</label>
                                                            <label>{{ date('Y-m-d', strtotime($req->updated_at)) }}</label>
                                                        </div>
                                                        <div class="col-md-12 col-xs-12">
                                                            <label>الباقة :</label>
                                                            <label>{{ $req->package->name ?? '' }}</label>
                                                        </div>
                                                        {{--<div class="col-md-12 col-xs-12">--}}
                                                            {{--<a class="btn btn-success btn-block" href="{{ url('/notification/create'.'/?id='.$req->id) }}">ارسل الاشعار</a>--}}
                                                        {{--</div>--}}
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                         @endif
                                    @endforeach
                                @else
                                    <div class="col-md-12 col-xs-12 text-center" style="background: white; "><h3>لا توجد طلبات حتى الأن ...</h3></div>
                                @endif
                                {{-- 1 --}}
                            </div>
                        @else
                            <div class="col-xs-12 text-center">
                                <h3>ليس لديك صلاحية طلبات الإشتراك ...</h3>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 last-cont"
                     style="padding-right: 25px; border-radius: 5px;   margin-bottom: 20px; ">
                    <div class="row box_two" style="border-bottom:3px solid #2D9AF5 ; background: white;">
                        <div class="col-md-12 col-xs-12" style="background-color: #2D9AF5; border-radius: 10px;">
                            <label for="" class="text-center  btn-block col-md-12 col-xs-12" style="color: white">اخر
                                الاعلانات</label>
                        </div>

                        @if(\App\Advertiser::can_me(1))
                            <div class="col-md-12 col-xs-12">
                                @if(count($advs_) > 0)
                                    @foreach($advs_ as $adv)
                                        <a style="color: #000" href="{{ url('/adv/'.$adv->id) }}">
                                            <div class="col-md-10 col-md-offset-1 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3 col-xs-3" style="padding: 10px;">
                                                        <img src="{{asset($adv->image)}}" class="small_img img-responsive img-rounded" alt="image">
                                                    </div>
                                                    <div class="col-md-9 col-xs-9" >
                                                        <div class="row">
                                                            <div class="col-md-7 col-xs-12">
                                                                <h3 class="string_limit2" style="margin-top: 10px;">{{$adv->title}}</h3>
                                                            </div>
                                                            <div class="col-md-5 col-xs-12 pt-3">
                                                                <a href="{{ url('/adv_action/'.$adv->id.'/edit') }}"
                                                                   class="btn btn-primary pull-left"><i class="fa fa-pencil"></i>&nbsp;&nbsp;تعديل</a>

                                                                <form action="{{ url('/adv_action/'.$adv->id) }}" method="post">
                                                                    {{ method_field('DELETE') }}
                                                                    @csrf
                                                                    <button type="button" class="del_ btn btn-danger"><i
                                                                                class="fa fa-trash"></i>&nbsp;&nbsp;حذف
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-12 col-xs-12">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 small_font">
                                                            <div class="">
                                                                @if($adv->agree == 0)
                                                                    <form onsubmit="return confirm('هل تريد الموافقة على نشر هذا الإعلان بالفعل ؟');" action="{{ url('/adv_confirm/'.$adv->id) }}" method="post">
                                                                        {{ method_field('PUT') }}
                                                                        @csrf
                                                                        <button class="btn btn-success pt-1 pb-1" type="submit">
                                                                            <i class="fa fa-check-square-o"></i><span class="hidden-xs">&nbsp; تأكيد النشر</span>
                                                                        </button>
                                                                    </form>
                                                                    @else
                                                                    <label for="">
                                                                        <i class="fa fa-eye"></i> <span>{{ $adv->views.' مشاهدة' }}</span>
                                                                    </label>
                                                                @endif
                                                            </div>
                                                            <div class="">
                                                                <label for="">
                                                                    <i class="fa fa-map-marker" style="color: black"></i>
                                                                    @if($adv->city)
                                                                        {{ ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة' }}
                                                                        {{ ' , ' }}
                                                                        {{ ($adv->City) ? $adv->City->name : 'بدون مدينة' }}
                                                                    @else
                                                                        {{ 'بدون عنوان' }}
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 small_font">
                                                            <div class="">
                                                                <label for="">
                                                                    <i class="fa fa-check-circle"></i> منذ {{$adv->time}}
                                                                    يوم
                                                                </label>
                                                            </div>
                                                            <div class="">
                                                                <label class="string_limit" for="">
                                                                    <i class="fa fa-user"></i>
                                                                    {{ $adv->advertiser->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="col-md-12 col-xs-12">
                                            <hr style="height: 1px;background-color: #000B11">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-12 col-xs-12 text-center"><h3>لا توجد إعلانات حتى الأن ...</h3></div>
                                @endif
                            </div>
                        @else
                            <div class="col-xs-12 text-center">
                                <h3>ليس لديك صلاحية الإعلانات ...</h3>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(document).on('click', ".show_details", function () {
            var id = $(this).attr('id');
            $(".p_details").addClass('hidden');

            $("#b" + id).removeClass('hidden');
        });

//        $(document).ready(function () {
//            var hBox = $(".box_one").height();
//            var hBox2 = $(".box_two").height();
//            if (hBox > hBox2) {
//                $(".box_two").css("height", hBox + 3 + "px");
//            } else {
//                $(".box_one").css("height", hBox2 + 3 + "px");
//            }
//        });


        $(function () {
            $('.del_').click(function () {
                if (confirm('هل تريد الحذف بالتأكيد ؟')) {
                    this.form.submit();
                } else {
                    // Do nothing!
                }

            });
        });
    </script>
    </body>
    </html>
@endsection
