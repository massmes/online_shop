@extends('home.layouts.home')

@section('title')
    صفحه ورود
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> ورود</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> ورود </h4>
                            </a>
                        </div>
                        <div class="tab-content">

                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{route('login')}}" method="post">
                                            @csrf
                                            <input name="email" class=" @error('email') mb-1 @enderror"
                                                   placeholder="ایمیل" type="email" value="{{old('email')}}">
                                            <div class="input-error-validation mb-3">
                                                @error('email')
                                                <strong>{{$message}}</strong>
                                                @enderror
                                            </div>

                                            <input type="password" name="password"
                                                   class=" @error('password') mb-1 @enderror" placeholder="رمز عبور">
                                            <div class="input-error-validation mb-3">
                                                @error('password')
                                                <strong>{{$message}}</strong>
                                                @enderror
                                            </div>
                                            <div class="button-box">
                                                <div class="login-toggle-btn d-flex justify-content-between">
                                                    <div>
                                                        <input name="remember" type="checkbox"
                                                            {{old('remember') ? 'checked' : ''}}
                                                        >
                                                        <label> مرا بخاطر بسپار </label>
                                                    </div>
                                                    <a href="{{route('password.request')}}"> فراموشی رمز عبور ! </a>
                                                </div>
                                                <button type="submit">ورود</button>
                                                <a href="{{route('provider.login',['provider'=>'google'])}}" class="btn btn-google btn-block mt-4">
                                                    <i class="sli sli-social-google"></i> ورود با حساب گوگل
                                                </a>
                                                <a href="{{route('login.cellphone')}}" class="btn btn-google btn-block mt-4">
                                                    <i class="fa fa-mobile-alt"></i> ورود با شماره موبایل
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
