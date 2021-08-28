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



        <div class="col-sm-6">
            <h2>تعديل الاعلان : </h2>
        </div>
        <div class="col-sm-6">
            <img alt="image" width="100" height="100" class="img-responsive pull-left" src="{{ asset('public/img/side_advs/'.$side_adv->img) }}">
        </div>
        <div class="col-sm-12"><br></div>

        <form action="{{ url('/side_advs/'.$side_adv->id) }}" method="post" enctype="multipart/form-data" class="form-group">
            {{method_field('PUT')}}
            @csrf
            <div class="col-sm-12">
                <div class="col-sm-2"><label><i class="fa fa-image"></i>&nbsp;&nbsp;أضف صورة الاسليد :</label></div>
                <div class="col-sm-10"><input class="form-control" type="file" name="image"></div>
                <div class="col-sm-12"><br></div>

                <div class="col-sm-2"><label><i class="fa fa-link"></i>&nbsp;&nbsp;أضف لينك للاعلان :</label></div>
                <div class="col-sm-10"><input class="form-control" type="url" name="link" value="{{ $side_adv->link }}" required></div>
                <div class="col-sm-12"><br></div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <button type="submit" class="btn btn-primary btn-block col-sm-6 col-sm-offset-3"><i class="fa fa-edit"></i>&nbsp;&nbsp;تعديل</button>
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
