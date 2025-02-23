@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">مشرف جديد  </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.supervisors.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">مشرفون</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            {!! Form::open(['route' => 'admin.supervisors.store', 'method' => 'post', 'files' => true]) !!}
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('name', 'الاسم') !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('username', 'اسم المستخدم') !!}
                        {!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
                        @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('email', 'الايميل') !!}
                        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('mobile', 'موبايل') !!}
                        {!! Form::text('mobile', old('mobile'), ['class' => 'form-control']) !!}
                        @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('password', 'كلمة السر') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        {!! Form::label('status', 'الحالة') !!}
                        {!! Form::select('status', ['' => '---', '1' => 'فعال', '0' => 'غير فعال', ],old('status'), ['class' => 'form-control']) !!}
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::label('receive_email', 'استقبال ايميل ') !!}
                        {!! Form::select('receive_email', ['' => '---', '1' => 'نعم', '0' => 'لا', ],
                            old('receive_email'), ['class' => 'form-control']) !!}
                        @error('receive_email')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('bio', 'السيرة الذاتية') !!}
                        {!! Form::textarea('bio', old('bio'), ['class' => 'form-control']) !!}
                        @error('bio')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('permissions', 'صلاحيات') !!}
                        {!! Form::select('permissions[]', [] + $permissions->toArray(), 
                            old('permissions'), ['class' => 'form-control select-multiple-tags', 'multiple' => 'multiple']) !!}
                        @error('permissions')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="row pt-4">
                <div class="col-12">
                    {!! Form::label('User Image', 'صورة المستخدم') !!}
                    <br>
                    <div class="file-loading">
                        {!! Form::file('user_image', ['id' => 'user-image', 
                            'class' => 'file-input-overview']) !!}
                        <span class="form-text text-muted">يجب أن يكون عرض الصورة 300 بكسل × 300 بكسل</span>
                        @error('supervisors_image')
                        <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-group pt-4">
                {!! Form::submit('Submit', ['class' => 'btn btn-primary send']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>


    {{ var_dump($errors) }}

@endsection
@section('script')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select-multiple-tags').select2({
                minimumResultsForSearch: Infinity,
                tags: true,
                closeOnSelect:false
            });

            $('#user-image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
            });
        });
    </script>
@endsection
