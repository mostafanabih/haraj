@extends('layouts.dash-header')
@section('content')
</section>
<!--End Header-->

<div class="container-fluid padding-r-l-50 my-4">
    <div class="row">
        <!-- start of content -->
        @if ($errors->any())
            <div class="text-center alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-sm-12">
            <h2>إضافة معلن جديد للقائمة السوداء :</h2>
        </div>

        <form action="{{ url('/black_list') }}" method="post" class="form-group">
            @csrf
            <div class="col-sm-12">
                <div class="form-group">
                    <select class="form-control m-b selectpicker" name="advertiser_id" data-live-search="true" required>
                        <option value="">اختر المعلن ...</option>
                        @foreach($advertisers as $advertiser)
                            <option value="{{ $advertiser->id }}">{{ $advertiser->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <div class="col-sm-12">
                <div class="form-group">
                    <textarea name="reason" class="form-control" placeholder="أكتب سبب وضع هذا المعلن فى القائمة السوداء ..." required></textarea>
                </div>
            </div>
            <div class="col-sm-12 clearfix"></div>
            <button type="submit" class="btn btn-primary btn-block">أضف</button>
        </form>
        <!-- end of content -->
    </div>
</div>

@endsection

@section('footer')
    <script type="text/javascript"></script>
    </body>
    </html>
@endsection