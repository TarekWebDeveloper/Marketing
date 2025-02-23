@extends('layouts.app')
@section('content')



<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">

@include('include.frontend.sidebar')


</div>

<div class="col-lg-9 col-12">

        <div class="blog-details content">

            <article class="blog-product-details">

            @if ($product->media->count() > 0)

        <div id="carouselIndicators" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">

        @foreach($product->media as $media)

            <li data-target="#carouselIndicators" data-slide-to="{{ $loop->index }}" 
            class="{{ $loop->index == 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>
    <div class="carousel-inner">

        @foreach($product->media as $media)

            <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">

                <img class="d-block w-100" src="{{ asset('assets/image_product/' . $media->file_name) }}" alt="{{ $product->title }}">
            </div>
        @endforeach

    </div>

    @if ($product->media->count() > 1)

        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">

            <span class="carousel-control-prev-icon" aria-hidden="true"></span>

            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">

            <span class="carousel-control-next-icon" aria-hidden="true"></span>

            <span class="sr-only">Next</span>
        </a>
    @endif
    </div>
    @endif

                <div class="product_wrapper">

                    <div class="product_header">

                    <h2>{{ $product->title }}</h2>


                        <div class="blog-date-categori">
                        <ul>
                            <li>   <span>  قسم : {{ $product->category->name }}   </li>
                        </ul>
                            <ul>

                            <li><a href="{{ route('frontend.publisher.products',$product->user->username ) }}"
                             title="Products by 
                            {{ $product->user->name }}" rel="publisher">{{ $product->user->name }}</a></li>

                            </ul>
                        </div>
                    </div>

                    <div class="product_content">


                    <p>{!! $product->description !!}</p>

                    </div>
                    <ul class="blog_meta">
                    <br>

                        <li><a href="#">{{ $product->active_comments->count() }}   التعليقات </a></li>

<br>
                    </ul>
                    <br>

                </div>
            </article>

            <div class="comments_area">


                <ul class="comment__list">

                    @forelse ($product->active_comments as $mycomment)

                        <li>

                            <div class="wn__comment">

                                <div class="thumb">

                                   
                                <img src="{{ get_gravatar($mycomment->email, 46) }}" alt="comment images">

                                </div>

                                <div class="content">

                                    <div class="comnt__author d-block d-sm-flex">

                                     <span><a href="{{ $mycomment->url != '' ? $mycomment->url : '#' }}">{{ $mycomment->name }}</a></span>
                                    </div>
                                    <p>{{ $mycomment->comment }}</p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p>   لا يوجد تعليقات </p>
                    @endforelse
                </ul>
            </div>

            <div class="comment_respond">

                <h3 class="reply_title" >  &#x2709;   <small></small >   شاركنا    بتعليقك    </h3>

                {!! Form::open(['route' => ['products.add_comment', $product->slug], 'method' => 'post', 'class' => 'comment__form']) !!}

                <div class="input__box">

                    {!! Form::textarea('comment', old('comment'), ['placeholder' => '.... &#x270D;   ']) !!}

                    @error('comment')<span class="text-danger">{{ $message }}</span>@enderror

                </div>



                <div class="input__wrapper clearfix">

                 


                <div class="input__box website one--third">



</div>





                    <div class="input__box email one--third">

                        {!! Form::email('email', old('email'), ['placeholder' => 'الايميل   ']) !!}

                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror

                    </div>

                  

                    <div class="input__box name one--third">

{!! Form::text('name', old('name'), ['placeholder' => 'الاسم   ']) !!}

@error('name')<span class="text-danger">{{ $message }}</span>@enderror

</div>







                </div>

                <div class="submite__btn">

                    {!! Form::submit('حفظ التعليق ', ['class' => 'btn btn-primary']) !!}

                </div>

                {!! Form::close() !!}

            </div>

        </div>

    </div>


  


@endsection