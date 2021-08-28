@extends('layouts.layouts')
@section('content')
</section>
<!--End Header-->
{{--@if(request('sub')) $req_sub = request('search'); @endif--}}
{{--@if(request('name')) {{ request('search') }} @endif--}}

<div class="container-fluid padding-r-l-50 pt-3">
    <div class="row">
        <!-- start of content -->
        <div class="col-xs-12">
            <ul>
                @if(count(\App\Http\Controllers\AdvsController::get_menus()) > 0)
                    @foreach(\App\Http\Controllers\AdvsController::get_menus() as $main_section)
                        <li>
                            <a class="color-gold" href="{{ url('/?search=&city=0&main_section='.$main_section->id) }}">
                                <h4>{{ $main_section->name }}</h4>
                            </a>
                        </li>
                        <ul>
                            @if(count(\App\Http\Controllers\AdvsController::get_menus_sub($main_section->id)) > 0)
                                @foreach(\App\Http\Controllers\AdvsController::get_menus_sub($main_section->id) as $sub_section)
                                    <li>
                                        <a class="color-green" href="{{ url('/?search=&city=0&main_section='.$main_section->id.'&sub_section='.$sub_section->id) }}">
                                            <h4>{{ $sub_section->name }}</h4>
                                        </a>
                                    </li>
                                    <ul>
                                        @if(count(\App\Http\Controllers\AdvsController::get_menus_internal($main_section->id, $sub_section->id)) > 0)
                                            @foreach(\App\Http\Controllers\AdvsController::get_menus_internal($main_section->id, $sub_section->id) as $internal_section)
                                                <li>
                                                    <a class="color-silver-darker2" href="{{ url('/?search=&city=0&main_section='.$main_section->id.'&sub_section='.$sub_section->id.'&internal_section='.$internal_section->id) }}">
                                                        <h4>{{ $internal_section->name }}</h4>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                @endforeach
                            @endif
                        </ul>
                    @endforeach
                @endif
            </ul>
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
