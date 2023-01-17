<div class="col-4">
    <div class="seller">
        <a href="{{route('store.index', $store->slug)}}">
            <div class="row d-flex bd-highlight">
                <img class="seller-home-img"
                     src="{{getStoreAvatarUrl($store->avatar_image)}}"
                     onerror="this.src='{{asset('img/store-avatar/default-avatar.png')}}'">
                <div class="seller-home-info align-self-center">
                    <p class="truncate-overflow-one">{{$store->name}}</p>
                    <span class="shukshuk-gray truncate-overflow-one">{{$store->province->name}}</span>
                </div>
                <img class="ml-auto pr-3 bd-highlight" src="{{asset('vendor/buyer/Img/arrow-right-2.svg')}}">
            </div>
        </a>
    </div>
</div>