@extends('layouts.dash-header')
<style>

</style>
@section('content')
    <div class="container-fluid padding-r-l-50 " style="background: #F0F3F8;">
        <div class="col-md-12" style="margin-top: 10px;">
            @if(count($errors) > 0)
                <div class="alert alert-danger text-center">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif
            @if(session()->has('success'))
                <p class="alert alert-success text-center">{{ session('success') }}</p>
            @endif
            @if(session()->has('error'))
                <p class="alert alert-danger text-center">{{ session('error') }}</p>
            @endif
        </div>
        <div class="col-md-12 " style="margin-top: 10px;">
            <div class="col-md-2">
                <h3>الاقسام الرئيسيه</h3>
            </div>
            <div class="col-md-2 col-md-push-8">
                <a href="{{route('add-main-section')}}" class="btn btn-green "><i class="fa fa-plus"></i>&nbsp;&nbsp; إضافه قسم رئيسى</a>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2" style="margin-top: 10px; background: white;">
            <table class="table table-striped table-hover table-responsive">
                <thead>
                <th>#</th>
                <th>القسم</th>
                <th>تعديل</th>
                <th>الاقسام الفرعيه</th>
                <th>حذف</th>
                </thead>
                <tbody>
                @if(count($m_sections) > 0)
                @foreach($m_sections as $m_section)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$m_section->name}}</td>
                        <td><a href="{{url('/edit-main-section/'.$m_section->id)}}" class="btn btn-info "> تعديل</a></td>
                        <td><a href="{{url('/sub-sections/'.$m_section->id)}}" class="btn btn-orange "> عرض</a></td>
                        <td>
                            @if($m_section->id == 1)
                                @else
                                <form onsubmit="return confirm('سيتم حذف جميع الإعلانات المرتبطة بهذا القسم ... هل تريد الحذف بالتأكيد؟');" action="{{ url('/main-section-delete/'.$m_section->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    @csrf
                                    <button type="submit" class="btn btn-danger"> حذف</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="4">
                            <div class="col-md-12 text-center"><h3>لا توجد أقسام حتى الأن ...</h3></div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <div class="col-sm-12 text-center">
            {{ $m_sections->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>

    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
