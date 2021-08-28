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

        <div class="col-md-12"><h3>إعدادت الموقع :</h3></div>

        <div class="col-sm-12">
            <form action="{{ url('/site_settings/'.$settings->id) }}" method="post" enctype="multipart/form-data" class="form-group">
                {{method_field('PUT')}}
                @csrf
                <div class="col-sm-12">
                    <img alt="logo" height="150" width="150" class="img-responsive img-rounded" src="{{ ($settings->logo != null) ? asset('public/img/'.$settings->logo) : asset('public/img/logo.png') }}">
                    <input class="form-control" type="file" name="image">

                    <br>
                    <label>وصف الموقع : </label>
                    <textarea name="description" class="form-control" placeholder="ضع وصف موقع مزاد الكويت هنا ..." required>{{ $settings->description }}</textarea>

                    <br>
                    <label>ضع هنا الكلمات الدلالية للموقع ومفصول بينهم بالفاصلة ,</label>
                    <textarea name="key_words" class="form-control" placeholder="مثال : شراء ,بيع ,أعلان ,مزايدة ,إلخ ..." required>{{ $settings->key_words }}</textarea>

                    <br>
                    <hr>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>الإسم :</label>
                        <input name="name" value="{{ $settings->name }}" type="text" class="form-control" placeholder="ضع اسمك هنا ..." required>
                    </div>
                    <div class="form-group">
                        <label>العنوان :</label>
                        <input name="address" value="{{ $settings->address }}" type="text" class="form-control" placeholder="ضع عنوانك هنا ..." required>
                    </div>
                    <div class="form-group">
                        <label>الجوال :</label>
                        <input name="mobile" value="{{ $settings->mobile }}" type="tel" class="form-control" placeholder="ضع رقم جوالك هنا ..." required>
                    </div>
                    <div class="form-group">
                        <label>الفاكس :</label>
                        <input name="fax" value="{{ $settings->fax }}" type="tel" class="form-control" placeholder="ضع رقم جوالك هنا ..." required>
                    </div>
                    <div class="form-group">
                        <label>البريد الإلكترونى :</label>
                        <input name="e_mail" value="{{ $settings->e_mail }}" type="email" class="form-control" placeholder="ضع بريدك الالكترونى هنا ..." required>
                    </div>
                    
                    <div class="form-group">
                        <label>ساعات تحديث الاعلان : </label>
                        <input name="hour_update" min="1" value="{{ $settings->hour_update }}" type="number" class="form-control" placeholder="ضع عدد ساعات تحديث الاعلان ..." required>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label><i class="fa fa-facebook"></i>&nbsp;فيس بوك</label>
                        <input name="facebook" value="{{ $settings->facebook }}" type="text" class="form-control" placeholder="ضع رابط الفيس بوك الخاص بك ...">
                    </div>
                    <div class="form-group">
                        <label><i class="fa fa-twitter"></i>&nbsp;تويتر</label>
                        <input name="twitter" value="{{ $settings->twitter }}" type="text" class="form-control" placeholder="ضع رابط تويتر الخاص بك ...">
                    </div>
                    <div class="form-group">
                        <label><i class="fa fa-instagram"></i>&nbsp;انستجرام</label>
                        <input name="instagram" value="{{ $settings->instagram }}" type="text" class="form-control" placeholder="ضع رابط انستجرام الخاص بك ...">
                    </div>
                    <div class="form-group">
                        <label><i class="fa fa-youtube"></i>&nbsp;يوتيوب</label>
                        <input name="youtube" value="{{ $settings->youtube }}" type="text" class="form-control" placeholder="ضع رابط يوتيوب الخاص بك ...">
                    </div>

                    <div class="form-group">
                        <label><i class="fa fa-whatsapp"></i>&nbsp;واتساب</label>
                        <input name="whatsapp" value="{{ $settings->whatsapp }}" type="number" class="form-control" placeholder="ضع رقم الواتساب الخاص بك ...">
                    </div>
                    
                </div>

                <div class="col-sm-12">
                    <hr>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-android"></i>&nbsp;رابط جوجل بلاى :</label>
                            <input name="google_play" value="{{ $settings->google_play }}" type="text" class="form-control" placeholder="ضع رابط يوتيوب الخاص بك ...">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-apple"></i>&nbsp;رابط أب ستور :</label>
                            <input name="app_store" value="{{ $settings->app_store }}" type="text" class="form-control" placeholder="ضع رابط يوتيوب الخاص بك ...">
                        </div>
                    </div>

                    {{--<div class="col-sm-12">--}}
                        {{--<div class="form-group">--}}
                            {{--<label>تعهد 1 : </label>--}}
                            {{--<textarea name="agree1" class="form-control" placeholder="ضع التعهد الأول هنا ..." required>{{ $settings->agree1 }}</textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col-sm-12">--}}
                        {{--<div class="form-group">--}}
                            {{--<label>تعهد 2 : </label>--}}
                            {{--<textarea name="agree2" class="form-control" placeholder="ضع التعهد الثانى هنا ..." required>{{ $settings->agree2 }}</textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col-sm-12">--}}
                        {{--<div class="form-group">--}}
                            {{--<label>تعهد 3 : </label>--}}
                            {{--<textarea name="agree3" class="form-control" placeholder="ضع التعهد الثالث هنا ..." required>{{ $settings->agree3 }}</textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>

                <div class="col-sm-6 col-sm-offset-3">
                    <button type="submit" class="btn btn-orange btn-block"><h4>حفظ</h4></button>
                </div>

            </form>
        </div>
        <div class="col-sm-12 clearfix"><br></div>
    </div>
@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
