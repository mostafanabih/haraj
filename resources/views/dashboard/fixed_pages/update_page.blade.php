@extends('layouts.dash-header')
@section('content')
    <div class="container-fluid " style="background: #F0F3F8;">
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



        <div class="col-sm-12"><h2>تعديل صفحة <span style="color: #ff0000">{{ $page->title }}</span> :</h2></div>
        <form action="{{ url('/fixed_pages/'.$page->id) }}" method="post" class="form-group">
            {{method_field('PUT')}}
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <label>عنوان الصفحة :</label>
                    <input type="text" name="title" value="{{ $page->title }}" class="form-control" placeholder="ضع هنا عنوان الصفحة ..." required>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>محتوى الصفحة :</label>
                    <textarea id="summernote" name="content_" required>{{$page->content}}</textarea>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <button type="submit" id="my_btn" class="btn btn-primary btn-block"><i class="fa fa-edit"></i>&nbsp;&nbsp;تعديل</button>
        </form>
        <!-- end of content -->


    </div>

@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true,                // set focus to editable area after initializing summernote
                lang: 'ar-AR'
            });
        });

        $('#my_btn').on('click', function () {
            var summernote_ = $("#summernote").val();
            if(summernote_ == ''){
                alert('يجب أن لا يكون محتوى الصفحة فارغ');
            }else{
            }

        });
    </script>
    </body>
    </html>
@endsection
