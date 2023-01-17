<div class="padding-col-product col-md-4 col-sm-6 d-flex">
    <a href="{{route('store.index', $store->slug)}}">
    <div class="card card-product">
        <img src="{{getStoreCoverUrl($store->cover_image)}}"
             class="img-fluid card-img-top"
             onerror="this.src='{{asset('img/default.jpg')}}'">
        <div class="card-body d-flex justify-content-center">
            <p class="truncate-overflow-one" style="margin-top: 36px; padding: 0px 2px">{{$store->name}}</p>
        </div>
        <img class="seller-home-img align-self-center"
             style="position: absolute; margin-top: 52px"
             src="{{getStoreAvatarUrl($store->avatar_image)}}"
             onerror="this.src='{{asset('img/store-avatar/default-avatar.png')}}'"
        >
    </div>
    </a>
</div>