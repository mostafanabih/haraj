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
            <h3 class="color-silver-darker"><a href="{{ url('/') }}" class="color-silver-darker">الرئيسية</a> / <a href="{{ url('/messages') }}" class="color-black">الرسائل</a> / <a href="{{ url('/advertiser/'.$main_msg->from_id) }}" class="color-black">{{ $main_msg->FromAdvertiser->name }}</a></h3>
        </div>
        {{--<div class="col-sm-12">--}}
            {{--<h2>الرد على رسالة <span style="color: #ff0000">{{ $msg->e_mail }}</span> :</h2>--}}
            {{--<hr>--}}
        {{--</div>--}}

        <div class="clearfix"></div>
        <div class="col-xs-12 bg-color-silver mt-5 p-3">
            <div class="border-all bg-color-silver p-3">
                <h4>{{ $main_msg->FromAdvertiser->name }}</h4>
            </div>
            <div class="border-all bg-color-white p-3">
                @foreach($msgs as $msg)
                    <div class="@if($msg->from_id != auth()->id()) bg-color-shemez col-md-4 @else bg-color-silver-lighter col-md-4 col-md-push-8 @endif col-xs-12 border-all border-r-10 m-1">
                        <h4>{{ $msg->msg }}</h4>
                        <h6 class="color-silver-darker">{{ \Carbon\Carbon::parse($msg->created_at)->diffForHumans() }}</h6>
                    </div>
                    <div class="clearfix"></div>
                @endforeach

                {{--@foreach($to_msgs as $to_msg)--}}
                    {{--<div class="col-md-4 col-md-push-8 col-xs-12 border-all bg-color-silver-lighter border-r-10">--}}
                        {{--<h4>{{ $to_msg->msg }}</h4>--}}
                        {{--<h6 class="color-silver-darker">{{ \Carbon\Carbon::parse($to_msg->created_at)->diffForHumans() }}</h6>--}}
                    {{--</div>--}}
                    {{--<div class="clearfix"></div>--}}
                {{--@endforeach--}}

                <div class="clearfix pt-3"></div>
                <form action="{{ route('contact_me') }}" method="post">
                    @csrf
                    <textarea name="msg" class="form-control col-xs-11" placeholder="اكتب هنا نص الرسالة"></textarea>
                    <input type="hidden" name="from_id" value="{{ auth()->id() }}">
                    @if($main_msg->from_id == auth()->id())
                        <input type="hidden" name="to_id" value="{{ $main_msg->to_id }}">
                        @else
                        <input type="hidden" name="to_id" value="{{ $main_msg->from_id }}">
                    @endif
                    <input type="hidden" name="parent_id" value="{{ $main_msg->id }}">

                    <button type="submit" class="transparent_btn color-gold btn btn-block col-xs-1">
                        <i class="fa fa-send-o fa-lg pt-3"></i>
                    </button>
                    </form>
                <div class="clearfix"></div>
            </div>
        </div>

        {{--<div class="col-sm-8 col-sm-offset-2">--}}
            {{--<form action="{{ route('send_reply') }}" method="post" class="form-group">--}}
                {{--@csrf--}}
                {{--<div class="col-sm-12">--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="text" class="form-control" value="{{ $msg->e_mail }}" disabled>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="clearfix"></div>--}}
                {{--<div class="col-sm-12">--}}
                    {{--<div class="form-group">--}}
                        {{--<textarea rows="5" name="msg" class="form-control" placeholder="اكتب هنا ردك على الرسالة ..." required>{{ old('msg') }}</textarea>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<input type="hidden" name="e_mail" value="{{ $msg->e_mail }}">--}}
                {{--<input type="hidden" name="name" value="{{ $msg->name }}">--}}
                {{--<input type="hidden" name="advertiser_name" value="{{ $advertiser->name }}">--}}
                {{--<input type="hidden" name="advertiser_email" value="{{ $advertiser->e_mail }}">--}}
                {{--<input type="hidden" name="adv_title" value="{{ $adv_title }}">--}}
                {{--<div class="clearfix"><br><br></div>--}}
                {{--<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-reply"></i>&nbsp;&nbsp;أرسل الرد</button>--}}
            {{--</form>--}}
        {{--</div>--}}

        <!-- end of content -->
    </div>
</div>

@endsection

@section('footer')
    <script type="text/javascript"></script>
    </body>
    </html>
@endsection