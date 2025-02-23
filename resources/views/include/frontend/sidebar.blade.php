<div class="wn__sidebar">



                                      <!--Search -->




    <!-- Start Single Widget -->

    <aside class="widget search_widget">

        <h3 class="widget-title">   البحث  </h3>

        {!! Form::open(['route' => 'frontend.search', 'method' => 'get']) !!}

        <div class="form-input">
        {!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit']) !!}

        {!! Form::text('keyword', old('keyword', request()->keyword), ['placeholder' => 'البحث']) !!}





        </div>

        {!! Form::close() !!}

    </aside>


    <!-- End Single Widget -->







   

   

    <!-- Start Single Widget -->
  
                                     <!--Recent Posts -->



                                     <aside class="widget recent_widget">

<h3 class="widget-title">أحدث المنشورات </h3>

<div class="recent-products">
    <ul>
        @foreach($recent_products as $recent_product)
            <li>
                <div class="post-wrapper d-flex">

                    


                    <div class="content recent">

                        <h4><a href="{{ route('products.show', $recent_product->slug) }}">

                   {{ \Illuminate\Support\Str::limit($recent_product->title, 16, '..') }}</a>
                
                    </h4>
                   <span> {{ $recent_product->created_at->format('M d, Y') }}</span>


                    </div>


                    <div class="thumb">

<a href="{{ route('products.show', $recent_product->slug) }}">

    @if($recent_product->media->count() > 0)

        <img src="{{ asset('assets/image_product/' . $recent_product->media->first()->file_name) }}"
         alt="{{ $recent_product->title }}">

    @else

        <img src="{{ asset('assets/image_product/default_small.png') }}" alt="blog images">

    @endif


</a>
</div>







                </div>
            </li>
        @endforeach
    </ul>
</div>
</aside>




    <!-- End Single Widget -->






 <!-- Start Single Widget -->

 <aside class="widget comment_widget">
        <h3 class="widget-title">التعليقات</h3>
        <ul  class=comment>



      
            @foreach($recent_comments as $recent_comment)


            <li>
            <div class="thumb">
            <p>   علق  {{ $recent_comment->name }}   
                
        </p>

        <a href="">{!! \Illuminate\Support\Str::limit($recent_comment->comment, 21, '') !!}</a>

                 
           <img src="{{get_gravatar($recent_comment->email, 47) }}" alt="{{ $recent_comment->name }}"
            class="myimg">

        
            

              
                

            </li>




       
             
            @endforeach
        </ul>
    </aside>





    <!-- End Single Widget -->


    <!-- Start Single Widget -->
    <aside class="widget category_widget">
        <h3 class="widget-title">الفئات</h3>
        <ul>
        @foreach($mycache_categories as $mycache_categorie)
                <li><a href="{{ route('frontend.category.products', $mycache_categorie->slug) }}">{{ $mycache_categorie->name }}</a></li>
            @endforeach
        </ul>
    </aside>
    <!-- End Single Widget -->



                                 <!-- Archives -->

<!-- Start Single Widget -->
<aside class="widget archives_widget">
        <h3 class="widget-title">الأرشيف </h3>
        <ul >
            <br>
            @foreach($mycache_archives as $key => $value)

            <li><a href="{{ route('frontend.archive.products', $key.'-'.$value) }}">{{ date("F", mktime(0, 0, 0, $key, 1)) . ' ' . $value }}</a></li>
            
            @endforeach
        </ul>
    </aside>
    <!-- End Single Widget -->








   
</div>





