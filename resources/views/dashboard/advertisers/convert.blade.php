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

        <div class="col-sm-12"><h2>تحويل العضو <span style="color: #ff0000">{{ $advertiser->name }}</span> لمشترك :</h2></div>
        <form action="{{ url('/advertisers') }}" method="post" class="form-group">
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <label>من :</label>
                    <input type="text" name="from" value="{{ date('Y-m-d') }}" class="form-control date" required>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>إلى :</label>
                    <input type="text" name="to" value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="form-control date" required>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>

            <input type="hidden" name="advertiser_id" value="{{ $advertiser->id }}">
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
