@extends('layouts.dash-header')
<style>

</style>
@section('content')
    <div class="container " style="background: #F0F3F8;">
        <div class="col-md-12 " style="margin-top: 10px;">
            <div class="col-md-2">
                <h3>إضافه قسم رئيسى</h3>
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
        <form action="{{route('main.section.store')}}" id="my_submit_form" role="form" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}

            <div class="col-md-12" style="margin-bottom:20px; ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-4">
                            <label>اسم القسم</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name" name="name">
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
                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-2" style="float: left;">
                        <div class="row">
                            <div class="">
                                <button id="my_submit_form_btn" class="btn btn-green"><i class="fa fa-save"></i> حفظ</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>


    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
