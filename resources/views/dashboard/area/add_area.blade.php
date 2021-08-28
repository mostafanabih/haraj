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

        <div class="col-sm-12"><h2>إضافة منطقة جديدة :</h2></div>
        <form id="my_submit_form" action="{{ url('/area') }}" method="post" class="form-group">
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="ضع هنا اسم المنطقة ..." required>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <button id="my_submit_form_btn" type="button" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>&nbsp;&nbsp;أضف</button>
        </form>
        <!-- end of content -->


    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
