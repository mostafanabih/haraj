@extends('layouts.dash-header')
@section('content')
    <div class="container " style="background: #F0F3F8;">
        <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
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

        <div>
            <h3>الاعلانات :</h3>
        </div>

        @if(count($advs) > 0)
            @foreach($advs as $adv)
                <a style="color: #000" href="{{ url('/adv/'.$adv->id) }}">
                    <div class="col-md-10 col-md-offset-1 col-xs-12 bg-color-white mb-3">
                        <div class="row">
                            <div class="col-xs-2 p-2">
                                <img style="height: 150px;width: 100%" src="{{url($adv->image)}}"
                                     class="img-responsive img-rounded" alt="adv image">
                            </div>
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12"><h3 class="string_limit2" style="margin-top: 10px;">
                                            <a class="btn btn-primary"
                                               href="{{ url("/notification/create?id=".$adv->id) }}"><i
                                                    class="fa fa-bell"></i></a>&nbsp;
                                            {{$adv->title}}
                                        </h3>
                                    </div>
                                    <div class="col-md-6 col-xs-12" style="padding-top: 10px;">
                                        @if($adv->agree == 0)
                                            <form
                                                onsubmit="return confirm('هل تريد الموافقة على نشر هذا الإعلان بالفعل ؟');"
                                                action="{{ url('/adv_confirm/'.$adv->id) }}" method="post">
                                                {{ method_field('PUT') }}
                                                @csrf
                                                <button class="btn btn-success btn-block col-xs-4 m-1" type="submit">
                                                    <i class="fa fa-check-square-o"></i><span class="hidden-xs">&nbsp; تأكيد النشر</span>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ url('/adv_action/'.$adv->id.'/edit') }}"
                                           class="btn btn-primary btn-block col-xs-4 m-1">
                                            <i class="fa fa-pencil"></i><span class="hidden-xs">&nbsp;&nbsp;تعديل</span>
                                        </a>

                                        <form action="{{ url('/adv_action/'.$adv->id) }}" method="post">
                                            {{ method_field('DELETE') }}
                                            @csrf
                                            <button type="button" class="del_ btn btn-danger btn-block col-xs-3 m-1">
                                                <i class="fa fa-trash"></i><span
                                                    class="hidden-xs">&nbsp;&nbsp;حذف</span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="clearfix">
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-xs-6 small_font" style="float: right">

                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-eye"></i> <span>{{ $adv->views.' مشاهدة' }}</span>
                                            </label>
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
                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-hashtag" style="color: black"></i>
                                              كود الاعلان : {{$adv->id}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 small_font" style="float: left">
                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-check-circle"></i> منذ {{$adv->time}} يوم
                                            </label>
                                        </div>
                                        <div class="">
                                            <label for="">
                                                <i class="fa fa-user"></i>
                                                {{ $adv->advertiser->name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <div class="col-md-12 col-xs-12 text-center"><h3>لا توجد إعلانات حتى الأن ...</h3></div>
        @endif

        <div class="col-md-12 col-xs-12 text-center">
            {{ $advs->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>

    </div>

    <div class="col-md-12 col-xs-12 clearfix"><br></div>
@endsection
@section('footer')
    <script>
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
