@extends('layouts.admin-auth')

@section('content')

    <!-- Outer Row -->
<div class="row justify-content-center">

 <div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">

     <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
         <div class="col-lg-6">
         <div class="p-5">
             <div class="text-center">
             <h1 class="h4 text-gray-900 mb-4">مرحبا بك </h1>
                 </div>

                 {!! Form::open(['route' => 'admin.show_login_form', 'method' => 'post']) !!}
                      <div class="form-group">
                         {!! Form::text('username', old('username'),
                         ['class' => 'form-control form-control-user', 
                         'placeholder' => 'اسم المستخدم   ']) !!}

                          @error('username')
                           <span class="text-danger">{{ $message }}</span>@enderror
                       </div>


                       <div class="form-group">
                         {!! Form::password('password',
                         ['class' => 'form-control form-control-user', 
                         'placeholder' => 'كلمة السر   ']) !!}
                         @error('password')
                        <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                               
                        {!! Form::button('تسجيل الدخول',
                        ['type' => 'submit', 'class' => 'btn btn-primary btn-user btn-block']) !!}
                        {!! Form::close() !!}

                        <hr>
                        <div class="text-center">
                         <a class="small" href="{{ route('password.request') }}">نسيت كلمة السر</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
