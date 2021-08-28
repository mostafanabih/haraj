@extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->

<div class="container my-4">
    <div class="row">
        <!-- start of content -->
        <div class="col-xs-12 bg-color-silver border-all">
            <h3 class="color-silver-darker"><a href="{{ url('/') }}" class="color-silver-darker">الرئيسية</a> / <a href="{{ url('/page/'.$page->id) }}" class="color-black">{{ $page->title }}</a></h3>
        </div>

        <div class="col-xs-12 bg-color-silver mt-3 p-3">
            <div class="col-xs-12">
                <div class="col-md-12 col-xs-12 bg-color-orange color-light-blue text-center">
                    <h2>{{ $page->title }}</h2>
                </div>
                <div class="col-md-12 col-xs-12 bg-color-white pt-5 pb-5">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
        <!-- end of content -->
    </div>
</div>

@endsection

@section('footer')
    <script></script>
    </body>
    </html>
@endsection