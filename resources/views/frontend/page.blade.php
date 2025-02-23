@extends('layouts.app')
@section('content')

<div class="col-lg-12 col-12">
                    <div class="blog-details content">
                        <article class="blog-product-details">
                            @if ($product->media->count() > 0)
                                <div id="carouselIndicators" class="carousel slide" 
                                data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach($product->media as $media)
                                            <li data-target="#carouselIndicators"
                                             data-slide-to="{{ $loop->index }}" 
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
                                        <a class="carousel-control-prev"
                                         href="#carouselIndicators"
                                          role="button"
                                           data-slide="prev">

                                            <span class="carousel-control-prev-icon" 
                                            aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next"
                                         href="#carouselIndicators" 
                                         role="button"
                                          data-slide="next">
                                            <span class="carousel-control-next-icon" 
                                            aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <div class="product_wrapper">
                                <div class="product_header">
                                </div>
                                <div class="product_content">
                                    <p>{!! $product->description !!}</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

@endsection