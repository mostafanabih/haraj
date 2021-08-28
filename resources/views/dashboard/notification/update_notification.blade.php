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

        <div class="col-sm-12"><h2>تعديل إشعار للإعلان رقم <span style="color: #ff0000">{{ $notification->adv_id }}</span> :</h2></div>
        <form action="{{ url('/notification/'.$notification->id) }}" method="post" class="form-group">
            {{method_field('PUT')}}
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <label>نص الإشعار</label>
                    <textarea name="content_" class="form-control" placeholder="ضع هنا نص الإشعار ..."
                              required>{{ $notification->content }}</textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>رقم الإعلان :</label>
                    <input type="text" name="adv_id" id="adv_id" value="{{ $notification->adv_id }}" class="form-control"
                           placeholder="ضع هنا رقم الإعلان ..." required>
                    <h4 id="result">
                        <span class="text-success">الإعلان : ({{$adv->title}})</span>
                        <input type="hidden" name="advertiser_id" value="{{ $notification->advertiser_id }}">
                    </h4>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <button id="btn" type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>&nbsp;&nbsp;أضف
            </button>
        </form>
        <!-- end of content -->


    </div>

@endsection
@section('footer')
    <script>
        $(function () {
            $('#adv_id').on('keyup', function () {
                var adv_id = $("#adv_id").val();
                $.ajax({
                    url: "{{ url('/adv_search') }}",
                    type: "post",
                    data: {'adv_id': adv_id, '_token': '{{ csrf_token() }}'},
                    success: function (data) {
                        $('#result').empty().append(data);
                        if (data == '<span class="text-danger">رقم الإعلان الذى أدخلته غير صحيح</span>') {
                            $('#btn').prop('disabled', true);
                        } else {
                            $('#btn').prop('disabled', false);
                        }
                    }
                });
            });
        });
    </script>
    </body>
    </html>
@endsection
