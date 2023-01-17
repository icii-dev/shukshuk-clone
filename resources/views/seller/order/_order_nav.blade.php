<div class="wrap-croll">
    <ul class="nav tab-orders">
        <li class="nav-item d-flex justify-content-center li-tab">
            <a class="product-card-title color-gray @if(\Request::routeIs('seller.order.index')) active @endif" href="{{ route('seller.order.index') }}">@lang('New Orders')</a>
            <span id="order-status-number-{{ \App\Model\Order::STATUS_NEW }}" class="badge badge-pill badge-cycle">{{ $totalOrderNew + $totalOrderInprocess}}</span>
        </li>
        <li class="nav-item d-flex justify-content-center li-tab">
            <a class="product-card-title color-gray {{\Request::routeIs('seller.order.schedule_pickup') ? 'active' : '' }}" href="{{ route('seller.order.schedule_pickup') }}">@lang('Schedule Pick-Up')</a>
            <span id="order-status-number-{{ \App\Model\Order::STATUS_SCHEDULE_PICK_UP }}" class="badge badge-pill badge-cycle">{{ $totalOrderSchedulePickup }}</span>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a class="product-card-title color-gray {{\Request::routeIs('seller.order.list_shipping') ? 'active' : '' }}" href="{{ route('seller.order.list_shipping') }}">@lang('In Shipping')</a>
            <span id="order-status-number-{{ \App\Model\Order::STATUS_SHIPPING }}" class="badge badge-pill badge-cycle">{{ $totalOrderShipping }}</span>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a class="product-card-title color-gray {{\Request::routeIs('seller.order.list_completed') ? 'active' : '' }}" href="{{ route('seller.order.list_completed') }}">@lang('Completed')</a>
            <span id="order-status-number-{{ \App\Model\Order::STATUS_COMPLETED }}" class="badge badge-pill badge-cycle">{{ $totalOrderCompleted }}</span>
        </li>
        <li class="nav-item d-flex justify-content-center">
            <a class="product-card-title color-gray {{\Request::routeIs('seller.order.list_cancelled') ? 'active' : '' }}" href="{{ route('seller.order.list_cancelled') }}">@lang('Cancelled')</a>
            <span id="order-status-number-{{ \App\Model\Order::STATUS_CANCELLED }}" class="badge badge-pill badge-cycle">{{ $totalOrderCancelled }}</span>
        </li>
    </ul>
</div>