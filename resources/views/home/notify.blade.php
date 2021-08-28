@extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <div class="col-xs-12">
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
        <div class="col-xs-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="{{ url('/') }}" class="color-silver-darker">الرئيسية</a> / <a href="{{ url('/AdvertiserNotifyController') }}" class="color-black">اشعارات</a></h3>
        </div>

        {{--<ul class="dropdown-menu" style="right: auto !important;">--}}
            {{--@if(\App\Http\Controllers\AdvertiserNotifyController::get_notify(auth()->id())->count() > 0)--}}
                {{--@foreach(\App\Http\Controllers\AdvertiserNotifyController::get_notify(auth()->id()) as $notify)--}}
                    {{--@if($notify->type == 1)--}}
                        {{--<li class="bg-primary p-2" style="padding-bottom: 5px">--}}
                            {{--<a style="white-space: normal;" href="{{ url('/AdvertiserNotifyController/'.$notify->id) }}">--}}
                                {{--<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;{{ $notify->content }}--}}
                                {{--<br>--}}
                                {{--<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span style="font-size: smaller">{{ \Carbon\Carbon::parse($notify->created_at)->diffForHumans() }}</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@elseif($notify->type == 2)--}}
                        {{--<li class="bg-primary p-2" style="padding-bottom: 5px">--}}
                            {{--<a style="white-space: normal;" href="{{ url('/AdvertiserNotifyController/'.$notify->id) }}">--}}
                                {{--<i class="fa fa-check-square-o"></i>&nbsp;&nbsp;{{ $notify->content }}--}}
                                {{--<br>--}}
                                {{--<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span style="font-size: smaller">{{ \Carbon\Carbon::parse($notify->created_at)->diffForHumans() }}</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@elseif($notify->type == 3)--}}
                        {{--<li class="bg-primary p-2" style="padding-bottom: 5px">--}}
                            {{--<a style="white-space: normal;" href="{{ url('/AdvertiserNotifyController/'.$notify->id) }}">--}}
                                {{--<i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;{{ $notify->content }}--}}
                                {{--<br>--}}
                                {{--<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span style="font-size: smaller">{{ \Carbon\Carbon::parse($notify->created_at)->diffForHumans() }}</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@elseif($notify->type == 4)--}}
                        {{--<li class="bg-primary p-2" style="padding-bottom: 5px">--}}
                            {{--<a style="white-space: normal;" href="{{ url('/AdvertiserNotifyController/'.$notify->id) }}">--}}
                                {{--<i class="fa fa-comment"></i>&nbsp;&nbsp;{{ $notify->content }}--}}
                                {{--<br>--}}
                                {{--<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span style="font-size: smaller">{{ \Carbon\Carbon::parse($notify->created_at)->diffForHumans() }}</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@elseif($notify->type == 5)--}}
                        {{--<li class="bg-primary p-2" style="padding-bottom: 5px">--}}
                            {{--<a style="white-space: normal;" href="{{ url('/AdvertiserNotifyController/'.$notify->id) }}">--}}
                                {{--<i class="fa fa-reply"></i>&nbsp;&nbsp;{{ $notify->content }}--}}
                                {{--<br>--}}
                                {{--<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span style="font-size: smaller">{{ \Carbon\Carbon::parse($notify->created_at)->diffForHumans() }}</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@else--}}
                        {{--<li class="bg-primary p-2" style="padding-bottom: 5px">--}}
                            {{--<a style="white-space: normal;" href="{{ url('/AdvertiserNotifyController/'.$notify->id) }}">--}}
                                {{--<i class="fa fa-sticky-note"></i>&nbsp;&nbsp;{{ \App\Http\Controllers\AdvsController::get_adv($notify->adv_id)->title }}--}}
                                {{--<br>--}}
                                {{--<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span style="font-size: smaller">{{ \Carbon\Carbon::parse($notify->created_at)->diffForHumans() }}</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
            {{--@else--}}
                {{--<li class="bg-primary text-center">أن</li>--}}
            {{--@endif--}}
        {{--</ul>--}}

        <div class="clearfix"></div>
        <div class="col-xs-12 bg-color-silver mt-5 p-3">
            <div class="border-all bg-color-white p-3">
                @if($notify->count() > 0)
                    @foreach($notify as $n)
                        <a href="{{ url('/AdvertiserNotifyController/'.$n->id) }}">
                            <div class="bg-color-silver-lighter @if($n->reading == 1) color-silver-darker @else color-black @endif mb-3">
                                <div class="col-md-2 col-xs-3 bg-color-silver-darker text-center p-1">
                                    @if($n->reading == 1)
                                        <i class="fa fa-bell-o fa-4x"></i>
                                    @else
                                        <i class="fa fa-bell-o color-gold fa-4x"></i>
                                    @endif
                                </div>
                                <div class="col-md-10 col-xs-9">
                                    <h4>{{ $n->content }}</h4>
                                    <h6>
                                        <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span>{{ \Carbon\Carbon::parse($n->created_at)->format('Y-m-d') }}</span>
                                        <i class="fa fa-clock-o pl-5"></i>&nbsp;&nbsp;<span>{{ \Carbon\Carbon::parse($n->created_at)->format('h:i') }}</span>
                                    </h6>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    @endforeach
                    @else
                    <div class="text-center"><h4>لا توجد إشعارات حتى الأن</h4></div>
                @endif
            </div>
        </div>

        <!-- end of content -->
    </div>
</div>

@endsection

@section('footer')
    <script type="text/javascript"></script>
    </body>
    </html>
@endsection