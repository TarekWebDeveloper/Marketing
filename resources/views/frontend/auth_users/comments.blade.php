@extends('layouts.app')
@section('content')

    <div class="col-lg-9 col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                <th>الاسم</th>
                <th>المنشور</th>

                <th>حالة</th>
                <th>التعليق</th>


                    <th>لوحة التحكم</th>




                </tr>
                </thead>
                <tbody>
                @forelse($comments as $comment)
                    <tr>
                    <td>{{ $comment->name }}</td>

                    <td>{{ $comment->product->title }}</td>
                    <td>{{ $comment->status }}</td>
                    <td>{{ $comment->comment }}</td>

                    <td>
                            <a href="{{ route('comment.edit', $comment->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0);" onclick="if (confirm('هل تريد حذف التعليق ؟') ) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="post" id="comment-delete-{{ $comment->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>


                      








                     

                    </tr>
                @empty
                    <tr>
                        <td colspan="4"> 😢 لا يوجد تعليقات </td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">{!! $comments->appends(request()->input())->links() !!}</td>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>

    <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
    @include('include.frontend.auth_sidebar.auth_sidebar')
                </div>

@endsection