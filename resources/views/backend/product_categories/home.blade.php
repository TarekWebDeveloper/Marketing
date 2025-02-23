@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="ml-auto">
                <a href="{{ route('admin.product_categories.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">  اضافة فئة جديدة</span>
                </a>
            </div>
        </div>

        @include('backend.product_categories.filter.filter')

        <div class="table-responsive">


            <table class="table table-hover">


          <!--head -->
                <thead>
                <tr>
                    <th>الاسم</th>
                    <th>عدد المنشورات </th>
                    <th>الحالة</th>
                    <th> التاريخ</th>
                    <th class="text-center" style="width: 30px;">لوحة التحكم</th>
                </tr>
                </thead>




          <!--body -->


                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td><a href="{{ route('admin.products.index',
                             ['category_id' => $category->id]) }}">{{ $category->products_count }}</a></td>
                        <td>{{ $category->status() }}</td>
                        <td>{{ $category->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.product_categories.edit', $category->id) }}"

                                 class="btn btn-primary"><i class="fa fa-edit"></i></a>

                     <a href="javascript:void(0)" onclick="if (confirm('هل تريد حذف الفئة ') )

                      { document.getElementById('category-delete-{{ $category->id }}').submit(); } else 

                      { return false; }" class="btn btn-danger"><i class="fa fa-trash"></i></a>

                       <form action="{{ route('admin.product_categories.destroy', $category->id) }}" 
                       method="post" 
                       id="category-delete-{{ $category->id }}" 
                       style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">لا يوجد فئات   </td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="5">
                        <div class="float-right">
                            {!! $categories->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


@endsection
