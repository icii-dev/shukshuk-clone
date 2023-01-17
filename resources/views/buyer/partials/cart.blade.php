<a class="nav-link dropdown-toggle d-flex w-100 justify-content-between" href="#" id="dropdownMainCart" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    <div class="content-dropdown d-flex">
        <img src="{{ asset("vendor/buyer/Img/Vector.svg") }}" alt="">
        @if(!count($cart->content()))
        <span id="emptyCart" style="color: #97A3A2;">Empty</span>
            <div class="total-product d-none">
                <h3>Total Items: <span id="showTotalItems">{{count($cart->content())}}</span></h3>
                <p id="showCartTotal">{{moneyFormat($cart->subtotal())}}</p>
            </div>
        @else
            <div class="total-product">
                <h3>Total Items: <span id="showTotalItems">{{count($cart->content())}}</span></h3>
                <p id="showCartTotal">{{moneyFormat($cart->subtotal())}}</p>
            </div>
        @endif
    </div>
    <img class="icon" src="{{ asset("vendor/buyer/Img/arrow-bottom.svg") }}">
</a>
<div class="dropdown-menu cart detail-cart @if($cart->content()->count()==0) d-none @endif" aria-labelledby="navbarDropdown">
    <div class="wrap-cart-item inner-right" id="mainCart">
        @foreach($cart->content() as $key=>$cartItem)
            <span class="cart-count-item">{{ $loop->iteration }}</span>
            <div class="cart-item dis">
            <div class="cart-name-product truncate-overflow-one">
                <a href="{{ route('product.show', $cartItem->options->slug) }}"><span class="cart-name link-product">{{$cartItem->name}}</span></a>
            </div>
            <div class="d-flex amount-main">
                <div class  ="col button-1 main-reduction"><img src="{{ asset("vendor/buyer/Img/reduction.svg") }}" alt=""></div>
                <input name="rowId" type="hidden" value="{{$key}}">
                <input name="qty" type ="text" class="input number numbar-main" value="{{$cartItem->qty}}">
                <div class  ="col button-2 main-add"><img src="{{ asset("vendor/buyer/Img/add.svg") }}" alt=""></div>
            </div>
                <div class="row no-gutters">
                    <div class="col-12">
                        @if(is_iterable($cartItem->options->options ))
                        @foreach($cartItem->options->options as $name => $value)
                            {{$name}}: {{$value}},
                        @endforeach
                        @endif
                    </div>
                </div>
            <div class="row no-gutters">
                <div class="col-6">
                    @if($cartItem->options->discount>0)
                        <p class="price old-price">{{moneyFormat($cartItem->options->oldPrice)}}</p>
                    @endif
                    <p class="price">{{moneyFormat($cartItem->price)}}</p>
                </div>
                @if($cartItem->options->discount>0)
                <div class="col-6 d-flex justify-content-end">
                    <div class="sale-off text-center truncate-overflow-one"><span style="font-size: 12px">{{showDiscountValue($cartItem->options->discount)}}</span></div>
                </div>
                @endif
            </div>
        </div>
        @if($loop->iteration != $cart->count())
            <div class ="dropdown-divider"></div>
            @endif
        @endforeach
    </div>
    <hr style="margin: 0px -16px">
    <div class="d-flex justify-content-between align-items-center">
        <span class="card-title-product" style="color: #97A3A2;">Total: </span>
        <h2 class="card-title" id="totalCart" style="color: #222831">{{moneyFormat($cart->subtotal())}}</h2>
    </div>
    <a class="btn btn-primary btn-check w-100" href="{{route('checkout.index', 'cart')}}" role="button" dusk="checkout-bnt">Check Out</a>
</div>
