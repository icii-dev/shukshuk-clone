<header>
    <div class="header-top">
        <div class="container d-flex justify-content-between">
            <div class="left">
                <p>@lang('Download App (Coming Soon)')</p>
            </div>
            <div class="d-flex justify-content-between">
                <a href="https://drive.google.com/file/d/1UuEb1LULZ0lsnJ4FPsHtdG-Y_twTzHqv/view?usp=sharing"
                target="_blank">
                    @lang('How to be a seller?')
                </a>
                <a href="#" class="ml-32px">@lang('Help Center')</a>
                <div class="ml-32px">
                    <div class="dropdown show">
                        <div class="dropdown-toggle" href="#" role="button" id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(\Session::get('lang', config('app.locale')) == 'kr')
                                <img src="{{asset('/img/flats/korea.svg')}}" height="12">
                                <label class="ml-8px shukshuk-white">한글</label>
                                <img src="{{asset('vendor/buyer/Img/arrow-down-white.svg')}}" class="ml-8px icon">
                            @elseif(\Session::get('lang', config('app.locale')) == 'id')
                                <img src="{{asset('/img/flats/id.svg')}}" height="12">
                                <label class="ml-8px shukshuk-white">Bahasa</label>
                                <img src="{{asset('vendor/buyer/Img/arrow-down-white.svg')}}" class="ml-8px icon">
                            @else
                                <img src="{{asset('/img/flats/english.svg')}}" height="16">
                                <label class="ml-8px shukshuk-white">English</label>
                                <img src="{{asset('vendor/buyer/Img/arrow-down-white.svg')}}" class="ml-8px icon">
                            @endif
                        </div>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLanguage">
                            <a class="dropdown-item" href="{{route('lang', 'en')}}">
                                <img src="{{asset('/img/flats/english.svg')}}" height="16">
                                <label class="ml-8px shukshuk-dark-gray">English</label>
                                @if(\Session::get('lang', config('app.locale')) == 'en')
                                <img class="ml-8px" src="{{asset('./img/shared/check.svg')}}">
                                @endif
                            </a>
                            <a class="dropdown-item shukshuk-dark-gray" href="{{route('lang', 'id')}}">
                                <img src="{{asset('/img/flats/id.svg')}}" height="16">
                                <label class="ml-8px shukshuk-dark-gray">Bahasa</label>
                                @if(\Session::get('lang', config('app.locale')) == 'id')
                                    <img class="ml-8px" src="{{asset('./img/shared/check.svg')}}">
                                @endif
                            </a>
                            <a class="dropdown-item shukshuk-dark-gray" href="{{route('lang', 'kr')}}">
                                <img src="{{asset('/img/flats/korea.svg')}}" height="16">
                                <label class="ml-8px shukshuk-dark-gray">한글</label>
                                @if(\Session::get('lang', config('app.locale')) == 'kr')
                                        <img class="ml-8px" src="{{asset('./img/shared/check.svg')}}">
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand logo d-flex" href="{{ route('home') }}">
                    <img class="d-block w-100 h-50" src="{{ asset("vendor/buyer/Img/Logo.png") }}">
                    <span>shukshuk</span>
                </a>
                <form action="{{ route('search') }}" method="GET" class="form-inline my-2 my-lg-0">
                    @csrf
                    <input id="project" name="keyword" class="form-control mr-sm-2 input-menu" type="search" placeholder="{{__('search_bar_title')}}" aria-label="Search">
                    <button class="btn search my-2 my-sm-0 " type="submit"><i class="fas fa-search"></i></button>
                </form>

                @include('buyer.partials.mobile-cart-navbar')
                @include('buyer.partials.mobile-menu-navbar')

                <div class="tablet-hidden web-flex" style="width: 100%">
                    <ul class="navbar-nav ml-auto menu-main">
                        <li class="nav-item d-flex heart web align-items-center" style="margin-left: 50px;">
                            <a class="d-flex align-items-center" href="{{ route('wishlist') }}">
                                <img src="{{ asset("vendor/buyer/Img/wishlist-checked.svg") }}">
                                <span id="wishlist">@if(auth()->user()) {{auth()->user()->countWishlist()}} @endif</span>
                            </a>
                        </li>
                        <div class="wrap-dropdown">
                            <li class="nav-item dropdown wrap-cart-web cart d-flex align-items-center" style="height: 80px">
                                @include('buyer.partials.cart')
                            </li>

                        </div>
                        @if(!Auth::user())
                            <div class="wrap-login d-flex align-items-center">
                                <li class="nav-item log-in">
                                    <a style="padding-left: 4px" href="#"
                                       data-toggle="modal"
                                       data-target="#modalRegister"
                                       dusk="nav-register"
                                    >{{__('Register')}}</a>
                                </li>
                                <li class="nav-item log-in">
                                    <a id="navLogin" href="#" data-toggle="modal" data-target="#modalLogin">{{__('Login')}}</a>
                                </li>
                            </div>
                        @else
                            <li class="nav-item dropdown dropdown-profile customer d-flex align-items-center" style="margin-left: 0px; width: 100%">
                                <a class="nav-link dropdown-toggle d-flex justify-content-end" href="#" id="dropdownUserNav" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="content-dropdown d-flex" style="margin-right: 14px">
                                        <span class="truncate-overflow-one">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</span>
                                    </div>
                                    <img class="icon" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}">
                                </a>
                                <div class="dropdown-menu cart-dropdown logged-profile-dropdown-menu" aria-labelledby="dropdownUserNav">
                                    @if (auth()->user()->store && auth()->user()->store->status != \App\Model\Store::STATUS_DRAFT)
                                        <a class="dropdown-item register" href="{{ route('seller.home') }}">@lang('Go to seller dashboard')</a>
                                    @else
                                        <a class="dropdown-item register" href="{{ route('seller.register') }}">@lang('Register as Seller')</a>
                                    @endif

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{route('users.edit')}}">@lang('Account')</a>
                                    <a class="ropdown-item d-flex justify-content-between" href="{{ route('users.orders') }}">
                                        <span>@lang('My Order')</span>
                                        <span class="rounded-circle d-block text-center circle" id="unread-count">{{$totalOrders}}</span></a>
                                    <a class="dropdown-item d-flex justify-content-between" href="{{route('buyer.messenger.index')}}">
                                        <span>@lang('Messages')</span>
                                        <span class="rounded-circle d-block text-center circle" id="message-unread-count">0</span>
                                    </a><!-- dấu tròn -->
                                    <a class="dropdown-item d-flex justify-content-between disable-content" href="#">
                                        <span>@lang('Notifications')</span>
                                        <span class="rounded-circle d-block text-center circle">0</span>
                                    </a><!-- dấu tròn -->
                                    <div class="dropdown-divider"></div>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <a class="dropdown-item d-flex justify-content-between log-out" href="{{ route('logout') }}"
                                       dusk="btn-logout"
                                       onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <span>@lang('Log Out')</span>
                                        <img src="{{ asset("vendor/buyer/Img/ic_logout.svg") }}" alt="">
                                    </a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>








