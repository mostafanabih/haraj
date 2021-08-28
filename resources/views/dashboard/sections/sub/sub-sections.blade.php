@extends('layouts.dash-header')
<style>

</style>
@section('content')
    <div class="container " style="background: #F0F3F8;">
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
            <div class="col-md-6">
                <h3>الاقسام الفرعية ل <span style="color: #ff0000">{{$main_section->name}}</span></h3>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-2">
                <a href="{{route('add-sub-section', ['id' => $main_section->id])}}" class="btn btn-green "><i class="fa fa-plus"></i>&nbsp;&nbsp; إضافه قسم فرعى</a>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2" style="margin-top: 10px; background: white;">
            <table class="table table-striped table-hover table-responsive">
                <thead>
                <th>#</th>
                <th>القسم</th>
                <th>تعديل</th>
                {{--@if($main_section->id == 1)--}}
                    {{--<th>الاقسام الداخلية</th>--}}
                {{--@endif--}}
                <th>الاقسام الداخلية</th>
                <th>حذف</th>
                </thead>
                <tbody>
                @if(count($subs) > 0)
                @foreach($subs as $sub)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$sub->name}}</td>
                        <td><a href="{{url('/edit-sub-section/'.$sub->id)}}" class="btn btn-info "> تعديل</a></td>
                        {{--@if($main_section->id == 1)--}}
                            {{--<td><a href="{{url('/internal-sections/'.$sub->id)}}" class="btn btn-orange "> عرض</a></td>--}}
                        {{--@endif--}}
                        <td><a href="{{url('/internal-sections/'.$sub->id)}}" class="btn btn-orange "> عرض</a></td>

                        <td>
                            <form onsubmit="return confirm('سيتم حذف جميع الإعلانات المرتبطة بهذا القسم ... هل تريد الحذف بالتأكيد؟');" action="{{ url('/sub-section-delete/'.$sub->id) }}" method="post">
                                {{ method_field('DELETE') }}
                                @csrf
                                <button type="submit" class="btn btn-danger"> حذف</button>
                            </form>
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
            {{ $subs->onEachSide(1)->appends(Request::capture()->except('page'))->render()  }}
        </div>

    </div>

@endsection
@section('footer')




@endsection
