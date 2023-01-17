<div class="content content-home-seller">
    <div class="header-sellersHome  bg-cover-seller-2">
        <div class="container">
                <a id="back" href="{{ route('seller.home') }}"style="font-size:14px ; color: #30B6A4;"><- Back</a>
            <span style="margin-left: 30px;font-weight: 500;">Edit/Add</span>
        </div>
    </div>
</div>
{{--            <div class="row justify-content-between wrap-my-store">--}}
{{--                    <div class="col-md-4 col-sm-12">--}}
{{--                        <div class="row no-gutters store-header-item">--}}
{{--                            <div class="col-md-2">--}}
{{--                                @if (auth()->user()->store->avatar_image)--}}
{{--                                    <img src="{{ getStoreAvatarUrl(auth()->user()->store->avatar_image) }}" alt="" class="avatar-seller">--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="col-md-7">--}}
{{--                                <h3>{{ auth()->user()->store->name }}</h3>--}}
{{--                                <a href="{{ route('seller.store.edit') }}" class="manage-store">Manage Store -></a>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3">--}}
{{--                                <a href="{{ getStoreUrl(auth()->user()->store) }}">View Store</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-md-4 col-sm-12">--}}
{{--                        <div class="row no-gutters store-header-item">--}}
{{--                            <div class="col-8">--}}
{{--                                <span>Balance</span>--}}
{{--                                <h3 class="store-header-item-value">{{auth()->user()->store->balance?auth()->user()->store->balance->balance:'0'}}</h3>--}}
{{--                            </div>--}}
{{--                            <div class="col-4">--}}
{{--                                <a onclick="getAvailableBank()" href="#" >Withdraw Money</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-md-4 col-sm-12">--}}
{{--                        <div class="row no-gutters store-header-item">--}}
{{--                            <div class="col-8">--}}
{{--                                <span>Sold Items (This Month)</span>--}}
{{--                                <h3 class="store-header-item-value">2</h3>--}}
{{--                            </div>--}}
{{--                            <div class="col-4">--}}
{{--                                <a style="color: #ACB4B4" href="#">View Detail</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                <div class="col-xl-2 col-md-3 col-sm-6 p-0">--}}
{{--                    <a class="btn-customer primary-icon btn" href="{{ getStoreUrl(auth()->user()->store) }}" target="_blank">--}}
{{--                        <img src="{{ asset('asset-seller/Img/store.svg') }}">--}}
{{--                        <p>View Store</p>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}




