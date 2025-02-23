@extends('layouts.app')
@section('content')


<div class="col-lg-4 col-12 md-mt-40 sm-mt-40">
<div class="wn__address">

        </div>
    </div>


    <div class="col-lg-8 col-12">
        <div class="contact-form-wrap">
            <h2 class="contact__title">            يسرنا تواصلكم معنا لتقديم مقترحاتكم  
           
            
          
</h2>



  


            {!! Form::open(['route' => 'frontend.store_contact', 'method' => 'post', 'id' => 'contact-form']) !!}
            <div class="single-contact-form">
                {!! Form::text('name', old('name'), ['placeholder' => 'الاسم']) !!}
                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="single-contact-form space-between">
                {!! Form::email('email', old('email'), ['placeholder' => 'الايميل']) !!}
                {!! Form::text('mobile', old('mobile'), ['placeholder' => 'موبايل']) !!}
            </div>
            <div class="single-contact-form space-between">
                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="single-contact-form">
                {!! Form::text('title', old('title'), ['placeholder' => 'العنوان']) !!}
                @error('title')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="single-contact-form message">
                {!! Form::textarea('message', old('message'), ['placeholder' => '..ماهو مقترحكم']) !!}
                @error('message')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="contact-btn">
                {!! Form::button('إرسال ', ['type' => 'submit']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

















    
@endsection
