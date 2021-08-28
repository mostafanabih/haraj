@extends('layouts.dash-header')
@section('content')
    <div class="container " style="background: #F0F3F8;">
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

        <div class="col-sm-12"><h2>إضافة اعلان مدفوع جديد : </h2></div>
        <div class="col-sm-12"><br></div>

        <form action="{{ url('/side_advs') }}" method="post" enctype="multipart/form-data" class="form-group">
            @csrf
            <div class="col-sm-12">
                <div class="col-sm-2"><label><i class="fa fa-image"></i>&nbsp;&nbsp;أضف صورة الاعلان :</label></div>
                <div class="col-sm-10"><input class="form-control" type="file" name="image" required></div>
                <div class="col-sm-12"><br></div>

                <div class="col-sm-2"><label><i class="fa fa-link"></i>&nbsp;&nbsp;أضف لينك للاعلان :</label></div>
                <div class="col-sm-10"><input class="form-control" type="url" name="link" required></div>
                <div class="col-sm-12"><br></div>
            </div>

            <button type="submit" class="btn btn-primary btn-block col-sm-6 col-md-offset-3"><i class="fa fa-plus"></i>&nbsp;&nbsp;أضف</button>
        </form>
        <div class="col-sm-12 clearfix"><br></div>
        <!-- end of content -->


    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
