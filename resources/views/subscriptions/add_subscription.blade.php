@extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <div class="col-sm-12">
            @if(session('error'))
                <div class="flash alert alert-danger" align="center" role="alert">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="flash alert alert-success" align="center" role="alert">{{ session('success') }}</div>
            @endif
        </div>


        <!-- start of content -->
        <div class="col-xs-12 bg-color-silver">
            <h3>&raquo; <a href="{{ url('/home') }}" style="color: #000">حسابى</a> / <a
                        href="{{ url('/add_subscription') }}" style="color: #000">اشتراك بالموقع</a></h3>
        </div>


        <div class="col-xs-12 bg-color-silver p-3 mt-4 ">
            <!--result units-->
            <div class="col-xs-12 no-padding-x">
                <div class="col-md-12">
                    @if($subscription && $subscription->package)
                        @if($subscription->start_date == null or $subscription->end_date == null)
                            <div class="alert alert-info text-center">
                                <h3>باقتك <span style="color: #ff0000">{{ $subscription->package->name }}</span> تحت
                                    المراجعة للموافقة عليها</h3>
                            </div>
                        @else
                            <div class="alert alert-success text-center">
                                <h3>انت الأن على باقة <span
                                            style="color: #ff0000">@if($subscription->package_id == 0) {{ 'الباقة التجريبية' }} @else {{ $subscription->package->name }} @endif</span> (متبقى :
                                    <span style="color: #ff0000">{{ \App\Http\Controllers\AdvsController::calc_duration($subscription->end_date) }}</span>
                                    )</h3>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-danger text-center">
                            <h3>ليس لديك باقة حتى الأن !</h3>
                        </div>
                    @endif
                </div>

                <div class="col-md-12">
                    {{-- start 1 --}}
                    @foreach($packages as $package)
                        <div class="col-md-4">
                            <div class="adv_data text-center">
                                <h2 class="adv_data_1">{{ $package->name }}</h2>

                                <p class="p_justify">{{ $package->details }}</p>
                                <hr>
                                <h3 class="font-bold">
                                    @if($package->duration == 1) {{ 'شهر' }} @elseif($package->duration == 12) {{ ' عام ' }} @else {{ $package->duration.' شهور' }} @endif
                                </h3>
                                <hr>
                                <h2 class="font-bold">{{ $package->price.' $' }}</h2>

                                <form action="{{ route('add_subscription') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="advertiser_id" value="{{ auth()->id() }}">
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    @if($subscription)
                                        @if($subscription->package_id == $package->id)
                                            <button type="button" class="btn btn-block button_me btn-success"><i
                                                        class="fa fa-check-circle"></i>&nbsp;&nbsp;تم الاختيار
                                            </button>
                                        @else
                                            @if($subscription->start_date == null or $subscription->end_date == null)
                                                <button type="submit" class="btn btn-block button_me">اشترك الأن!</button>
                                            @else
                                                <button type="button" class="btn btn-block button_me"><i
                                                            class="fa fa-close"></i>&nbsp;&nbsp;غير متاح الأن</button>
                                            @endif
                                        @endif
                                    @else
                                        <button type="submit" class="btn btn-block button_me">اشترك الأن!</button>
                                    @endif
                                </form>
                            </div>
                        </div>

                        @if($loop->iteration % 3 == 0)
                            <div class="col-md-12 clearfix"></div>
                        @endif

                    @endforeach
                    {{-- end 1 --}}
                </div>
            </div>
            <!--end result units-->
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