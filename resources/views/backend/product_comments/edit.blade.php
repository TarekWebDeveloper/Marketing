@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">
             ({{ $comment->product->title }}) تعديل التعليق على </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.product_comments.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">التعليقات</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            {!! Form::model($comment, ['route' => ['admin.product_comments.update', $comment->id],
                 'method' => 'patch']) !!}
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('name', 'الاسم') !!} {{ $comment->user_id != '' ? '(Member)' : '' }}
                        {!! Form::text('name', old('name', $comment->name), ['class' => 'form-control']) !!}
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('email', 'الايميل') !!}
                        {!! Form::email('email', old('email', $comment->email), ['class' => 'form-control']) !!}
                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
             

           
                <div class="col-6">
                    {!! Form::label('status', 'الحالة') !!}
                    {!! Form::select('status', ['1' => 'فعال', '0' => 'غير فعال '],
                       old('status', $comment->status), ['class' => 'form-control']) !!}
                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    {!! Form::label('comment', 'التعليق') !!}
                    {!! Form::textarea('comment', old('comment', $comment->comment),
                         ['class' => 'form-control', 'rows' => 5]) !!}
                    @error('comment')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group pt-4">
                {!! Form::submit(' تحديث التعليق ', ['class' => 'btn btn-primary send ']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
