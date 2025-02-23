@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">فئة جديدة </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.product_categories.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">الفئات</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            {!! Form::open(['route' => 'admin.product_categories.store', 'method' => 'post']) !!}
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        {!! Form::label('name', 'الاسم') !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="col-4">
                    {!! Form::label('status', 'الحالة') !!}
                    {!! Form::select('status', ['1' => 'فعال', '0' => 'غير غعال'], old('status'),
                         ['class' => 'form-control']) !!}
                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group pt-4 send">
                
                {!! Form::submit('إرسال ', ['class' => 'btn btn-primary ']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
