@extends('layouts.dash-header')
<style>

</style>
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


        <div class="col-md-12">
            <h2>البلاغات : </h2>
        </div>
        <div class="clearfix"><br></div>

        {{--<form>--}}
            {{--<div class="col-md-12">--}}
                {{--<div class="col-md-10">--}}
                    {{--<select class="form-control m-b selectpicker" name="report_type" data-live-search="true" required>--}}
                        {{--<option value="0" @if(request('report_type') == 0) selected @endif>كل البلاغات</option>--}}
                        {{--<option value="1" @if(request('report_type') == 1) selected @endif>بلاغات خاصة بالمعلنين</option>--}}
                        {{--<option value="2" @if(request('report_type') == 2) selected @endif>بلاغات خاصة بالإعلانات</option>--}}
                        {{--<option value="3" @if(request('report_type') == 3) selected @endif>بلاغات خاصة بالتعليقات</option>--}}
                        {{--<option value="4" @if(request('report_type') == 4) selected @endif>بلاغات خاصة بالردود</option>--}}
                    {{--</select>--}}
                {{--</div>--}}

                {{--<div class="col-md-2">--}}
                    {{--<button class="btn btn-green btn-block">--}}
                        {{--<i class="fa fa-search"></i>&nbsp;&nbsp;بحث--}}
                    {{--</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</form>--}}

        {{--<div class="clearfix"><hr></div>--}}

        <div class="col-md-12 table-responsive">
            <table class="table table_noborder table-hover table-striped">
                <thead class="">
                    <th>#</th>
                    <th>البلاغ خاص ب</th>
                    <th>المُبلغ عنه</th>
                    <th>سبب التبليغ</th>
                    <th>الشخص المُبلغ</th>
                    <th>التاريخ</th>
                    <th class="text-center" colspan="2">الإعدادات</th>
                </thead>
                <tbody>
                @if(count($reports) > 0)
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($report->advertiser_id != 0 and $report->adv_id == 0)
                                    {{ 'معلن' }}
                                @elseif($report->adv_id != 0 and $report->c_r_type == 0)
                                    {{ 'إعلان' }}
                                @elseif($report->c_r_type == 1)
                                    {{ 'تعليق' }}
                                @elseif($report->c_r_type == 2)
                                    {{ 'رد على تعليق' }}
                                @endif
                            </td>
                            <td>
                                @if($report->advertiser_id != 0 and $report->adv_id == 0)
                                    {{ $report->Advertiser->name }}
                                @elseif($report->adv_id != 0 and $report->c_r_type == 0)
                                    {{ $report->Advs->title }}
                                @elseif($report->c_r_type == 1)
                                    {{ $report->C_R->reply }}
                                @elseif($report->c_r_type == 2)
                                    {{ $report->C_R->reply }}
                                @endif
                            </td>
                            <td>{{ $report->Reporting_Reasons->name }}</td>
                            <td>{{ $report->Reporter->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</td>
                            <td>
                                @if($report->advertiser_id != 0 and $report->adv_id == 0)
                                    <a target="_blank" href="{{ url('advertiser/'.$report->advertiser_id) }}" class="btn btn-primary"><i class="fa fa-eye"></i>&nbsp;&nbsp;رؤية صفحة المعلن</a>
                                @elseif($report->adv_id != 0 and $report->c_r_type == 0)
                                    <a target="_blank" href="{{ url('adv/'.$report->adv_id) }}" class="btn btn-primary"><i class="fa fa-eye"></i>&nbsp;&nbsp;رؤية اللإعلان</a>
                                @elseif($report->c_r_type == 1)
                                    <a target="_blank" href="{{ url('adv/'.$report->adv_id) }}" class="btn btn-primary"><i class="fa fa-eye"></i>&nbsp;&nbsp;رؤية التعليق</a>
                                @elseif($report->c_r_type == 2)
                                    <a target="_blank" href="{{ url('adv/'.$report->adv_id) }}" class="btn btn-primary"><i class="fa fa-eye"></i>&nbsp;&nbsp;رؤية الرد</a>
                                @endif
                            </td>
                            <td>
                                <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ url('/del_report/'.$report->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center"><h2>لا توجد بلاغات حتى الأن ....</h2></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <!--Pagination -->
        <div class="col-sm-12 text-center">
            {{ $reports->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>
        <div class="col-sm-12"><br></div>
    </div>
@endsection
@section('footer')
    <script>
        $(function () {
            $('.del_').click(function () {
                if (confirm('سوف يتم حذف جميع ما يتعلق بهذا المستخدم ... الاستمرار ؟')) {
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
