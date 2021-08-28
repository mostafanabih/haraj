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

        <!-- start of content -->
        <div class="col-md-12" style="padding-top: 15px; ">
            <div class="col-md-2 text-center">
                <h3>المشرفين : </h3>
            </div>
            <div class="col-md-3 col-md-push-7 text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal1">
                    <i class="fa fa-user-plus"></i>&nbsp;&nbsp;<span style="font-size: large">إضافة مشرف</span>
                </button>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLongTitle">إضافة مشرف جديد : </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="{{ route('RegisterByAdmin') }}" method="post" class="form-group">
                                @csrf<div class="col-md-1 col-xs-2"><i class="fa fa-user fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="name" value="{{ old('name') }}" type="text" class="form-control" placeholder="اسم المستخدم" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-mobile fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="mobile" value="{{ old('mobile') }}" type="number" class="form-control" placeholder="الجوال" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-envelope fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="e_mail" value="{{ old('e_mail') }}" type="email" class="form-control" placeholder="البريد الإلكترونى" >
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-map-marker fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="address" value="{{ old('address') }}" type="text" class="form-control" placeholder="العنوان" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-lock fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="pass" type="password" class="form-control" placeholder="كلمة المرور" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <div class="col-md-1 col-xs-2"><i class="fa fa-lock fa-2x"></i></div>
                                <div class="col-md-11 col-xs-10">
                                    <input name="pass_confirmation" type="password" class="form-control" placeholder="إعادة كلمة المرور" required>
                                </div>
                                <div class="col-md-12 col-xs-12 clearfix"><br></div>

                                <input type="hidden" name="admin" value="1">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-green_1 btn-block"><h4>إنشاء</h4></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        {{--<th>الكود</th>--}}
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>البريد الالكترونى</th>
                        <th>الصلاحيات</th>
                        <th>الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($admins) > 0)
                        @for($i=0;$i<$admins->count();$i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                {{--<td>{{ $admins[$i]->user_code }}</td>--}}
                                <td>{{ $admins[$i]->name }}</td>
                                <td>{{ $admins[$i]->mobile }}</td>
                                <td>{{ $admins[$i]->e_mail ?? 'لا يوجد بريد إلكترونى حتى الأن' }}</td>
                                <td>
                                    @if(\App\Http\Controllers\PermissionsController::get_permissions($admins[$i]->id)->count() > 0)
                                        @foreach(\App\Http\Controllers\PermissionsController::get_permissions($admins[$i]->id) as $k => $permission)
                                            <label class="p-3 ml-4 bg-primary border-r-50">{{ $permission->Permission->name}}</label>
                                            @if(($k+1) % 4 == 0)
                                                <br>
                                            @endif
                                        @endforeach
                                        @else
                                        {{ 'ليس لديه صلاحيات حتى الأن' }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/permissions/'.$admins[$i]->id.'/edit') }}" class="btn btn-info pull-right"><i class="fa fa-pencil"></i>&nbsp;&nbsp; تعديل الصلاحيات</a>
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
            {{ $admins->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>
        <!--End Pagination-->

    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
