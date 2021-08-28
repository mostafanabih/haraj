@extends('layouts.dash-header')
@section('content')
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        @if(session('error'))
            <div class="flash alert alert-danger" align="center" role="alert">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="flash alert alert-success" align="center" role="alert">{{ session('success') }}</div>
        @endif


        <div class="col-sm-3 pull-left">
            <a href="{{ url('/black_list/create') }}" type="button" class="btn btn-primary btn-block">
                <i class="fa fa-plus"></i>&nbsp;اضف معلن جديد</a>
        </div>
        <!-- start of content -->
        <div class="col-sm-12"><h2>القائمة السوداء :</h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>الاسم</th>
                        <th>السبب</th>
                        <th>الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($black_list) > 0)
                    @for($i=0;$i<$black_list->count();$i++)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ \App\Http\Controllers\AdvsController::get_advertiser($black_list[$i]->advertiser_id)->name }}</td>
                            <td>{{ $black_list[$i]->reason }}</td>
                            <td>
                                <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ url('/black_list/'.$black_list[$i]->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <input type="hidden" name="advertiser_id" value="{{ $black_list[$i]->advertiser_id }}">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endfor
                        @else
                        <tr>
                            <td colspan="4">
                                <div class="text-center">
                                    <h2>لا توجد بيانات حتى الأن ...</h2>
                                </div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!--Pagination -->
        <div class="col-sm-12 text-center">
            {{ $black_list->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>
        <!--End Pagination-->
        <!-- end of content -->
    </div>
</div>

@endsection

@section('footer')
    <script type="text/javascript"></script>
    </body>
    </html>
@endsection