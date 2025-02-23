@extends('layouts.admin')
@section('content')

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">منتجات</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    
                    <span class="text">اضافة منتج جديد </span>
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                </a>
            </div>
        </div>

        @include('backend.products.filter.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>العنوان</th>
                    <th>التعليقات</th>
                    <th>الحالة</th>
                    <th>الفئة</th>
                    <th>مستخدمين</th>
                    <th> التاريخ</th>
                    <th class="text-center" style="width: 30px;">لوحة التحكم </th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)

                <td><a href="{{ route('admin.products.show', $product->id) }}">{{ $product->title }}</a></td>

                <td>{!! $product->comment_able == 1 ? "<a href=\"" . route('admin.product_comments.index', ['product_id' => $product->id]) . "\">" . $product->comments->count() . "</a>" : 'Disallow' !!}</td>

                        <td>{{ $product->status() }}</td>

                        <td><a href="{{ route('admin.products.index', ['category_id' => $product->category_id]) }}">{{ $product->category->name }}</a></td>
                        <td>{{ $product->user->name }}</td>
                        <td>{{ $product->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="if(confirm('هل متأكد من حذف المنتج؟') ) { document.getElementById('product-delete-{{ $product->id }}').submit(); } else { return false; }" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" id="product-delete-{{ $product->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">لا يوجد منشورات  </td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7">
                        <div class="float-right">
                            {!! $products->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


@endsection
