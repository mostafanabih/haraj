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
        <div class="col-sm-12"><h2>تأكيد التسجيل بكود التفعيل :</h2></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-6 text-center">
            @if(session('success_login'))
                <h2 class="text-info">{{ session('success_login') }}</h2>
            @endif
            @if(session('success'))
                <h2 class="text-info">{{ session('success') }}</h2>
            @endif
            @if(session('error'))
                <h2 class="text-info">{{ session('success') }}</h2>
            @endif
            <form action="{{ route('confirm') }}" method="post">
                @csrf
                <input class="form-control" type="text" name="confirm_" placeholder="أدخل كود التفعيل" required>
                <br>
                <input type="hidden" name="advertiser_id" value="{{ session('id') }}">
                <button type="submit" class="btn btn-warning"><span style="font-size: x-large">تفعيل</span></button>

                <a href="{{ url('/activate') }}" style="color: black; float: left;" >ليس لديك كود التفعيل</a>

            </form>
        </div>
        <div class="col-sm-3"></div>
        <!-- end of content -->
    </div>
</div>


@endsection

@section('footer')
    <script></script>
    </body>
    </html>
@endsection
