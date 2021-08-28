@if(count($advs) > 0)
@foreach($advs as $adv)
        <!--unit-->
<a style="color: #000;" href="{{url('/adv/'.$adv->id)}}">
    <div class="@if(session('display') == 'tiles') col-md-6 @endif mb-3 bg-color-white overflow-hidden my_div2">
        <div class="col-md-9 col-xs-9">
            <div class="col-xs-12">
                @php
                $adv_title = $adv->title ?? '' ;
                @endphp
                <h4 class="string_limit2 color-gold" title="{{ $adv_title }}">{{ $adv_title }}</h4>
            </div>
            <div class="p-3">
                <div class="col-xs-6 small_font">
                    <div class="pt-3">
                        @php
                        $adv_reply = \App\Http\Controllers\AdvsController::get_count_ratings($adv->id).' ردود ';

                        if($adv->city){
                            $adv_city = ($adv->City->Area) ? $adv->City->Area->name : 'بدون منطقة';
                            $adv_area = ($adv->City) ? $adv->City->name : 'بدون مدينة' ;
                            $adv_city_area = $adv_area.' , '.$adv_city;
                        }else{
                            $adv_city_area = 'بدون عنوان';
                        }
                        @endphp
                        <p title="{{ $adv_reply }}">{{ $adv_reply }}</p>
                        <p title="{{$adv_city_area}}" class="string_limit pt-2"><i class="fa fa-map-marker"></i>
                            {{ $adv_city_area }}
                        </p>
                    </div>
                </div>
                <div class="col-xs-6 small_font">
                    <div class="pull-left pt-3">
                        @php
                        $adv_date = App\Http\Controllers\AdvsController::calc_duration($adv->created_at) ?? '' ;
                        @endphp
                        <p title="{{$adv_date}}">
                            <i class="fa fa-clock-o"></i>
                            <small>{{ $adv_date }}</small>
                        </p>
                        <a style="color: #000"
                           href="{{ url('/advertiser/'.$adv->advertiser_id) }}">
                            <p class="pt-2 string_limit" title="{{ $adv->Advertiser->name ?? '' }}">
                                @if($adv->Advertiser->special == 1)
                                    <img src="{{asset('public/img/ustar.png')}}">
                                @else
                                    <i class="fa fa-user-o "></i>
                                @endif
                                <small>{{ $adv->Advertiser->name ?? '' }}</small>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-3">
            <img alt="{{ $adv->title ?? ''}}" class="adv_height img-responsive img-rounded"
                 src="@if(is_null(\App\Http\Controllers\AdvsController::get_small_img($adv->id))) {{ asset('public/img/no_img.png') }} @else {{asset(\App\Http\Controllers\AdvsController::get_small_img($adv->id))}} @endif">
        </div>
    </div>
</a>
<!--end unit-->
@endforeach
@else
    <div class="text-center my-3 bg-color-white py-2 overflow-hidden">
        <h2>لا توجد إعلانات متاحة حتى الأن ...</h2>
    </div>
@endif