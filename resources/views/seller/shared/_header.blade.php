<header class="header-seller">
    <div class="header-top">
        <div class="container d-flex justify-content-between">
            <div class="left">
                @if($store->status == \App\Model\Store::STATUS_WAITING_APPROVAL)
                    <p style="color: yellow">@lang('Your store is waiting for approval!')</p>
                @elseif($store->status == \App\Model\Store::STATUS_DEACTIVE)
                    <p style="color: darkred">@lang('Your store is disapproved')</p>
                @elseif($store->status == \App\Model\Store::STATUS_DRAFT)
                    <p style="color: darkred">@lang('Your store has not successfully registered')</p>
                @else
                    <p>@lang('Download App (Coming Soon)')</p>
                @endif
            </div>
            <div class="right d-flex justify-content-between">
                <a href="{{route('home')}}">Go To shukshuk.com -></a>
                <a href="#">Help Center</a>
                <div>
                    <div class="dropdown show">
                        <div class="dropdown-toggle" href="#" role="button" id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(\Session::get('lang', config('app.locale')) == 'kr')
                                <img src="{{asset('/img/flats/korea.svg')}}" height="12">
                                <label class="ml-8px shukshuk-white">한글</label>
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
                                <label class="ml-8px shukshuk-dark-gray">한글</label>
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
            <nav class="row navbar navbar-expand-lg">
                <a class="navbar-brand logo d-flex" href="{{ route('seller.home') }}">
                    <img class="d-block w-100 h-50" src="{{ asset('asset-seller/Img/Logo.png') }}">
                    <span>shukshuk<font class="color-span ml-1">Seller</font></span>
                </a>
                <form  id="form-search-product" class="form-inline my-2 my-lg-0 mr-auto">
                    @csrf
                    <input type="hidden" name="idStore" value="{{$store->id}}">
                    <input id="searchInput" name="keyword" class="form-control mr-sm-2 input-menu" type="search" placeholder="Search in this store" aria-label="Search" style="max-width: 352px">
                    <button class="btn search my-2 my-sm-0 "><i class="fas fa-search"></i></button>
                </form>
                @include('seller.partials.mobile-menu-navbar')
                <ul class="navbar-nav menu-main tablet-show-b mobi-block">
                    <li class="nav-item mobi">
                        <a onclick="openCart()" class="nav-link dropdown-toggle d-flex w-100 justify-content-between" href="#" id="dropdownMainCart" role="button" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('asset-seller/Img/Vector.svg') }}" alt="">
                        </a>
                    </li>
                </ul>
                {{--                <button class="navbar-toggler openbtn" onclick="openNav()" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >--}}
                {{--                    <img src="{{ asset('asset-seller/Img/mdi_menu.svg') }}" alt="">--}}
                {{--                </button>--}}
                <div class="tablet-hidden web-flex">
                    <ul class="col-12 navbar-nav menu-main">
                        <li class="col-8" style="background: #e9f6f4;">
                            <div class="row">
                                <div class="col-8">
                                    <a href="#">Balance</a>
                                    <h3 class="product-card-title" id="storeBalance">
                                        {{moneyFormat(getStoreBalance($store))}}
                                    </h3>
                                </div>
                                <div class="col-4">
                                    <a href="#" data-toggle="modal" data-target="#withdrawModal">Withdraw</a>
{{--                                    <img class="icon" src="{{ asset('asset-seller/Img/arrow-black.svg') }}">--}}
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown dropdown-profile customer d-flex align-items-center" style="margin-left: 0px">
                            <a class="nav-link dropdown-toggle d-flex justify-content-between" href="#" id="dropdownMainCart" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="content-dropdown d-flex" style="margin-right: 14px">
                                    <span class="color-span truncate-overflow-one">{{ Auth::user()->store['name'] }}</span>
                                </div>
                                <img class="icon" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}">
                            </a>
                            <div class="dropdown-menu cart-dropdown" aria-labelledby="dropdownMainCart">
                                <a class="dropdown-item register color-custom" href="{{route('seller.store.edit')}}">@lang('Manage Store')</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item d-flex justify-content-between" href="{{ route('seller.order.index') }}">
                                    <span>@lang('My Order')</span>
                                    <span class="rounded-circle d-block text-center circle">{{ $totalOrder }}</span>
                                </a>
                                <a class="dropdown-item d-flex justify-content-between" href="{{ route('seller.messenger.index') }}">
                                    <span>@lang('Messages')</span>
                                    <span class="rounded-circle d-block text-center circle" id="message-unread-count">{{ $totalMessage }}</span>
                                </a>
                                <a class="dropdown-item d-flex justify-content-between" href="{{ route('seller.notification.index') }}">
                                    <span>@lang('Notifications')</span>
                                    <span class="rounded-circle d-block text-center circle bg-gray">{{ $totalNotification }}</span>
                                </a><!-- dấu tròn -->
                                <div class="dropdown-divider"></div>
                                <a id="log-out-1" class="dropdown-item d-flex justify-content-between log-out" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <span>@lang('Log Out')</span>
                                    <img src="{{ asset('asset-seller/Img/ic_logout.svg') }}" alt="">
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

