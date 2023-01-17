@extends('buyer.mobile.layout')

@section('title', 'Shopping Cart')

@section('content')

    <div class="register-screen login-menu">
        <div class="container">
            <div class="login">
                <div class="login-title d-flex justify-content-between">
                    <a href="{{route('home')}}" class="color-inter">&lt;- Back To Home</a>
                    <a href="{{route('mobile.login')}}"><span class="Register">Login</span></a>
                </div>
                <h2 class="welcom">Register</h2>
                <form id="registerForm">
                    <div class="form-group">
                        <input type="text" name="firstName" class="form-control" placeholder="First Name" required="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="lastName" class="form-control" placeholder="Last Name" required="">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required="">
                        <div class="error" id="validEmailRegister" ></div>
                    </div>
                    <div class="form-group">
                        <div class="pass-word" id="show_hide_password">
                            <input class="form-control" type="password" name="password" placeholder="Password">
                            <div class="show-hidden">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="pass" id="valiPassRegister"></div>
                    </div>
                    <a class="btn-customer secondary btn col-12" id="btnRegister" role="button">Register</a>
                </form>
                <p class="login-with">Or register with:</p>
                <div class="row">
                    <div class="col-6"><a href="{{ route('auth.social', 'facebook') }}"><img class="w-100 d-block" src="{{ asset("vendor/buyer/Img/FB Sign In.png") }}" alt=""></a></div>
                    <div class="col-6"><a href="{{ route('auth.social', 'google') }}"><img class="d-block w-100" src="{{ asset("vendor/buyer/Img/Google Sign In.png") }}" alt=""></a></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('import_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/mobi/register.js") }}"></script>
@endsection