@extends('layouts.app')

@section('content')
    <section class="my_account_area pt--80 pb--55 bg--white">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 offset-md-3">

                    <div class="my__account__wrapper">
                        <h3 class="account__title">تسجيل الدخول</h3>

                        {!! Form::open(['route' => 'frontend.login',  'method' => 'post']) !!}

                        <div class="account__form myform">

                            <div class="input__box">

                                {!! Form::label('username', 'اسم المستخدم *') !!}

                                {!! Form::text('username', old('username')) !!}

                                @error('username')<span class="text-danger">{{ $message }}</span>@enderror

                            </div>

                            <div class="input__box">

                                {!! Form::label('password', 'كلمة السر *') !!}

                                {!! Form::password('password') !!}

                                @error('password')<span class="text-danger">{{ $message }}</span>@enderror

                            </div>


                            <div class="form__btn">

                                {!! Form::button('تسجيل الدخول', ['type' => 'submit']) !!}

                                <label class="label-for-checkbox">



                                </label>

                            </div>

                            
                            <a class="forget_pass" href="{{ route('password.request') }}">نسيت كلمة السر؟</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection