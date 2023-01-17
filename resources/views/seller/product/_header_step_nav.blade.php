<div class="content content-home-seller">
    <div class="header-sellersHome  bg-cover-seller-2">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-between">
                <div>
                    <a id="back" href="{{ route('seller.home') }}"style="font-size:14px ; color: #30B6A4;"><- Back</a>
                    <span style="margin-left: 30px;font-weight: 500;">@lang('Add Product')</span>
                </div>
                <div>
                    <ul class="nav d-flex justify-content-end">
                        <li id="li-step-1" class="detail-step d-flex step-active-color">
                            <a id="item-step-1"
                               class="item-step nav-link d-flex
                                    {{ (request()->routeIs('seller.product.create')) ? 'active' : '' }}
                                    {{ (request()->routeIs('seller.product.edit')) ? 'active' : '' }}"
                            >
                                <span class="d-block rounded-circle number">1</span>
                                <span class="text">@lang('Product Information')</span>
                            </a>
                        </li>
                        <li id="li-step-2" class="detail-step d-flex">
                            <a id="item-step-2"
                               class="nav-link d-flex
                                    {{ (request()->routeIs('seller.product.create_product_variants')) ? 'active' : '' }}
                                        "
                            >
                                <span class="d-block rounded-circle number">2</span>
                                <span class="text">@lang('Add Product')</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>
<br>