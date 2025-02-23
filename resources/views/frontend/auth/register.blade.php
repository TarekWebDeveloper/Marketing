@extends('layouts.app')


@section('content')

    <section class="my_account_area pt--80 pb--55 bg--white">
        <div class="container">
            <div class="row">

            
                <div class="col-lg-6 offset-md-3">
                    <div class="my__account__wrapper myform2">
                        <h3 class="account__title">التسجيل بالموقع </h3>
                        {!! Form::open(['route' => 'frontend.register', 'method' => 'POST', 'files' => true]) !!}

                        <div class="account__form">
                            <div class="input__box">

                                {!! Form::label('name', 'الاسم') !!}
                                {!! Form::text('name', old('name')) !!}

                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror

                            </div>


                            <div class="input__box">
                                {!! Form::label('username', 'اسم المستخدم ') !!}
                                {!! Form::text('username', old('username')) !!}
                                @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>



                            <div class="input__box">
                                {!! Form::label('email', 'ايميل') !!}
                                {!! Form::email('email', old('email')) !!}
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>



                            <div class="input__box">
                                {!! Form::label('mobile', ' موبايل') !!}
                                {!! Form::text('mobile', old('mobile')) !!}
                                @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>


                            <div class="input__box">
                                {!! Form::label('password', 'كلمة السر') !!}
                                {!! Form::password('password') !!}
                                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>



                            <div class="input__box">
                                {!! Form::label('password_confirmation', 'اعادة كلمة السر ') !!}
                                {!! Form::password('password_confirmation') !!}
                                @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>



                            <div class="input__box">
                                {!! Form::label('user_image', 'صورة المستخدم ') !!}
                                {!! Form::file('user_image', ['class' => 'custom-file']) !!}
                                @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>



                            <div class="form__btn">
                                {!! Form::button('انشاء حساب  ', ['type' => 'submit']) !!}
                            </div>
                            <a class="forget_pass" href="{{ route('frontend.show_login_form') }}">تسجيل الدخول ؟</a>

                        </div>

                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </section>















    
@endsection

