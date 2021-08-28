@extends('layouts.dash-header')
@section('content')
    <div class="container-fluid padding-r-l-50" style="background: #F0F3F8;">
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

        <div class="col-sm-12"><h2>إضافة باقة إشتراك جديدة :</h2></div>
        <form action="{{ url('/packages') }}" method="post" class="form-group">
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="ضع هنا اسم الباقة ..." required>
                </div>
                <div class="form-group">
                    <textarea name="details" class="form-control" placeholder="ضع هنا تفاصيل الباقة ..." required>{{ old('details') }}</textarea>
                </div>
                <div class="form-group">
                    <select class="form-control m-b selectpicker" name="duration" data-live-search="true" required>
                        <option value="">اختر مدة الباقة :</option>
                        <option value="1">شهر</option>
                        <option value="3">3 شهور</option>
                        <option value="6">6 شهور</option>
                        <option value="9">9 شهور</option>
                        <option value="12">عام</option>
                    </select>
                </div>
                <div class="form-group">
                    <input min="0" type="number" name="price" value="{{ old('price') }}" step="any" class="form-control" placeholder="ضع هنا سعر الباقة ..." required>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>&nbsp;&nbsp;أضف</button>
        </form>
        <!-- end of content -->


    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
