@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">  ({{ $page->title }}) تعديل الصفحة </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">الصفحات</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            {!! Form::model($page, ['route' => ['admin.pages.update', $page->id], 'method' => 'patch', 'files' => true]) !!}
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('title', 'العنوان') !!}
                        {!! Form::text('title', old('title', $page->title), ['class' => 'form-control']) !!}
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {!! Form::label('description', 'التوصيف') !!}
                        <br><br>

                        {!! Form::textarea('description', old('description', $page->description),

                             ['class' => 'form-control summernote']) !!}

                        @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    {!! Form::label('category_id', 'الفئة') !!}
                    {!! Form::select('category_id', ['' => '---'] + $categories->toArray(), 

                        old('category_id', $page->category_id),

                         ['class' => 'form-control']) !!}
                    @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="col-6">
                    {!! Form::label('status', 'الحالة') !!}

                    {!! Form::select('status', ['1' => 'فعال', '0' => 'غير فعال'], 

                        old('status', $page->status), ['class' => 'form-control']) !!}

                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row pt-4">
                <div class="col-12">
                    {!! Form::label('Sliders', 'الصورة') !!}
                    <br><br>
                    <div class="file-loading">
                        {!! Form::file('images[]', ['id' => 'page-images',

                             'class' => 'file-input-overview', 'multiple' => 'multiple']) !!}

                        <span class="form-text text-muted"> 800px x 500px حجم الصورة يجب أن يكون </span>

                        @error('images')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-group pt-4">
                {!! Form::submit('نحديث الصفحة ', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
@section('script')
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

            $('#page-images').fileinput({
                theme: "fas",
                maxFileCount: {{ 5 - $page->media->count() }},
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: true,
                showUpload: true,
                overwriteInitial: true,
                initialPreview: [
                    @if($page->media->count() > 0)
                        @foreach($page->media as $media)
                            "{{ asset('assets/image_product/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,

                initialPreviewFileType: 'image',

                initialPreviewConfig: [

                    @if($page->media->count() > 0)

                        @foreach($page->media as $media)

                            {caption: "{{ $media->file_name }}", 

                            size: "{{ $media->file_size }}", 

                            width: "120px",

                            url: "{{ route('admin.pages.image.destroy', [$media->id, '_token' => csrf_token()]) }}",

                            key: "{{ $media->id }}"},
                            
                        @endforeach
                    @endif
                ],
            });
        });
    </script>
@endsection








