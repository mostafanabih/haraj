@extends('layouts.dash-header')
<style>

</style>
@section('content')
    <div class="container " style="background: #F0F3F8;">
        <div class="col-md-12 " style="margin-top: 10px; margin-bottom: 30px;">
            <div class="col-md-4">
                <h3>تعديل قسم  <i class="fa fa-angle-double-left"></i> {{$main_section->name}}</h3>
            </div>
            <div class="col-md-4 col-md-push-6">
                <img class="img-fluid img-circle" src="{{ asset($main_section->img) }}" alt="No image to show" style="max-height: 100px; min-height: 100px; max-width: 100px; min-width: 100px;">
                
            </div>
        </div>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif
        @if(session()->has('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        @if(session()->has('error'))
            <p class="alert alert-danger">{{ session('error') }}</p>
        @endif
        <form action="{{route('main.section.update')}}" id="" role="form" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
            <input type="hidden" value="{{$main_section->id}}" name="section_id">
        <div class="col-md-12" style="margin-bottom:20px; ">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-4">
                        <label>اسم القسم</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control"  name="name" value="{{$main_section->name}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>صوره القسم</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="image" id="image" class="form-control"></span>
                            <span class="fileinput-filename"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="col-md-2" style="float: left;">
                <div class="row">
                    <div class="">
                        <button class="btn btn-green"><i class="fa fa-save"></i> حفظ</button>
                    </div>
                </div>

            </div>
        </div>


    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
