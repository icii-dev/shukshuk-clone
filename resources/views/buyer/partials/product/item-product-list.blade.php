<div class="@if(Illuminate\Support\Facades\Route::is('store.index')) col-product-store @else padding-col-product @endif col-md-4 col-sm-6 d-flex">
    <div class="card card-product">
        <a href="{{ route('product.show', $product->slug) }}">
            <img class="img-fluid card-img-top" src="{{asset($product->image)}}" alt="..."  onerror="this.src='{{asset('img/not-found.jpg')}}'">
        </a>
        @if($product->discount>0)
            <p class="sale-off text-center truncate-overflow-one">SALE</p>
        @endif
        <div class="card-body web-block">
            <h3 class="truncate-overflow-two" style="margin-bottom: 8px;">
                <a class="link-product"  href="{{ route('product.show', $product->slug) }}">{{ $product['name'], 30 }}</a>
            </h3>
            <div class="">
                <p class="card-text truncate-overflow-one card-title @if($product->discount>0) color-red @endif">
                    {!! $product->price_range['present_range'] !!}
                </p>
                @if($product->discount>0)
                    <p class="text-sale-off truncate-overflow-one">{!! $product->price_range['range'] !!}</p>
                @endif
            </div>
            <div style="margin-top: 16px">
                <a class="seller-name truncate-overflow-one" href="{{ route('store.index',$product->store->slug) }}">{{$product->store->name}}</a>
            </div>
        </div>
        <div class="card-body mobi-block">
            @if($product->discount>0)
                <h3 class="truncate-overflow-one"><a class="link-product"  href="{{ route('product.show', $product->slug) }}">{{ $product['name'], 30 }}</a></h3>
            @else
                <h3 class="truncate-overflow-two"><a class="link-product"  href="{{ route('product.show', $product->slug) }}">{{ $product['name'], 30 }}</a></h3>
            @endif
            @if($product->discount>0)
                <p class="text-sale-off truncate-overflow-one">{!! $product->price_range['range'] !!}</p>
            @endif
            @if($product->presentPrice()!= $product->price)
                <p class="card-text truncate-overflow-one link-product"><a href="#" style="color: #EB4242;"> {!! $product->price_range['present_range'] !!}</a></p>
            @else
                <p class="card-text truncate-overflow-one link-product"><a href="#"> {!! $product->price_range['present_range'] !!}</a></p>
            @endif

            <div style="margin-top: 28px">
                <p class="card-text seller-name truncate-overflow-one" style="margin-bottom: 0"><a href="{{ route('store.index',$product->store->slug) }}">{{$product->store->name}}</a></p>
            </div>
        </div>
    </div>
</div>