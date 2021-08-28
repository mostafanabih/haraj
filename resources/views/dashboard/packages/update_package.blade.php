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

        <div class="col-sm-12"><h2>تعديل باقة <span style="color: #ff0000">{{ $package->name }}</span> :</h2></div>
        <form action="{{ url('/packages/'.$package->id) }}" method="post" class="form-group">
            {{method_field('PUT')}}
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <label>اسم الباقة :</label>
                    <input type="text" name="name" value="{{ $package->name }}" class="form-control" placeholder="ضع هنا اسم الباقة ..." required>
                </div>
                <div class="form-group">
                    <label>تفاصيل الباقة :</label>
                    <textarea name="details" class="form-control" placeholder="ضع هنا تفاصيل الباقة ..." required>{{ $package->details }}</textarea>
                </div>
                <div class="form-group">
                    <label>مدة الباقة :</label>
                    <select class="form-control m-b selectpicker" name="duration" data-live-search="true" required>
                        <option value="">اختر مدة الباقة :</option>
                        <option value="1" @if($package->duration == 1) {{ 'selected' }} @endif>شهر</option>
                        <option value="3" @if($package->duration == 3) {{ 'selected' }} @endif>3 شهور</option>
                        <option value="6" @if($package->duration == 6) {{ 'selected' }} @endif>6 شهور</option>
                        <option value="9" @if($package->duration == 9) {{ 'selected' }} @endif>9 شهور</option>
                        <option value="12" @if($package->duration == 12) {{ 'selected' }} @endif>عام</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>سعر الباقة :</label>
                    <input min="0" type="number" name="price" value="{{ $package->price }}" step="any" class="form-control" placeholder="ضع هنا سعر الباقة ..." required>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-edit"></i>&nbsp;&nbsp;تعديل</button>
        </form>
        <!-- end of content -->


    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
