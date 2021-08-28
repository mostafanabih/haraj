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
            <h3 class="color-silver-darker"><a href="{{ url('/home') }}" class="color-silver-darker">حسابى</a> / <a href="{{ url('/messages') }}" class="color-black">الرسائل</a></h3>
        </div>


        <div class="col-xs-12 bg-color-silver p-4 mt-4">
            @if(count($messages) > 0)
                @for($i=0;$i<$messages->count();$i++)
                    <div class="clearfix pt-5">
                        <div class="col-xs-12 border-all2 bg-color-silver">
                            <div class="col-md-9 col-xs-12">
                                @if($messages[$i]->from_id == auth()->id())
                                    <h4 class="string_limit2">{{ $messages[$i]->ToAdvertiser->name  }}</h4>
                                    @else
                                    <h4 class="string_limit2">{{ $messages[$i]->FromAdvertiser->name  }}</h4>
                                @endif
                                <h5>{{ \Carbon\Carbon::parse($messages[$i]->created_at)->diffForHumans() }}</h5>
                            </div>
                            <div class="col-md-3 col-xs-12 p-2">
                                <div class="col-xs-6">
                                    <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ route('messages') }}" method="post">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                        <input type="hidden" name="msg_id" value="{{ $messages[$i]->id }}">
                                        <button type="submit" class="btn btn-danger btn-block">
                                            <i class="fa fa-trash"></i><span class="hidden-xs">&nbsp;&nbsp;حذف</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-xs-6">
                                    <a href="{{ url('/reply/'.$messages[$i]->id) }}" type="button" class="btn btn-success btn-block">
                                        <i class="fa fa-reply"></i><span class="hidden-xs">&nbsp;&nbsp;رد</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 border-all2 bg-color-white">
                            {{--<h6>
                                @if($messages[$i]->adv_id == 0) {{ 'رسالة عامة' }} @else {{ \App\Http\Controllers\AdvsController::get_adv($messages[$i]->adv_id)->title }} @endif
                            </h6>--}}
                            <h5>{{ $messages[$i]->msg }}</h5>
                        </div>
                    </div>
                @endfor
                @else
                <div class="col-xs-12 border-all bg-color-white text-center">
                    <h2>لا توجد رسائل متاحة حتى الأن ...</h2>
                </div>
            @endif

            <!--Pagination -->
            <div class="col-sm-12 text-center">
            {{ $messages->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
            </div>
            <!--End Pagination-->

            <!--result units-->
            {{--<div class="col-xs-12 no-padding-x">--}}
                {{--<div class="col-sm-12">--}}
                    {{--<div class="table-responsive">--}}
                        {{--<table class="table table-hover">--}}
                            {{--<thead>--}}
                            {{--<tr class="text-center">--}}
                                {{--<th>#</th>--}}
                                {{--<th>الرسالة</th>--}}
                                {{--<th>خاصة ب</th>--}}
                                {{--<th>بريد المرسل</th>--}}
                                {{--<th>التاريخ</th>--}}
                                {{--<th>الإعدادات</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--@if(count($messages) > 0)--}}
                                {{--@for($i=0;$i<$messages->count();$i++)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{ $i+1 }}</td>--}}
                                        {{--<td>{{ $messages[$i]->msg }}</td>--}}
                                        {{--<td>@if($messages[$i]->adv_id == 0) {{ 'رسالة عامة' }} @else {{ \App\Http\Controllers\AdvsController::get_adv($messages[$i]->adv_id)->title }} @endif</td>--}}
                                        {{--<td>{{ $messages[$i]->e_mail  }}</td>--}}
                                        {{--<td>{{ \Illuminate\Support\Carbon::parse($messages[$i]->created_at)->format('Y-m-d  >>  h:i A') }}</td>--}}
                                        {{--<td>--}}
                                            {{--<form action="{{ route('messages') }}" method="post">--}}
                                                {{--{{ method_field('DELETE') }}--}}
                                                {{--@csrf--}}
                                                {{--<input type="hidden" name="msg_id" value="{{ $messages[$i]->id }}">--}}
                                                {{--<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>--}}
                                            {{--</form>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--@endfor--}}
                            {{--@else--}}
                                {{--<tr>--}}
                                    {{--<td colspan="6" class="text-center">--}}
                                        {{--<h2>لا توجد رسائل متاحة حتى الأن ...</h2>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endif--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<!--Pagination -->--}}
                    {{--<div class="col-sm-12 text-center">--}}
                        {{--{{ $messages->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}--}}
                    {{--</div>--}}
                {{--<!--End Pagination-->--}}

            {{--</div>--}}
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