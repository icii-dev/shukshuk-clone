<div class="modal fade moda-register" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="Register" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <form id="registerForm">
                        <div class="login-title d-flex justify-content-between">
                            <h2>@lang('Register')</h2>
                            <a class="nav-link back-to-login" href="#" data-toggle="modal" data-target="#modalLogin" data-dismiss="modal"><span class="Register">@lang('Back To Login')</span></a>
                        </div>
                        <div class="row row-register-home">
                            <div class="form-group col-6 col-register-home">
                                <input type="text" class="form-control" name="firstName" placeholder="@lang('First Name')" required>
                            </div>
                            <div class="form-group col-6 col-register-home">
                                <input type="text" class="form-control" name="lastName" placeholder="@lang('Last Name')" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="@lang('Email Address')" required>
                            <div class="error" id="validEmailRegister" ></div>
                        </div>
                        <div class="form-group">
                            <div class="pass-word" id="show_hide_password">
                                <input class="form-control" type="password" name="password" placeholder="@lang('Password')">
                                <div class="show-hidden">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="error" id="valiPassRegister"></div>
                        </div>
                        <div class="form-group">
                            <div class="pass-word" id="show_hide_password">
                                <input class="form-control" type="password" name="password_confirmation" placeholder="@lang('Password, type again please')">
                                <div class="show-hidden">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="error" id="valiRePassRegister"></div>
                        </div>
                        <div class="register-policy">@lang('By clicking the register button, you agree to our')
                            <a href="{{route('footer.about', 'terms-conditions')}}">@lang('Terms & Conditions')</a> @lang('and our') <a href="{{route('footer.about', 'private-policy')}}">@lang('Privacy Policy')</a>.</div>
                        <a class="w-100 btn btn-check btn-disable" id="btnRegister" role="button">@lang('Register')</a>
{{--                        <p class="login-with Register">Or login with:</p>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-6"><a href="{{ route('auth.social', 'facebook') }}"><img src="{{ asset("vendor/buyer/Img/FB-Sign-In.svg") }}" alt=""></a></div>--}}
{{--                            <div class="col-6"><a href="{{ route('auth.social', 'google') }}"><img src="{{ asset("vendor/buyer/Img/Google-Sign-In.svg") }}" alt=""></a></div>--}}
{{--                        </div>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-login" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <form class="" id="loginForm">
                        <div class="login-title d-flex justify-content-between">
                            <h2>@lang('Login')</h2>
                            <a class="nav-link back-register" href="#" data-toggle="modal" data-target="#modalRegister" data-dismiss="modal"><span class="Register">@lang('Register')</span></a></div>
                        <div class="form-group">
                            <input class="form-control" value="{{ old('email') }}" type="email" name="email" id="emailLogin" placeholder="@lang('Enter email')">
                            <div class="error" id="z-email" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="pass-word" id="show_hide_password">
                                <input class="form-control" value="{{ old('password') }}" id="passwordLogin" name="password" type="password" placeholder="@lang('Password')">
                                <div class="show-hidden">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="error" id="z-password-1">

                            </div>
                        </div>
                        <div class="form-group">
                            <a id="btnLogin" class="w-100 btn btn-secondary" >@lang('Login')</a>
                        </div>
                        <a class="forgot text-center" href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalForgotPass"><span>@lang('Forgot Password?')</span></a>
{{--                        <p class="login-with">Or login with:</p>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-6"><a href="{{ route('auth.social', 'facebook') }}"><img class="w-100 d-block" src="{{ asset("vendor/buyer/Img/FB-Sign-In.svg") }}" alt=""></a></div>--}}
{{--                            <div class="col-6"><a href="{{ route('auth.social', 'google') }}"><img class="d-block w-100" src="{{ asset("vendor/buyer/Img/Google Sign In.png") }}" alt=""></a></div>--}}
{{--                        </div>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-login" id="modalForgotPass" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <form class="" action="{{route('password.email')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="login-title d-flex justify-content-between">
                            <h2>@lang('Forgot Password?')</h2>
                            <a class="nav-link back-register" href="#" data-toggle="modal" data-target="#modalRegister" data-dismiss="modal"><span class="Register">@lang('Register')</span></a></div>
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <input class="form-control @if(count($errors) > 0) error @endif"  type="email" name="email" value="{{ old('email') }}" placeholder="@lang('Enter email')">

                        </div>
                        <div class="form-group">
                            <button type="submit" class="w-100 btn btn-secondary" href="#">@lang('Reset Password')</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-login" id="modalForgotPassuccess" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" style="margin-top: 10%">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="alert alert-primary alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
            <img src="{{ asset("vendor/buyer/Img/alert-success.svg") }}" alt="">
            <p>{{ session()->get('status') }}</p>
            <span aria-hidden="true" data-dismiss="modal" aria-label="Close">×</span>
        </div>

    </div>
</div>

@if(session('isSendResetPassword') === true && count($errors) > 0)
    <script>
        $('#modalForgotPass').modal();
    </script>
@elseif(session()->has('status'))
    <script>
        $('#modalForgotPassuccess').modal();
    </script>
@endif