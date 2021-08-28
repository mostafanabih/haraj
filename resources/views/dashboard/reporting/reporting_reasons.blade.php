@extends('layouts.dash-header')
@section('content')
    <div class="container " style="background: #F0F3F8;">
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


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-green pull-left" data-toggle="modal"
                data-target="#myModal1">
            <span><i class="fa fa-plus"></i>&nbsp;اضافة سبب تبليغ</span>
        </button>
        <!-- Modal -->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h2>اضافة سبب للتبليغ جديد : </h2>
                    </div>
                    <div class="modal-body col-md-12 text-center">
                        <form action="{{ url('/reporting_reasons') }}" method="post" class="form-group">
                            @csrf
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="ضع هنا سبب التبليغ ..." required>
                                </div>
                            </div>
                            <div class="col-sm-12 clearfix"></div>
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus"></i>&nbsp;&nbsp;أضف</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- start of content -->
        <div class="col-sm-12"><h2>أسباب التبليغ : </h2></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>السبب</th>
                        <th>الإعدادات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($reasons) > 0)
                        @for($i=0;$i<$reasons->count();$i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $reasons[$i]->name }}</td>
                                <td>
                                    <form onsubmit="return confirm('هل تريد الحذف بالفعل ؟');" action="{{ url('/reporting_reasons/'.$reasons[$i]->id) }}" method="post">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endfor
                    @else
                        <tr>
                            <td colspan="3" class="text-center"><h2>لا توجد بيانات حتى الأن ...</h2></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!--Pagination -->
        <div class="col-sm-12 text-center">
            {{ $reasons->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>
        <!--End Pagination-->

    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
