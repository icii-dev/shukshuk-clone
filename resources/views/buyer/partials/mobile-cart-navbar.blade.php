<ul class="navbar-nav menu-main tablet-show-b mobi-block">
    <li class="nav-item mobi icon-cart-mobi">
        <a onclick="openCart()" class="nav-link dropdown-toggle d-flex justify-content-between" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <img src="{{ asset("vendor/buyer/Img/Vector.svg") }}" alt="">
            <span id="countCartMobile">{{count(Cart::instance('shopping')->content())}}</span>
        </a>
    </li>
</ul>

<div id="cart-mobi-header" class="cart-mobi">
    <header class="header-cart-mobi">
        <div class="container">
            <div class="container wrap-mdi">
                <p class="text-center link-product">Cart</p>
                <div onclick="closeCart()"  class="close-cart">
                    <img src="{{ asset("vendor/buyer/Img/mdi_menu.svg") }}" alt="">
                </div>
            </div>
        </div>
    </header>
    <div class="body-cart-mobi">
        <div class="your-cart your-cart__rp">
            <div class="mobile-cart-content" id="mainCartMobile">
                @foreach(Cart::instance('shopping')->content() as $key=>$cartItem)
                    <div class="product d-flex justify-content-between align-items-center">
                        <div class="left d-flex" >
                            <img class="img-your-cart img-cart-mobile" src="{{ asset($cartItem->options->thumbnail) }}"
                                 onerror="this.src='{{asset('img/not-found.jpg')}}'"
                                 alt="" style="width: 88px ;height: 88px;">
                            <div class="detail-product-yourcart d-flex align-content-between flex-wrap" style="padding: 0;">
                                <div class="d-flex justify-content-between product__rp" style="margin-bottom: 5px;">
                                    <a href="{{ route('product.show', $cartItem->options->slug) }}" class=" link-product name-product truncate-overflow-one">{{$cartItem->name}}</a>
                                    @if($cartItem->options->options)
                                        <div style="color: #413EC1; font-size: 14px;padding-top: 5px">
                                            @foreach($cartItem->options->options as $opt)
                                                {{$opt}}
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="truncate-overflow-one show-price" style="margin-top: 5px;">
                                        @if($cartItem->options->discount>0)
                                        <h3 class="old-price">{{moneyFormat($cartItem->options->oldPrice)}}</h3>
                                        @endif
                                        <h3 class="ml-1">{{moneyFormat($cartItem->price)}}</h3>
                                    </div>
                                </div>
                                <div class="d-flex amount-main amount-details amount-cart" style="margin-left: 0!important;">
                                    <div class="button-1 col main-reduction"><img src="{{ asset("vendor/buyer/Img/reduction.svg") }}" alt=""></div>
                                    <input name="rowId" type="hidden" value="{{$key}}">
                                    <input name="qty" type="text" class="input number numbar-main" value="{{$cartItem->qty}}">
                                    <div class="col button-2 main-add"><img src="{{ asset("vendor/buyer/Img/add.svg") }}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
            {{--            end mobile cart content--}}

        </div>
    </div>
    <div class="flex-total align-items-center d-flex footer-mobile-cart">
        <div class="col">
            <small>Total</small>
            <h2 class="truncate-overflow-one card-title-product" id="totalCartMobile">{{moneyFormat(Cart::instance('shopping')->subtotal())}}</h2>
        </div>
        <a class="btn-customer primary btn col-4" role="button" href="{{ route('checkout.index', 'cart') }}">Check Out</a>
    </div>
</div>

