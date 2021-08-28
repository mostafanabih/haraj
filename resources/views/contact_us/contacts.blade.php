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

        <!-- start of content -->
        <div class="col-sm-12"><h2>رسائل التواصل معنا :</h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>البريد الإلكترونى</th>
                        {{--<th>عنوان الرسالة</th>--}}
                        <th colspan="2" class="text-center">الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($contact_us) > 0)
                    @for($i=0;$i<$contact_us->count();$i++)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ Carbon\Carbon::parse($contact_us[$i]->created_at)->format('Y-m-d >> h:i A') }}</td>
                            <td>{{ $contact_us[$i]->name }}</td>
                            <td>{{ $contact_us[$i]->mobile }}</td>
                            <td>{{ $contact_us[$i]->e_mail }}</td>
                            {{--<td>{{ $contact_us[$i]->title }}</td>--}}
                            <td>
                                <a href="{{ url('/contact_us/'.$contact_us[$i]->id) }}" type="button" class="btn btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;رؤية الرسالة</a>
                            </td>
                            <td>
                                <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ url('/contact_us/'.$contact_us[$i]->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endfor
                        @else
                        <tr>
                            <td colspan="7">
                                <div class="text-center">
                                    <h2>لا توجد رسائل حتى الأن ...</h2>
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
            {{ $contact_us->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
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