<header>
    <div class="header-top">
        <div class="container d-flex justify-content-between">
            <div class="left">
                <p>@lang('Download App (Coming Soon)')</p>
            </div>
            <div class="center d-flex justify-content-between" style="text-align: left">
                <a href="{{route('home')}}" style="white-space: nowrap">@lang('Back to Home Page')</a>
                <a href="#" style="margin-left: 48px;white-space: nowrap">@lang('Help Center')</a>
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
            <div class="text-fee d-flex justify-content-between navbar navbar-expand-lg" style="padding: 24px 0px 24px 0;">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand logo d-flex" href="{{ route('home') }}" style="margin-right: 0;">
                        <img class="d-block w-100 h-50" src="{{ asset("vendor/buyer/Img/Logo.png") }}">
                        <span>shukshuk</span>
                    </a>
                    <div style="border-top: 1px solid #97A3A2;
                            width: 32px;
                            margin-top: 16px;
                            margin-bottom: 16px;
                            transform: rotate(90deg);">
                    </div>
                    <p class="color-gray card-title-product">@lang('Checkout')</p>
                </nav>
                <ul class="nav hidden-mobi d-flex justify-content-end ">
                    <li class="item-step nav-item detail-step-w20 detail-step step-active" style="padding: 0">
                        <a class="item-step nav-link d-flex" href="javascript:void(0);">
                            <span class="d-block rounded-circle number">1</span>
                            <span class="text" style="padding-right: 18px">@lang('Delivery Information')</span>
                        </a>
                    </li>
                    <li class="item-step nav-item detail-step detail-step-w20 @if(Illuminate\Support\Facades\Route::is('checkout-cart.payment') || Illuminate\Support\Facades\Route::is('checkout.success')) step-active @else @endif" style="padding: 0">
                        <a class="nav-link d-flex"  href="javascript:void(0);">
                            <span class="d-block rounded-circle number">2</span>
                            <span class="text" style="padding-right: 18px">@lang('Payment')</span>
                        </a>
                    </li>
                    <li class="item-step nav-item detail-step detail-step-w20 @if(Illuminate\Support\Facades\Route::is('checkout.success')) step-active @else @endif"  style="padding: 0">
                        <a class="nav-link d-flex" href="javascript:void(0);">
                            <span class="d-block rounded-circle number">3</span>
                            <span class="text" style="padding-right: 0px">@lang('Complete Order')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>