<!-- Header -->


<header id="wn__header" class="oth-page header__area header__absolute sticky__header">
    <div class="container-fluid">
        <div class="row">
           
       

        <div class="col-md-8 col-sm-8 col-5 col-lg-2">
            <div class="mobile-menu d-block d-lg-none">
        </div>
        <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
        


  

           
        








 <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
      <div class="searchbar__content setting__block">
        <div class="content-inner">
         <div class="switcher-currency">
                          
         <div class="switcher-options">
          <div class="switcher-currency-trigger">
            <div class="setting__menu">
               @guest



 <span><a href="{{ route('frontend.show_login_form') }}">الدخول</a></span>

 <span><a href="{{route('frontend.show_register_form') }}">التسجيل </a></span>



                                       
  @else
  <span><a href="{{ route('dashboard') }}"> الادارة</a></span>

    <span><a href="{{ route('logout') }}" onclick="event.preventDefault(); 

    document.getElementById('logout-form').submit();">الخروج</a></span>

    <form id="logout-form" action="{{ route('logout') }}" method="product" style="display: none;">
         @csrf
     </form>
         @endguest
   </div>
   </div>
    </div>
     </div>
    </div>
      </div>
    </li>


   


                      




                      </li>



  

           
          </ul>

        

            </div>
       






































       


            <div class="col-lg-8 d-none d-lg-block">
                <nav class="mainmenu__nav">
                    <ul class="meninmenu d-flex justify-content-start">
                    <li><a href="{{ route('frontend.contact') }}">تواصل معنا </a></li>
                    <li class="drop"><a href="javascript:void(0);">قسم</a>
                        <div class="megamenu dropdown">
                                <ul class="item item01">
                                    @foreach($mycache_categories as $mycache_category)
                                        <li><a href="{{ route('frontend.category.products', $mycache_category->slug) }}">{{ $mycache_category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        <li class="drop with--one--item"><a href="{{ route('products.show', 'about-us') }}">من نحن</a></li>
                        <li class="drop with--one--item"><a href="{{ route('frontend.home') }}">الصفحة الرئيسية</a></li>

                    </ul>
                </nav>
            </div>







            <div class="col-md-4 col-sm-4 col-7 col-lg-2">
                <div class="logo">
                    <a href="{{ route('frontend.home') }}">
                        <img src="{{ asset('frontend/images/logo/logo.jpg') }}" alt="logo images">
                    </a>
                </div>
            </div>
        </div>

        <!-- Start Mobile Menu -->

      

        <div class="row d-none">
            <div class="col-lg-12 d-none">
                <nav class="mobilemenu__nav">
        
                <ul class="meninmenu">
                    <li><a href="{{ route('frontend.home') }}">الصفحة الرئيسية</a></li>
                        <li><a href="{{ route('products.show', 'about-us') }}">من نحن</a></li>
                        <li><a href="javascript:void(0);">قسم </a>
                            <ul>
                            <li><a href="#">التكنولوجيا</a></li>
                                <li><a href="#">العقارات</a></li>
                                <li><a href="#">السيارات</a></li>
                                <li><a href="#">غذائيات</a></li>


                                <li><a href="#">غير ذلك</a></li>


                            </ul>
                        </li>
                        <li><a href="{{ route('frontend.contact') }}">تواصل معنا </a></li>
                    </ul>
      
                </nav>
        
            </div>
        </div>
        <!-- End Mobile Menu -->
        
        <!-- Mobile Menu -->
    </div>
</header>
<!-- //Header -->
<!-- Start Search Popup -->
<div class="box-search-content search_active block-bg close__top">
    {!! Form::open(['route' => 'frontend.search', 'method' => 'get', 'id' => 'search_mini_form', 'class' => 'minisearch']) !!}
    <div class="field__search">


    <div class="action">
            <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('search_mini_form').submit();"><i class="zmdi zmdi-search"></i></a>
        </div> 


    {!! Form::text('keyword', old('keyword', request()->keyword), ['placeholder' => '...البحث']) !!}


    </div>
    {!! Form::close() !!}

    <div class="close__wrap">
        <span>close</span>
    </div>
</div>

<!-- End Search Popup -->
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--4">

</div>
<!-- End Bradcaump area -->





{{--
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container fi">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="product" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
--}}
