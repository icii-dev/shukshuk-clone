@extends('layouts.buyer')

@section('title', 'Login')

@section('extra-css')
@endsection

@section('content')
    <div class="container" style="margin-bottom: 48px">
        <div class="row">
            <div class="cart col-md-4 offset-md-4 d-flex justify-content-center content-while">
                <form class="col-md-10" id="loginFormOnPage">
                    <div class="spacer"></div>
                    <div class="login-title d-flex justify-content-between">
                        <h2>@lang('Login')</h2>
                        <a class="nav-link back-register" href="#" data-toggle="modal" data-target="#modalRegister"
                           data-dismiss="modal"><span class="Register">@lang('Register')</span></a>
                    </div>
                    <div class="form-group">
                        <input class="form-control" value="{{ old('email') }}" type="email" name="email"
                               placeholder="@lang('Enter email')">
                        <div class="error" id="errorEmail">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="pass-word" id="show_hide_password">
                            <input class="form-control" value="{{ old('password') }}" name="password"
                                   type="password" placeholder="@lang('Password')">
                            <div class="show-hidden">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="error" id="errorPassword">

                        </div>
                    </div>
                    <div class="form-group">
                        <a id="btnLoginOnPage" class="w-100 btn btn-secondary">@lang('Login')</a>
                    </div>
                    <a class="forgot text-center" href="#" data-dismiss="modal" data-toggle="modal"
                       data-target="#modalForgotPass"><span>@lang('Forgot Password?')</span></a>
{{--                    <p class="login-with">Or login with:</p>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-6"><a href="{{ route('auth.social', 'facebook') }}"><img class="w-100 d-block login-with-img"--}}
{{--                                                            src="{{ asset("vendor/buyer/Img/FB-Sign-In.svg") }}" alt=""></a>--}}
{{--                        </div>--}}
{{--                        <div class="col-6"><a href="{{ route('auth.social', 'google') }}"><img class="d-block w-100 login-with-img"--}}
{{--                                                            src="{{ asset("vendor/buyer/Img/Google Sign In.png") }}"--}}
{{--                                                            alt=""></a></div>--}}
{{--                    </div>--}}

                </form>
            </div>
        </div>
    </div>

@endsection


@section('extra-footer')

    <script>
        var loginFormOnPage = $('#loginFormOnPage');
        var inputloginFormOnPage = $('#loginFormOnPage :input');
        inputloginFormOnPage.focus(function () {
            inputloginFormOnPage.removeClass('error');
            $('#errorEmail').html('');
            $('#errorPassword').html('');
        });

        $('#btnLoginOnPage').click(function () {
            var term = loginFormOnPage.serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/login',
                type: 'post',
                data: term,
                success: function (data, textStatus, jQxhr) {
                    if (data['error']) {
                        inputloginFormOnPage.addClass('error');
                        $('#errorEmail').html(data.error);
                        $('#errorPassword').html(data.error);
                    } else {
                        location.reload();
                    }
                },
                error: function (response) {
                    var errors = JSON.parse(response.responseText);
                    var messages = errors.errors;
                    inputloginFormOnPage.addClass('error');
                    $('#errorEmail').html(messages.email);
                    $('#errorPassword').html(messages.password);
                }
            });
        });
    </script>

@endsection