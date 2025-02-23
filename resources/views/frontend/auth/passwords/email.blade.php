@extends('layouts.app')

@section('content')








<section class="my_account_area pt--80 pb--55 bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-md-3">
                    <div class="my__account__wrapper myform2">
                        <h3 class="account__title">اعادة كلمة السر  </h3>
                        {!! Form::open(['route' => 'password.email', 'method' => 'post']) !!}

                        <div class="account__form">
                            <div class="input__box">
                                {!! Form::label('email', 'ايميل *') !!}
                                {!! Form::email('email', old('email')) !!}
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form__btn">
                                {!! Form::button('ارسال ', ['type' => 'submit']) !!}
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
