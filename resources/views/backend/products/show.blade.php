@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">منشور ({{ $product->title }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">المنشورات</span>
                </a>
            </div>
        </div>



        
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="4"><a href="{{ route('admin.products.show', $product->id) }}">
                            {{ $product->title }}</a></td>
                    </tr>
                    <tr>
                        <th>التعليق</th>
                        <td>{{ $product->comment_able == 1 ? $product->comments->count() : 'Disallow' }}</td>
                        <th>Status</th>
                        <td>{{ $product->status() }}</td>
                    </tr>
                    <tr>
                        <th>الفئة</th>
                        <td>{{ $product->category->name }}</td>
                        <th>Author</th>
                        <td>{{ $product->user->name }}</td>
                    </tr>
                    <tr>
                        <th> التاريخ</th>
                        <td>{{ $product->created_at->format('d-m-Y h:i a') }}</td>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="row">
                                @if($product->media->count() > 0)
                                    @foreach($product->media as $media)
                                        <div class="col-2">
                                            <img src="{{ asset('assets/image_product/' . $media->file_name) }}" 
                                            class="img-fluid">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>






    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">التعليقات</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>الصورة</th>
                    <th>Author</th>
                    <th width="40%">التعليفات</th>
                    <th>الحالة</th>
                    <th> التاريخ</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($product->comments as $comment)
                    <tr>
                        <td><img src="{{ get_gravatar($comment->email, 50) }}" class="img-circle"></td>
                        <td>{{ $comment->name }}</td>
                        <td>{!! $comment->comment !!}</td>
                        <td>{{ $comment->status() }}</td>
                        <td>{{ $comment->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.product_comments.edit', $comment->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="if (confirm('هل أنت متأكد من حذف التعليق؟? ') ) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.product_comments.destroy', $comment->id) }}" method="post" id="comment-delete-{{ $comment->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">لا يوجد تعليقات   </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
