@extends('layouts.dash-header')
<style>

</style>
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


        <div class="col-md-12" style="padding-top: 15px; ">
            <div class="col-md-2 text-center" style="background: #020B10; margin-top: 3px;">
                <label style="color: white; margin-top: 5px; margin-bottom: 0px;">المستخدمين</label>
            </div>
        </div>
        <form>
            <div class="col-md-12 " style="padding-top: 15px; padding-bottom: 10px ; ">
                <div class="col-md-3" style="padding-right: 25px;">
                    <div class="row">
                        <label class="col-md-3">الاسم</label>

                        <div class="col-md-9">
                            <input name="name" value="@if(request('name')){{ request('name') }}@endif"
                                   class="form-control" type="text" placeholder="ضع الاسم هنا ...">
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding-right: 25px;">
                    <div class="row">
                        <label class="col-md-3">المدينه</label>

                        <div class="col-md-9">
                            <select class="form-control m-b selectpicker" name="city" data-live-search="true" required>
                                <option value="0">كل المدن</option>
                                @foreach($citits as $city)
                                    <option @if(request('city') == $city->id) selected
                                            @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding-right: 25px;">
                    <div class="row">
                        <label class="col-md-3">الاشتراك</label>

                        <div class="col-md-9">
                            <select class="form-control m-b selectpicker" name="marked" data-live-search="true"
                                    required>
                                <option @if(request('marked') == 0) selected @endif value="0">كل الأعضاء</option>
                                <option @if(request('marked') == 1) selected @endif value="1">عضو</option>
                                <option @if(request('marked') == 2) selected @endif value="2">مشترك</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="col-md-12 br_" style="padding-right: 15px;">
                        <button class="col-md-12 btn btn-green">
                            <i class="fa fa-search"></i>&nbsp;&nbsp;بحث
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <hr class="-black-tie" style="color: black !important;  background: black;   border: 1px solid black;  ">

        <div class="col-md-12 table-responsive" style="margin-top: 5px;">
            <table class="table table_noborder table-hover table-striped text-center"
                   style="background: white">
                <thead class="text-center" style="background: #6D747A;">
                <th>#</th>
                <th class="text-center" style="color: #D4D7DC;">اسم المستخدم</th>
                <th class="text-center" style="color: #D4D7DC;">رقم الجوال</th>
                <th class="text-center" style="color: #D4D7DC;">حاله الاشتراك</th>
                <th class="text-center" style="color: #D4D7DC;">تاريخ الاشتراك</th>

                <th class="text-center" colspan="6" style="color: #D4D7DC;">الإعدادات</th>
                </thead>
                <tbody>
                @if(count($advertisers) > 0)
                    @foreach($advertisers as $advertiser)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($advertiser->special == 1)
                                    <img src="{{asset('public/img/ustar.png')}}">&nbsp;&nbsp;
                                @endif
                                {{ $advertiser->name }}
                            </td>
                            <td>{{ $advertiser->mobile }}</td>
                            <td>
                                @if($advertiser->marked == 0)
                                    {{ 'عضو' }}
                                @else
                                    {{ 'مشترك' }}
                                @endif
                            </td>
                            <td>@if($advertiser->marked != 0) {{ $advertiser->subscription->start_date }} @else {{ 'لم يشترك حتى الأن' }} @endif</td>

                            <td>
                                @if($advertiser->marked == 0)
                                    @if(!$advertiser->subscription)
                                        <a href="{{ url('/advertisers/'.$advertiser->id) }}" class="btn btn-primary"><i
                                                    class="fa fa-reply"></i>&nbsp;&nbsp;تحويل لمشترك</a>
                                    @else
                                    @endif
                                @else
                                @endif
                            </td>
                            <td>
                                @if($advertiser->roles == 1 and $advertiser->type_of_roles == 0)
                                    <a href="{{ url('/normal_user_convert/'.$advertiser->id) }}" class="btn btn-info"><i
                                                class="fa fa-user"></i>&nbsp;&nbsp;تحويل لعضو</a>
                                @else
                                    <a href="{{ url('/super_user_convert/'.$advertiser->id) }}" class="btn btn-success"><i
                                                class="fa fa-star"></i>&nbsp;&nbsp;تحويل لمشرف</a>
                                @endif
                            </td>
                            <td>
                                <form action="{{ url('/advertisers/'.$advertiser->id) }}" method="post">
                                    {{ method_field('PUT') }}
                                    @csrf
                                    @if($advertiser->special == 1)
                                        <input type="hidden" name="is_special" value="0">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-close"></i>&nbsp;&nbsp;ازالة التمييز
                                        </button>
                                    @else
                                        <input type="hidden" name="is_special" value="1">
                                        <button type="submit" class="btn btn-outline-orange"><img src="{{asset('public/img/ustar.png')}}">&nbsp;&nbsp;تمييز
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <form action="{{ url('/advertisers/'.$advertiser->id) }}" method="post">
                                    {{ method_field('PUT') }}
                                    @csrf
                                    @if($advertiser->active_code != null and $advertiser->agree == 1)
                                        <input type="hidden" name="is_active" value="1">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i>&nbsp;&nbsp;تفعيل
                                        </button>
                                    @else
                                    @endif
                                </form>
                            </td>
                            <td>
                                <form action="{{ url('/advertisers/'.$advertiser->id) }}" method="post">
                                    {{ method_field('PUT') }}
                                    @csrf
                                    @if($advertiser->active_code == null or $advertiser->agree == 1)
                                        <input type="hidden" name="status" value="0">
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-ban"></i>&nbsp;&nbsp;ايقاف
                                        </button>
                                    @else
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn btn-info"><i class="fa fa-unlock"></i>&nbsp;&nbsp;رفع
                                            الإيقاف
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <form action="{{ url('/advertisers/'.$advertiser->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <input type="hidden" name="advertiser_id" value="{{ $advertiser->id }}">
                                    <button type="button" class="del_ btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="11" class="text-center"><h2>لا توجد بيانات حتى الأن ...</h2></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <!--Pagination -->
        <div class="col-sm-12 text-center">
            {{ $advertisers->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>

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
