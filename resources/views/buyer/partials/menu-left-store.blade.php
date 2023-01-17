<ul class="nav tab-user tab">
    <li>
        <button class="tablinks active" onclick="openMenu(event, 'Overview') " data-toggle="tab" >
            <div class="account">
                <div class="d-flex">
{{--                    <img src="{{asset("asset-seller/Img/overview.svg")}}" alt="" class="store-menu-icon">--}}
                    <svg class="store-menu-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 6H21" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 10C16 11.0609 15.5786 12.0783 14.8284 12.8284C14.0783 13.5786 13.0609 14 12 14C10.9391 14 9.92172 13.5786 9.17157 12.8284C8.42143 12.0783 8 11.0609 8 10" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p class="card-title" style="margin: 0">@lang('Store Profile')</p>
                </div>
            </div>
        </button>
    </li>
    <li id="li-my-oder">
        <a class="accordion">
            <div style="margin-bottom: 16px">
                <div class="d-flex" style="margin-left: 15px;">
                    <img id="icon-order" src="{{ asset("asset-seller/Img/ic_product.svg") }}" alt="" class="store-menu-icon">
                    <p class="card-title" style="margin: 0">@lang('Products')</p>
                    <img class="icon" src="{{ asset("asset-seller/Img/chevron-down.svg") }}" style="margin-left: 54px";>
                </div>
            </div>
        </a>
        <div class="panel">
            <ul class="nav tab-user ">
                <li>
                    <button class="tablinks" onclick="openMenu(event, 'Products')">
                        <div class="account">
                            <div class="d-flex" style="margin-left: 19px;">
                                <p  class="store-side-menu link-product">@lang('All Products')</p>
                            </div>
                        </div>
                    </button>
                </li>
                @foreach($cate as $cat)
                    <li>
                        <button class="tablinks" onclick="openMenu(event, '{{$cat->name}}')">
                            <div class="account">
                                <div class="d-flex" style="margin-left: 19px;">
                                    <p class="store-side-menu link-product">{{$cat->name}}</p>
                                </div>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </li>
    <li >
        {{--        <button class="tablinks" onclick="openMenu(event, 'Promo')">--}}
        <button>
            <div class="account">
                <div class="d-flex">
                    <img src="{{ asset("asset-seller/Img/promo.svg") }}" alt="" class="store-menu-icon">
                    <p style="color: #ACB4B4; opacity: 0.7; margin: 0;" class="card-title">@lang('Promo')</p>
                </div>
            </div>
        </button>
    </li>
</ul>
<style>
    .store-menu-icon {
        fill: none;
    }

    .tab button.active svg.store-menu-icon>path{
        stroke: #413EC1;
    }
</style>
