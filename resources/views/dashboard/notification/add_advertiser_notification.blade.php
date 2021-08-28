@extends('layouts.dash-header')
@section('content')
    <div class="container-fluid padding-r-l-50" style="background: #F0F3F8;">
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

        <div class="col-sm-12"><h2>إضافة إشعار جديد خاص بمستخدم : </h2></div>
        <form id="my_submit_form" action="{{ url('/add_advertiser_notification') }}" method="post" class="form-group">
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <label>نص الإشعار</label>
                    <textarea name="content_" class="form-control" placeholder="ضع هنا نص الإشعار ..."
                              required>{{ old('content') }}</textarea>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label>اختر معلن : </label>
                    <select class="form-control selectpicker" name="advertiser" id="advertiser" data-live-search="true" required>
                        <option value="">اختر معلن ...</option>
                        @foreach($advertisers as $advertiser)
                            <option value="{{ $advertiser->id }}">{{ $advertiser->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <label class="col-md-2"> نوع الاشعار : </label>
                <div class="col-md-10">
                    <div class="col-md-3">
                        <label>
                            <input type="radio" name="type" value="0" required> عام (كل المعلنين)
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label>
                            <input type="radio" name="type" value="1" required> خاص بالمعلن فقط
                        </label>
                    </div>
                </div>

            </div>
            <div class="col-sm-12 clearfix"></div>
            <button id="my_submit_form_btn" type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>&nbsp;&nbsp;أضف</button>
        </form>
        <!-- end of content -->


    </div>

@endsection
@section('footer')
    <script>
        $(function () {
            $('input[name="type"]').on('change', function () {
                let type = $('input[name="type"]:checked').val();
                if (type == 0) {
                    $('#advertiser').prop('disabled', true);
                } else {
                    $('#advertiser').prop('disabled', false);
                    $('.selectpicker').selectpicker('refresh');
                }
            });

            $(document).ready(function () {
                let type = $('input[name="type"]:checked').val();
                if (type == 0) {
                    $('#advertiser').prop('disabled', true);
                } else {
                    $('#advertiser').prop('disabled', false);
                    $('.selectpicker').selectpicker('refresh');
                }
            });

        });
    </script>
    </body>
    </html>
@endsection
