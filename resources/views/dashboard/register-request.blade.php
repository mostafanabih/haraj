@extends('layouts.dash-header')
<style>

</style>
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
        <div class="col-md-12 " style="margin-top: 10px;">
            <h3>طلبات الاشتراك</h3>
        </div>
        <div class="col-md-12 table-responsive" style="margin-top: 5px;">
            <table class="table table_noborder table-hover table-striped" style="background: white">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>تاريخ الطلب</th>
                    <th>الباقة</th>
                    <th colspan="2">الاعدادات</th>
                </tr>
                </thead>
                <tbody>
                @if(count($requests) > 0)
                    @foreach($requests as $req)
                    
                    
                    @if($req->package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $req->Advertiser->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($req->updated_at)->format('d/m/Y') }}</td>
                            <td>{{ $req->package->name.' ('.$req->package->duration.' شهر '.' > '.$req->package->price.' $ )' }}</td>
                            <td>
                                <form action="{{ url('/add_subscription/'.$req->id) }}" method="post"
                                      class="form-group">
                                    {{method_field('PUT')}}
                                    @csrf
                                    <input type="hidden" name="duration" value="{{ $req->package->duration }}">
                                    <input type="hidden" name="advertiser_id" value="{{ $req->advertiser_id }}">
                                    <button type="submit" class="btn btn-primary btn-block"><i
                                                class="fa fa-thumbs-up"></i>&nbsp;&nbsp;موافق
                                    </button>
                                </form>
                            </td>
                            <td style="color: #FB6575">
                                <form onsubmit="return confirm('هل تريد الإلغاء بالفعل؟');" action="{{ url('/add_subscription/'.$req->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;الغاء
                                    </button>
                                </form>
                            </td>
                        </tr>
                        
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center"><h2>لا توجد طلبات اشتراك حتى أن ...</h2></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <!--Pagination -->
        <div class="col-sm-12 text-center">
            {{ $requests->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>

    </div>
@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
