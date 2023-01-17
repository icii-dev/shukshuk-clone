<div class="wrap-croll">
    <ul class="nav tab-orders">
        <li class="nav-item d-flex justify-content-center li-tab @if(\Request::routeIs('seller.payment.banks')) active @endif">
            <a class="product-card-title color-gray
            @if(\Request::routeIs('seller.payment.banks')) active @endif"
               href="{{ route('seller.order.index') }}">
                @lang('Withdrawal')
            </a>
        </li>
    </ul>
</div>