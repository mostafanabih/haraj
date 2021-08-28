@extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <div class="col-sm-12 col-xs-12">
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

        <div class="col-sm-12 col-xs-12 bg-color-silver">
            <h3>&raquo; <a href="{{ url('/') }}" style="color: #000">الرئيسية</a> / <a href="{{ url('/forget_password') }}" style="color: #000">نسيان كلمة المرور</a></h3>
        </div>
        <div class="col-sm-12 col-xs-12"><br></div>

        <!-- start of content -->
        <div class="col-sm-12 col-xs-12 bg-color-silver">
            <div class="col-sm-8 col-sm-offset-2 text-center">
                <h2 class="p-5">
                    برجاء ادخال البريد الالكتروني لارسال كود  التفعيل
                    </h2>
                <form action="{{ url('/resend_code') }}" method="post">
                    @csrf
                    <input name="e_mail" type="text" class="form-control" placeholder="ادخل البريد الالكترونى: " required>
                    <br>
                    <button type="submit" class="btn btn-green"><span style="font-size: x-large">ارسال الكود </span></button>

                    <a href="{{ url('/mail_confirm') }}" style="color: black; float: left;" >لديك كود التفعيل</a>

                </form>
            </div>
            <div class="col-sm-12"><br></div>
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
