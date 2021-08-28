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
            <a href="{{ url('/area/create') }}" type="button" class="btn btn-primary btn-block">
                <i class="fa fa-plus"></i>&nbsp;اضافة منطقة</a>
        </div>
        <!-- start of content -->
        <div class="col-sm-12"><h2>المناطق :</h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>اسم المنطقة</th>
                        <th>الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($area) > 0)
                        @for($i=0;$i<$area->count();$i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $area[$i]->name }}</td>
                                <td>
                                    <a style="margin-left: 25px" href="{{ url('/area/'.$area[$i]->id.'/edit') }}" class="btn btn-info pull-right"><i class="fa fa-pencil"></i>&nbsp;&nbsp; تعديل</a>
                                    <form onsubmit="return confirm('سوف يتم حذف جميع المدن والمستخدمين والإعلانات المرتبطين بهذه المنطقة ... هل تريد الحذف بالفعل؟');" action="{{ url('/area/'.$area[$i]->id) }}" method="post">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endfor
                    @else
                        <tr>
                            <td colspan="3" class="text-center"><h2>لا توجد بيانات حتى الأن ...</h2></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!--Pagination -->
        <div class="col-sm-12 text-center">
            {{ $area->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>
        <!--End Pagination-->

    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
