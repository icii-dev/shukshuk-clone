



<button class="navbar-toggler openbtn" onclick="openNav()" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
    <img src="{{ asset("vendor/buyer/Img/mdi_menu.svg") }}" alt="">
</button>
<div id="mySidepanel" class="sidepanel">
    <div class="body-sidepanel">
        <div class="row wrap-body">
            <div class="col-10 col-sidepanel">
                <div class="sp-loin">
                    <div class="container">
                        @if(!Auth::user())
                            <div class="wrap-login-mobi">
                                <div class="title-login d-flex justify-content-center">
                                    <p>Don’t have account?</p>
                                    <a href="{{route('mobile.register')}}">Register Now</a>
                                </div>
                                <a class="btn btn-primary btn-buy btn-check btn-login btn-login-mobi" href="{{route('mobile.login')}}" role="button">Login</a>
                                <p class="text-center or-with">or login with</p>
                                <div class="row face-google">
                                    <div class="col-6"><a href="{{ route('auth.social', 'facebook') }}"><img class="w-100 d-block" src="{{ asset("vendor/buyer/Img/FB-Sign-In.svg") }}" alt=""></a></div>
                                    <div class="col-6"><a href="{{ route('auth.social', 'google') }}"><img class="d-block w-100" src="{{ asset("vendor/buyer/Img/Google-Sign-In.svg") }}" alt=""></a></div>
                                </div>
                            </div>

                        @else

                            <div class="account-mobi">
                                <div class="avatar text-center">
                                    <img src="{{ asset("vendor/buyer/Img/avatar-1.png") }}" alt="">
                                    <h3 class="truncate-overflow-one">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</h3>
                                    <p onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="color-red log-out-mobi">@lang('Log Out')</p>
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
                <div class="profile-user">
                    <div>
                        <a class="d-flex order" href="{{ route('home') }}">
                            <img src="{{ asset("vendor/buyer/Img/home.svg") }}" alt="">
                            <p>Go to shukshuk.com</p>
                        </a>
                    </div>
                    <div>
                        <a class="d-flex order" href="{{route('seller.store.edit')}}">
                            <img src="{{ asset("vendor/buyer/svg/ic_account_circle.svg") }}" alt="">
                            <p>@lang('Manage Store')</p>
                        </a>
                    </div>
                    <div>
                        <a class="d-flex order" href="{{ route('seller.order.index') }}">
                            <img src="{{ asset("vendor/buyer/Img/order-black.svg") }}" alt="">
                            <p>@lang('Orders')</p>
                        </a>
                    </div>
                    <div>
                        <div class="d-flex order">
                            <a class="d-flex" href="{{ route('seller.messenger.index') }}">
                                <img src="{{ asset("vendor/buyer/Img/mdi_email.svg") }}" alt="">
                                <p>@lang('Messages')</p>
                                <span class="span-badge span-badge-red">{{ $totalMessage }}</span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex order">
                            <a class="s-flex" href="{{ route('seller.notification.index') }}"></a>
                            <img src="{{ asset("vendor/buyer/Img/bell.svg") }}" alt="">
                            <p>@lang('Notifications')</p>
                        </div>
                    </div>
                </div>
                <div class="footer-sidepannel">
                    <p>@lang('About Us')</p>
                    <p>@lang('Help Center')</p>
                    <div class="logo-footer sp d-flex">
                        <img src="{{ asset("vendor/buyer/Img/logo-light.svg") }}" alt="">
                        <p>PT. Shukshuk Indonesia</p>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="wrap-close h-100 w-100 m-auto" onclick="closeNav()">
                    <a href ="javascript:void(0)" class="closebtn d-block" onclick="closeNav()"><img class="w-100 d-block" src="{{ asset("vendor/buyer/Img/X.svg") }}" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>
