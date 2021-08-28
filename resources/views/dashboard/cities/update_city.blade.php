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

        <div class="col-sm-12"><h2>تعديل مدينة <span style="color: #ff0000">{{ $city->name }}</span> :</h2></div>
        <form action="{{ url('/cities/'.$city->id) }}" method="post" class="form-group">
            {{method_field('PUT')}}
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <select class="form-control m-b selectpicker" name="area" data-live-search="true" required>
                        <option value="">اختر منطقة ...</option>
                        @foreach($area as $area_)
                            <option value="{{ $area_->id }}" @if($area_->id == $city->area_id) {{'selected'}} @endif>{{ $area_->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>اسم المدينة : </label>
                    <input type="text" name="name" value="{{ $city->name }}" class="form-control" placeholder="ضع هنا اسم المدينة ..." required>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <input id="autocomplete_search" value="{{ $city->location }}" name="location" type="text" class="form-control" placeholder="ابحث هنا عن موقع المدينة ..." required>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control" value="{{ $city->lat }}" type="number" step="any" name="lat" id="lat" placeholder="خط العرض هنا ..." required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control" value="{{ $city->lon }}" type="number" step="any" name="lon" id="long" placeholder="خط الطول هنا ..." required>
                </div>
            </div>

            <div class="col-sm-12 clearfix"></div>
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-edit"></i>&nbsp;&nbsp;تعديل</button>
        </form>
        <!-- end of content -->

    </div>

@endsection
@section('footer')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmT97qMPjKdidWGuTUr8c9KC2l4sVUcNs&amp;libraries=places"></script>

    <script>
        google.maps.event.addDomListener(window, 'load', initialize);
        function initialize() {
            var input = document.getElementById('autocomplete_search');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                // place variable will have all the information you are looking for.
                $('#lat').val(place.geometry['location'].lat());
                $('#long').val(place.geometry['location'].lng());
            });
        }
    </script>
    </body>
    </html>
@endsection
