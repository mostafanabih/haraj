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


        <div class="col-sm-3 pull-left">
            <a href="{{ url('/packages/create') }}" type="button" class="btn btn-primary btn-block">
                <i class="fa fa-plus"></i>&nbsp;اضافة باقة إشتراك</a>
        </div>
        <!-- start of content -->
        <div class="col-sm-12"><h2>باقات الإشتراك :</h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>اسم الباقة</th>
                        <th>تفاصيل الباقة</th>
                        <th>مدة الباقة</th>
                        <th>سعر الباقة</th>
                        <th>الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($packages) > 0)
                        @for($i=0;$i<$packages->count();$i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $packages[$i]->name }}</td>
                                <td>{{ $packages[$i]->details }}</td>
                                <td>@if($packages[$i]->duration == 1) {{ 'شهر' }} @elseif($packages[$i]->duration == 12) {{ ' عام ' }} @else {{ $packages[$i]->duration.' شهور' }} @endif</td>
                                <td>{{ $packages[$i]->price.' $' }}</td>
                                <td>
                                    <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <a href="{{ url('/packages/'.$packages[$i]->id.'/edit') }}" class="btn btn-info"><i class="fa fa-pencil"></i>&nbsp;&nbsp; تعديل</a>
                                    </div>
                                    <div class="col-md-6 col-md-12">
                                       <form onsubmit="return confirm('سوف يتم حذف جميع الاشتراكات الخاصة بهذه الباقة ... هل تريد الاستمرار ؟');" action="{{ url('/packages/'.$packages[$i]->id) }}" method="post">
                                            {{ method_field('DELETE') }}
                                            @csrf
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                        </form>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    @else
                        <tr>
                            <td colspan="6" class="text-center"><h2>لا توجد بيانات حتى الأن ...</h2></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!--Pagination -->
        <div class="col-sm-12 text-center">
            {{ $packages->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>
        <!--End Pagination-->

    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
