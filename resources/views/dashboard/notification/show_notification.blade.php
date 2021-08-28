@extends('layouts.layouts')
@section('content')
    <div class="container-fluid padding-r-l-50 " style="background: #F0F3F8;">
        @if($notification->adv_id == 0)
            <h4>إشعار عام</h4>
        @else
            <div class="col-sm-12"><h4>إشعار خاص ب <span style="color: #ff0000">{{ \App\Http\Controllers\AdvsController::get_adv($notification->adv_id)->title }}</span> :</h4></div>
        @endif

        <div class="col-sm-12 text-center bg-primary">
            <h4>{{ $notification->content }}</h4>
        </div>

        <div class="col-sm-12"><br></div>
    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
