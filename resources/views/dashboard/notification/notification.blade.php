@extends('layouts.dash-header')
@section('content')
    <div class="container-fluid padding-r-l-50 " style="background: #F0F3F8;">
        <div class="col-md-12 " style="margin-top: 10px;">
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


        <div class="col-sm-3 col-xs-12">
            <a href="{{ url('/notification/create') }}" type="button" class="btn btn-primary btn-block">
                <i class="fa fa-plus"></i>&nbsp;اضافة إشعار</a>
        </div>
        <div class="col-sm-3 col-xs-12 br_">
            <a href="{{ url('/get_advertiser_notification') }}" type="button" class="btn btn-success btn-block">
                <i class="fa fa-user"></i>&nbsp;اضافة إشعار خاص بمعلن</a>
        </div>
        <!--<div class="col-sm-4 col-xs-6 pull-right">-->
        <!--    <a href="{{url('/notification/create?id=0')}}" type="button" class="btn btn-success btn-block">-->
        <!--        <i class="fa fa-plus"></i>&nbsp;اضافة إشعار-->
        <!--        <br>(للكل)-->
        <!--    </a>-->
        <!--</div>-->

        <div class="clearfix"></div>
        <!-- start of content -->
        <div class="col-sm-12"><h2>الإشعارات</h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>نص الإشعار</th>
                        <th>رقم الإعلان</th>
                        <th>اسم المعلن</th>
                        <th class="text-center" colspan="2">الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($notification) > 0)
                        @for($i=0;$i<$notification->count();$i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $notification[$i]->content ?? ""}}</td>
                                <td>
                                    @if($notification[$i]->adv_id != 0)
                                        {{ $notification[$i]->adv_id }}
                                    @else
                                        {{'لا يوجد اعلان'}}
                                    @endif

                                </td>
                                <td>{{ $notification[$i]->advertiser->name ?? "" }}</td>
                                <td>
                                    @if($notification[$i]->adv_id != 0)
                                        <a style="margin-left: 25px"
                                           href="{{ url('/notification/'.$notification[$i]->id.'/edit') }}"
                                           class="btn btn-info pull-right"><i class="fa fa-pencil"></i>&nbsp;&nbsp;
                                            تعديل</a>
                                    @else
                                    @endif
                                </td>
                                <td>
                                    <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');"
                                          action="{{ url('/notification/'.$notification[$i]->id) }}" method="post">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endfor
                    @else
                        <tr>
                            <td colspan="6" class="text-center"><h2>لا توجد إشعارات حتى الأن ...</h2></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!--Pagination -->
            <div class="col-sm-12 text-center">
                {{ $notification->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
            </div>
            <!--End Pagination-->

        </div>
    </div>
@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
