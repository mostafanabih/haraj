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

        <div class="col-sm-12 bg-color-silver">
            <h3>&raquo; <a href="{{ url('/') }}" style="color: #000">الرئيسية</a> / <a href="{{ url('/reset_password') }}" style="color: #000">إدخال كلمة مرور جديدة</a></h3>
        </div>
        <div class="col-sm-12"><br></div>

        <!-- start of content -->
        <div class="col-sm-12 bg-color-silver">
            <div class="col-sm-8 col-sm-offset-2 text-center">
                <h2 class="p-5">
                    برجاء إدخال كود استرجاع كلمة المرور وكلمة المرور الجديدة
        </h2>
                <form action="{{ url('/get_reset_password') }}" method="post">
                    {{method_field('PUT')}}
                    @csrf
                    <input class="form-control" type="text" name="code" placeholder="أدخل كود استرجلع كلمة المرور" required>
                    <br>
                    <input class="form-control" type="password" name="pass" placeholder="ادخل كلمة المرور" required>
                    <br>
                    <input class="form-control" type="password" name="pass_confirmation" placeholder="تأكيد كلمة المرور" required>
                    <br>

                    <input type="hidden" name="advertiser_id" value="{{ session('forget_id') }}">
                    <button type="submit" class="btn btn-green"><span style="font-size: x-large">تحديث كلمة المرور</span></button>

                    <a href="{{ url('/forget_password') }}" style="color: black; float: left;" >ليس لديك كود استرجاع كلمة المرور</a>

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
