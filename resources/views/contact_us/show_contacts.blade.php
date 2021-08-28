@extends('layouts.dash-header')
@section('content')
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <!-- start of content -->
        <div class="col-sm-12">
            <h2>رؤية رسالة <span style="color: #ff0000">{{ $contact_us->name }}</span> :</h2>
            <hr>
        </div>

        <div class="col-sm-12">
            <h4><i class="fa fa-mobile"></i>&nbsp;&nbsp;<span>{{ $contact_us->mobile }}</span></h4>
            <h4><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;<span>{{ $contact_us->e_mail }}</span></h4>
            <h4>{{ Carbon\Carbon::parse($contact_us->created_at)->format('Y-m-d >> h:i A') }}</h4>
            {{--<h2 class="text-center bg-color-silver">{{ $contact_us->title }}</h2>--}}
            <h3 class="text-justify">{{ $contact_us->msg }}</h3>
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