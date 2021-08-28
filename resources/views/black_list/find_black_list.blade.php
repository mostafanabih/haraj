@extends('layouts.layouts')
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


    </div>
    <!-- start of content -->
    <div class="col-md-12">
        <h2>البحث فى القائمة السوداء :</h2>
        <h4 style="color: gray">القائمة السوداء هي قائمة بإرقام حسابات وأرقام جوالات من يقومون بإساءة إستخدام الموقع
            لأغراض ممنوعه مثل الغش أو الأحتيال أو مخالفة قوانين الموقع</h4>
        <br>

        @if($advertiser == '')
        @else
            @if($advertiser == 'error')
                <div class="alert alert-info text-center">
                    <h2>رقم الهاتف أو البريد الإلكترونى غير موجود فى القائمة السوداء</h2>
                </div>
            @else
                @if($advertiser == 'error2')
                    <div class="alert alert-info text-center">
                        <h2>رقم الهاتف أو البريد الإلكترونى غير موجود فى القائمة السوداء</h2>
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        <h2>يوجد لدينا هذا الشخص : <span>{{ $advertiser->name }}</span></h2>
                    </div>
                @endif
            @endif
        @endif

        <form>
            <input class="form-control" name="search"
                   value="@if(request('search')) {{ request('search') }} @endif"
                   type="text" placeholder="أدخل رقم الجوال أو البريد الإلكترونى ..." required>
            <button type="submit" class="btn btn-green" style="font-size: large; margin-top: 10px"><i
                        class="fa fa-search"></i>&nbsp;&nbsp;فحص
            </button>
        </form>
    </div>

    <!-- end of content -->
</div>
</div>

@endsection

@section('footer')
    <script type="text/javascript"></script>
    </body>
    </html>
@endsection