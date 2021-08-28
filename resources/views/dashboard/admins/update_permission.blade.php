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

        <div class="col-sm-12">
            <h2>تعديل صلاحيات المشرف <span style="color: #ff0000">{{ $admin->name }}</span> :</h2>
            <br>
        </div>
        <form action="{{ url('/permissions/'.$admin->id) }}" method="post" class="form-group">
            {{method_field('PUT')}}
            @csrf
            @if($permissions->count() > 0)
                @foreach($permissions as $permission)
                    <div class="col-md-3 col-xs-12">
                        <label><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @if(in_array($permission->id, $permission_role_)) {{ 'checked' }} @else {{ '' }} @endif>&nbsp;&nbsp;{{ $permission->name }}</label>
                    </div>
                @endforeach
            @else
                {{ 'لا يوجد صلاحيات لإعطائها للمشرف' }}
            @endif

            <input type="hidden" name="admin_id" value="{{ $admin->id }}">
            <div class="col-md-12 col-xs-12 clearfix"><br></div>
            <button type="submit" class="btn col-md-6 col-md-offset-3 btn-primary btn-block"><i class="fa fa-edit"></i>&nbsp;&nbsp;تعديل الصلاحيات</button>
        </form>
        <!-- end of content -->
        <div class="col-md-12 col-xs-12 clearfix"><br></div>

    </div>

@endsection
@section('footer')
    <script></script>
    </body>
    </html>
@endsection
