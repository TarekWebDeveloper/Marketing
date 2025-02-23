@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/js/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')

    <div class="col-lg-9 col-12">

        <h3>إنشاء منشور  </h3>

        {!! Form::open(['route' => 'product.store', 'method' => 'post', 'files' => true]) !!}

        <div class="form-group">

            {!! Form::label('title', 'العنوان') !!}

            {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}

            @error('title')<span class="text-danger">{{ $message }}</span>@enderror

        </div>






        <div class="form-group">

            {!! Form::label('description', 'المنشور') !!}

            {!! Form::textarea('description', old('description'), ['class' => 'form-control summernote']) !!}

            @error('description')<span class="text-danger">{{ $message }}</span>@enderror

        </div>



        <div class="row">

        <div class="col-4">

         {!! Form::label('status', 'الحالة') !!}

         {!! Form::select('status', ['1' => 'فعال', '0' => 'غير فعال'], old('status'), ['class' => 'form-control']) !!}

         @error('status')<span class="text-danger">{{ $message }}</span>@enderror

       </div>



          





            <div class="col-4">

                {!! Form::label('comment_able', 'التعليقات') !!}

                {!! Form::select('comment_able', ['1' => 'نعم', '0' => 'لا'], old('comment_able'), ['class' => 'form-control']) !!}

                @error('comment_able')<span class="text-danger">{{ $message }}</span>@enderror

            </div>

            <div class="col-4">

           {!! Form::label('category_id', 'قسم') !!}

           {!! Form::select('category_id', ['' => '---'] + $categories->toArray(), old('category_id'), ['class' => 'form-control']) !!}

         @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror

       </div>
           

        </div>




        <div class="row pt-4">

            <div class="col-12">

                <div class="file-loading">

                {!! Form::file('images[]', ['id' => 'product-images', 'multiple' => 'multiple']) !!}

                </div>
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



@section('script')
    <script src="{{ asset('frontend/js/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function () {
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            $('#product-images').fileinput({
                theme: "fa",
                maxFileCount: 3,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: true,
                showUpload: true,
                overwriteInitial: false,
            });
        });
    </script>
@endsection