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

        <div class="col-sm-12"><h2>تعديل منطقة <span style="color: #ff0000">{{ $area->name }}</span> :</h2></div>
        <form action="{{ url('/area/'.$area->id) }}" method="post" class="form-group">
            {{method_field('PUT')}}
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <label>اسم المنطقة :</label>
                    <input type="text" name="name" value="{{ $area->name }}" class="form-control" placeholder="ضع هنا اسم المنطقة ..." required>
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
