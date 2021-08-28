@extends('layouts.dash-header')
@section('content')
    <div class="container " style="background: #F0F3F8;">
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
            <a href="{{ url('/side_advs/create') }}" type="button" class="btn btn-primary btn-block">
                <i class="fa fa-plus"></i>&nbsp;اضافة اعلان مدفوع</a>
        </div>
        <!-- start of content -->
        <div class="col-sm-12"><h2>الاعلانات المدفوعة : </h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>الصورة</th>
                        <th>لينك الاعلان</th>
                        <th colspan="2" class="text-center">الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($side_advs) > 0)
                        @for($i=0;$i<$side_advs->count();$i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td><img alt="image" width="100" height="100" class="img-responsive" src="{{ asset('public/img/side_advs/'.$side_advs[$i]->img) }}"></td>
                                <td><a class="color-light-blue" href="{{ $side_advs[$i]->link }}" target="_blank">{{ $side_advs[$i]->link }}</a></td>
                                <td>
                                    <a style="margin-left: 25px" href="{{ url('/side_advs/'.$side_advs[$i]->id.'/edit') }}" class="btn btn-info pull-right"><i class="fa fa-pencil"></i>&nbsp;&nbsp; تعديل</a>
                                </td>
                                <td>
                                    <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ url('/side_advs/'.$side_advs[$i]->id) }}" method="post">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endfor
                    @else
                        <tr>
                            <td colspan="5" class="text-center"><h2>لا توجد بيانات حتى الأن ...</h2></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!--Pagination -->
        <div class="col-sm-12 text-center">
            {{ $side_advs->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>
        <!--End Pagination-->

    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
