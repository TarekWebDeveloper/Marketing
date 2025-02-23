@extends('layouts.app')
@section('content')
<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">


@include('include.frontend.sidebar')

       </div>

<div class="col-lg-9 col-12">








        <div class="blog-page">
            @forelse($products as $product)

   



                <article class="blog__post d-flex flex-wrap myarticle">

                <!-- image -->


   



                

                    <div class="content">

                <!-- title -->

                        <h4><a href="{{route('products.show', $product->slug)}}">{{ $product->title }}</a></h4>




                       









                <!-- category -->


                <ul>
                        <li> قسم : <a href="">{{ $product->category->name }} </a></li>

                          </ul>

               




<!-- date -->

             <!-- user -->

             <ul>
             <li> <a href="">
             الناشر :  {{ $product->user->name }}   </a></li>

             <li>  التاريخ :  {{ $product->created_at->format('M d Y') }} </li>


</ul>

                <!-- description -->

                <p>{!! \Illuminate\Support\Str::limit($product->description, 100) !!}</p>

                <!-- products show -->

                <div class="blog__btn postText">

<a href="{{route('products.show', $product->slug)}}"> ...المزيد </a>
</div>
                    </div>


                    <div class="thumb">

<a href="{{route('products.show', $product->slug)}}">

@if($product->media->count() > 0)

<img  class="myimg"src="{{ asset('assets/image_product/' . $product->media->first()->file_name) }}" alt="{{ $product->title }}">
        @else
        <img src="{{ asset('assets/image_product/default.jpg') }}" alt="blog images">
    @endif
</a>
</div>




                </article>

            @empty

                <div class="text-center">لا يوجد منتجات  </div>

            @endforelse

        </div>
              <!-- pagination show -->


            {!! $products->appends(request()->input())->links() !!}
       </div>

 


@endsection