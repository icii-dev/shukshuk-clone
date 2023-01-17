@extends('layouts.buyer')

@section('title', 'Reset Password')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/buyer/Css/home.css')}}">
@endsection

@section('content')

    <div class="container" style="margin-bottom: 48px">
        <div class="row">
            <div class="col-md-6">
                <div class="spacer"></div>
                <h2>Reset Password</h2>
                <div class="spacer"></div>
                @if (session()->has('status'))
                    <div class="col-12">
                        <div class="alert alert-primary alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                            <img src="{{ asset("vendor/buyer/Img/alert-success.svg") }}" alt="">
                            <p>{{ session()->get('status') }}</p>
                            <span aria-hidden="true" data-dismiss="alert" aria-label="Close">×</span>
                        </div>
                    </div>
                @endif @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="col-md-10" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <input id="email" type="email" class="form-control" name="email" placeholder="Email" required autofocus>
                    </div>

                    <div class="form-group">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary">@lang('Reset Password')</button>
                    </div>

                </form>
            </div>
            <div class="col-md-6 border-left">
                <div class="spacer"></div>
                <h2>Information</h2>
                <div class="spacer"></div>
                <p>
                    This password reset link will expire in 5 minutes.
                </p>
                <p>
                    If you did not request a password reset, no further action is required.
                </p>
                <p>
                    Regards,
                </p>
                <p>
                    Shukshuk
                </p>
                <div class="spacer"></div>
            </div>
        </div>
    </div>

@endsection