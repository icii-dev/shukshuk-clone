<button style="padding: 0;" class="navbar-toggler openbtn" onclick="openNav()" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
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
                                    <p>@lang('Don’t have account?')</p>
                                    <a href="{{route('mobile.register')}}">@lang('Register Now')</a>
                                </div>
                                <a class="btn btn-primary btn-buy btn-check btn-login btn-login-mobi" href="{{route('mobile.login')}}" role="button">@lang('Login')</a>
                                <p class="text-center or-with">@lang('or login with')</p>
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
                                    @if (auth()->user()->store && auth()->user()->store->status != \App\Model\Store::STATUS_DRAFT)
                                        <a class="dropdown-item register" href="{{ route('seller.home') }}">@lang('Go to seller dashboard') &#x2192;</a>
                                    @else
                                        <a class="dropdown-item register" href="{{ route('seller.register') }}">@lang('Register as Seller') &#x2192;</a>
                                    @endif
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
                            <p>@lang('Home')</p>
                        </a>
                    </div>
                    <div>
                        <a class="d-flex order" href="{{ route('users.edit') }}">
                            <img src="{{ asset("vendor/buyer/svg/ic_account_circle.svg") }}" alt="">
                            <p>@lang('Account')</p>
                        </a>
                    </div>
                    <div>
                        <a class="d-flex order" href="{{ route('users.orders') }}">
                            <img src="{{ asset("vendor/buyer/Img/order-black.svg") }}" alt="">
                            <p>@lang('My Order')</p>
                        </a>
                    </div>
                    <div>
                        <div class="d-flex order">
                            <a class="d-flex" href="{{ route('wishlist') }}">
                                <img src="{{ asset("vendor/buyer/Img/hert-black.svg") }}" alt="">
                                <p>@lang('Wishlist')</p>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex order">
                            <a class="d-flex" href="{{ route('buyer.messenger.index') }}">
                                <img src="{{ asset("vendor/buyer/Img/mdi_email.svg") }}" alt="">
                                <p>@lang('Messages')</p>
{{--                                <span class="span-badge span-badge-red">0</span>--}}
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex order">
                            <img src="{{ asset("vendor/buyer/Img/bell.svg") }}" alt="">
                            <p>@lang('Notifications')</p>
                        </div>
                    </div>
                </div>
                <div class="footer-sidepannel">
                    <p class="link-product" style="color: #FFFFFF;">@lang('About Us')</p>
                    <p class="link-product" style="color: #FFFFFF;">@lang('Help Center')</p>
                    <div class="logo-footer sp d-flex">
                        <img src="{{ asset("vendor/buyer/Img/logo-light.svg") }}" alt="">
                        <p class="link-product" style="color: #FFFFFF;">PT. Shukshuk Singapore</p>
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
