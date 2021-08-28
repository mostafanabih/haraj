@extends('layouts.dash-header')
@section('content')
    <div class="container-fluid padding-r-l-50 " style="background: #F0F3F8;">

        <div class="col-sm-12" style="padding-top: 20px;">
            <a href="{{ url('/fixed_pages/'.$page->id.'/edit') }}" class="btn btn-info pull-left"><i class="fa fa-pencil"></i>&nbsp;&nbsp; تعديل</a>
        </div>
        <div class="col-sm-12"><h2>صفحة <span style="color: #ff0000">{{ $page->title }}</span> :</h2><hr></div>
        <div class="col-sm-12">
            {!! $page->content !!}
        </div>

    </div>
@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
