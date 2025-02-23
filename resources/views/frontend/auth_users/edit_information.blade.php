@extends('layouts.app')
@section('content')

    <div class="col-lg-9 col-12">
        <h3>تحديث المعلومات </h3>
<br>
        {!! Form::open([

            'route' => 'update_information',

            'name' => 'user_information', 

            'id' => 'user_information',

            'method' => 'post',

            'files' => true]) !!}




        <div class="row inform">


        <div class="col-3">
                <div class="form-group ">

                    {!! Form::label('name', 'الاسم') !!}

                    {!! Form::text(

                        'name',

                        old('name', auth()->user()->name),

                        ['class' => 'form-control']) !!}


                    @error('name')

                    <span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>








            <div class="col-3">
                <div class="form-group">

                    {!! Form::label('email', 'الايميل') !!}

                    {!! Form::text(
                        'email',

                         old('email',

                        auth()->user()->email),

                        ['class' => 'form-control']) !!}

                    @error('email')

                    <span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>



            <div class="col-3">

<div class="form-group">

    {!! Form::label('mobile', 'الموبايل') !!}

    {!! Form::text(

       'mobile', 

        old('mobile',

         auth()->user()->mobile), 

         ['class' => 'form-control']) !!}

    @error('mobile')
    <span class="text-danger">{{ $message }}</span>@enderror
</div>
</div>


          

        <div class="col-3">
                <div class="form-group">
                    {!! Form::label('receive_email', 'أستقبال الايميل ') !!}

                    {!! Form::select(

                        'receive_email', 

                         ['1' => 'نعم', '0' => 'لا'], 

                         old('receive_email',

                         auth()->user()->receive_email),

                         ['class' => 'form-control']) !!}

                    @error('receive_email')
                    <span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

          

        
          



           





          









        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {!! Form::label('bio', 'لمحة') !!}
                    {!! Form::textarea('bio', old('bio', auth()->user()->bio), ['class' => 'form-control']) !!}
                    @error('bio')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="row myright">
            @if (auth()->user()->user_image != '')
                <div class="col-12">
                <img src="{{ asset('assets/users/' . auth()->user()->user_image) }}" class="img-fluid" width="150" alt="{{ auth()->user()->name }}">
                </div>
            
  
          </div>
             

              
                

            @endif

            <div class="row">
            <div class="col-12 myimage">
                <div class="form-group ">
                    {!! Form::label('user_image', 'صورة المستخدم ') !!}
                    {!! Form::file('user_image', ['class' => 'custom-file']) !!}
                    @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>


            <div class="col-12">
                <div class="form-group mybutton1 ">
                    {!! Form::submit('تحديث المعلومات ', ['name' => 'update_information', 'class' => 'btn btn-primary ']) !!}
                </div>
                    </div>
        </div>
        {!! Form::close() !!}






















     
































































      
      {!! Form::open(['route' => 'update_password', 'name' => 'user_password', 'id' => 'user_password', 'method' => 'post']) !!}
    <div class="row inform">
       
    <div class="col-4">
            <div class="form-group">
                {!! Form::label('current_password', 'كلمة السر الحالية  ') !!}
                {!! Form::password('current_password', ['class' => 'form-control']) !!}
                @error('current_password')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>


        <div class="col-4">
            <div class="form-group">
                {!! Form::label('password', 'كلمة السر جديدة') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>





        <div class="col-4">
            <div class="form-group">
                {!! Form::label('password_confirmation', 'إعادة كلمة السر') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
       
       





        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {!! Form::submit('تحديث كلمة السر  ', ['name' => 'update_password', 'class' => 'btn btn-primary mybutton']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>


    

  </div>







  <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
    @include('include.frontend.auth_sidebar.auth_sidebar')





                </div>





@endsection