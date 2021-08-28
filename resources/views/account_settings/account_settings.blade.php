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
        <div class="col-xs-12 bg-color-silver">
            <h3>&raquo; <a href="{{ url('/home') }}" style="color: #000">حسابى</a> / <a href="{{ url('/account_settings') }}" style="color: #000">إعدادات الحساب</a></h3>
        </div>
    </div>

        <div class="row">
            <div class="col-md-4 col-xs-12 col-md-offset-9">
            <!-- Button trigger modal -->
                <button type="button" class="btn btn-green" data-toggle="modal"
                data-target="#myModal1">
                    <span style="font-size: x-large"><i class="fa fa-unlock"></i>&nbsp;تغيير كلمة المرور</span>
                </button>
            </div>
        </div>
        <!-- Modal -->
    <div class="row">
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h2>تغيير كلمة المرور : </h2>
                    </div>
                    <div class="modal-body col-md-12 text-center">
                        <form action="{{ route('change_pass') }}" method="post">
                            {{method_field('PUT')}}
                            @csrf
                            <input name="old_pass" type="password" class="input-md form-control" placeholder="كلمة المرور القديمة ..." required>
                            <br>
                            <input name="pass" type="password" class="input-md form-control" placeholder="كلمة المرور الحديثة ..." required>
                            <br>
                            <input name="pass_confirmation" type="password" class="input-md form-control" placeholder="إعادة كلمة المرور الحديثة ..." required>

                            <input type="hidden" name="advertiser_id" value="{{ auth()->id() }}">

                            <br>
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-block btn-green">
                                    <span style="font-size: x-large"><i class="fa fa-edit"></i>&nbsp;تعديل</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="margin-top: 15px;">
            <form action="{{ url('/account_settings/'.$settings->id) }}" method="post" class="form-group">
                {{method_field('PUT')}}
                @csrf
                <div class="col-sm-6">

                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12">الإسم :</label>
                            <input name="name" value="{{ $settings->name }}" type="text" class="form-control col-md-8 col-xs-12" placeholder="ضع اسمك هنا ..." required>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12">الجوال :</label>
                            <input name="mobile" value="{{ $settings->mobile }}" type="tel" class="form-control col-md-8 col-xs-12" placeholder="ضع رقم جوالك هنا ..." required>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12">المدينة :</label>
                            <select class="form-control m-b selectpicker col-md-8 col-xs-12" name="city" data-live-search="true" required>
                                <option value="">اختر المدينة :</option>
                                @foreach($citits as $city)
                                    <option @if($settings->city == $city->id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12">العنوان :</label>
                            <input name="address" value="{{ $settings->address }}" type="text" class="form-control col-md-8 col-xs-12" placeholder="ضع عنوانك هنا ..." required>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12">البريد الإلكترونى :</label>
                            <input disabled name="e_mail" value="{{ $settings->e_mail }}" type="email" class="form-control col-md-8 col-xs-12" placeholder="ضع بريدك الالكترونى هنا ..." required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12"><i class="fa fa-facebook"></i>&nbsp;فيس بوك</label>
                            <input name="facebook" value="{{ $settings->facebook }}" type="text" class="form-control col-md-8 col-xs-12" placeholder="ضع رابط الفيس بوك الخاص بك ...">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12"><i class="fa fa-twitter"></i>&nbsp;تويتر</label>
                            <input name="twitter" value="{{ $settings->twitter }}" type="text" class="form-control col-md-8 col-xs-12" placeholder="ضع رابط تويتر الخاص بك ...">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12"><i class="fa fa-instagram"></i>&nbsp;انستجرام</label>
                            <input name="instagram" value="{{ $settings->instagram }}" type="text" class="form-control col-md-8 col-xs-12" placeholder="ضع رابط انستجرام الخاص بك ...">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12"><i class="fa fa-whatsapp"></i>&nbsp;واتساب</label>
                            <input name="whatsapp" value="{{ $settings->whatsapp }}" type="text" class="form-control col-md-8 col-xs-12" placeholder="ضع رابط واتساب الخاص بك ...">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12"><i class="fa fa-youtube"></i>&nbsp;يوتيوب</label>
                            <input name="youtube" value="{{ $settings->youtube }}" type="text" class="form-control col-md-8 col-xs-12" placeholder="ضع رابط يوتيوب الخاص بك ...">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 col-sm-12 col-md-offset-3">
                        <button type="submit" class="btn btn-orange btn-block"><h4>حفظ</h4></button>
                    </div>
                </div>
            </form>
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
