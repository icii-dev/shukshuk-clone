@extends('buyer.mobile.layout')

@section('title', 'Shopping Cart')

@section('content')

<div class="login-menu login-menu-mobi">
    <div class="container">
        <form class="login" id="loginForm">
            <div class="login-title d-flex justify-content-between">
                <a href="{{url('')}}" class="color-inter"><- Back To Home</a>
                <a href="{{route('mobile.register')}}"><span class="Register">Register</span></a>
            </div>
            <h2 class="welcom">Welcome back,</h2>
            <div class="from-group">
                <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="Enter email">
                <div class="pass invalid-password" id="z-email"></div>
            </div>
            <div class="form-group">
                <div class="pass-word" id="show_hide_password">
                    <input class="form-control" id="password-1" type="password" name="password" placeholder="Password">
                    <div class="show-hidden">
                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="pass invalid-password" id="z-password-1"></div>
            </div>
            <a class="btn-customer secondary btn col-12" id="btnLogin" style="color: #fff">Login</a>
            <a class="forgot text-center" href="{{route('mobile.resetPassword')}}"><span>Forgot Password?</span></a>
            <p class="login-with">Or login with:</p>
            <div class="row">
                <div class="col-6"><a href="{{ route('auth.social', 'facebook') }}"><img class="w-100 d-block" src="{{ asset("vendor/buyer/Img/FB-Sign-In.svg") }}" alt=""></a></div>
                <div class="col-6"><a href="{{ route('auth.social', 'google') }}"><img class="d-block w-100" src="{{ asset("vendor/buyer/Img/Google Sign In.png") }}" alt=""></a></div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('import_js')
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/mobi/login.js") }}"></script>
@endsection
