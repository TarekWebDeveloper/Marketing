@extends('layouts.app')
@section('content')


<div class="col-lg-9 col-12">
        <div class="table-responsive">
            <table class="table">



                <thead>
                <tr>  



                    <th>العنوان</th>
                    <th>الحالة</th>

                    <th>التعليقات</th>

                    <th>لوحة التحكم</th>

                </tr>
                </thead>







                <tbody>
                @forelse($products as $product)
                    <tr>


                       


                        <td>{{ $product->title }}</td>
                        <td>{{ $product->status }}</td>

                        
                        <td><a href="{{ route('comments', ['product' => $product->id]) }}">

{{ $product->comments_count }}</a>
</td>


<td>

<a href="{{ route('product.edit', $product->id) }}" 
       class="btn btn-sm btn-primary">
       <i class="fa fa-edit"></i>
    </a>

    <a href="javascript:void(0);"

     onclick=
     "if (confirm(' هل تريد حذف المنشور ؟') ) 

         { document.getElementById('product-delete-{{ $product->id }}').submit();

      } else 

      { return false; }" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>
      </a>


    <form action="{{ route('product.destroy', $product->id) }}" method="post"

     id="product-delete-{{ $product->id }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
  
</td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="4">  😢 لا يوجد منشورات  </td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">{!! $products->links() !!}</td>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>

    <div class="col-lg-3 col-12 md-mt-35 sm-mt-40">
    @include('include.frontend.auth_sidebar.auth_sidebar')
    </div>

@endsection