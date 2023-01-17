@extends('buyer.mobile.layout')

@section('title', 'Shopping Cart')

@section('content')

    <div class="login-menu login-menu-mobi">
        <div class="container">
            <form class="" action="{{route('password.email')}}" method="POST">
                {{ csrf_field() }}
                <div class="login-title d-flex justify-content-between">
                    <h2>Forgot Password?</h2>
                    <a class="nav-link back-register" href="#" data-toggle="modal" data-target="#modalRegister" data-dismiss="modal"><span class="Register">@lang('Register')</span></a></div>
                @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session()->get('status') }}
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
                <div class="form-group">
                    <input class="form-control @if(count($errors) > 0) error @endif"  type="email" name="email" value="{{ old('email') }}" placeholder="@lang('Enter email')">

                </div>
                <div class="form-group">
                    <button type="submit" class="w-100 btn btn-secondary" href="#">@lang('Reset Password')</button>
                </div>


            </form>
        </div>
    </div>

@endsection


