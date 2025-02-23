@extends('layouts.app')
@section('content')

    <div class="col-lg-9 col-12">
        <h3>تعديل التعليق على المنشور : ({{ $comment->product->title }})</h3>
        {!! Form::model($comment, ['route' => ['comment.update', $comment->id], 'method' => 'put']) !!}
        
        <div class="row myright">
        <div class="col-3 ">
                <div class="form-group ">
                    {!! Form::label('name', 'الاسم') !!}
                    {!! Form::text('name', old('name', $comment->name), ['class' => 'form-control']) !!}
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="col-3">
                <div class="form-group ">
                    {!! Form::label('email', 'إيميل ') !!}
                    {!! Form::text('email', old('email', $comment->email), ['class' => 'form-control']) !!}
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="col-3 ">
            <div class="myflot">
                {!! Form::label('status', 'حالة') !!}
              </div>
                {!! Form::select('status', ['1' => 'فعال', '0' => 'غير فعال'], old('status', $comment->status), ['class' => 'form-control']) !!}
                @error('status')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

         


        </div>
        <div class="row ">
            <div class="col-12 ">
                <div class="myflot">
                {!! Form::label('comment', 'التعليق') !!}
</div>
                {!! Form::textarea('comment', old('comment', $comment->comment), ['class' => 'form-control']) !!}
                @error('comment')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-group pt-4">
            {!! Form::submit('إرسال ', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
    <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
    @include('include.frontend.auth_sidebar.auth_sidebar')
                </div>

@endsection