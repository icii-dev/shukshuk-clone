@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

@endsection

@section('page-id', 'gray')
@section('content')
    <div class="content">
        <div class="container full-sm">
            <div class="row">
                <div class="col-3 col-collap web-block">
                    @include('buyer.partials.menu-left-user')
                </div>
                <div class="col-md-9 col-sm-12 col-collap">
                    <div id="tab-mobi" class="tab-content d-sm-none">
                        <div id="my-oder" class="container web-block tab-pane active show">
                            <div class="col-12  personal-information my-oder">
                                <div class="title-oder">
                                    <h2>@lang('My Order')</h2>
                                </div>
                                <ul class="nav tab-mobi tab-web">
                                    <li class="nav-item">
                                        <a class="active color-gray" data-toggle="tab" href="#tab-1">
                                            <span>@lang('To Pay')</span>
                                            <span class="tab-circle text-center">{{count($orderStatistics['NEW'])}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="color-gray" data-toggle="tab" href="#tab-2">
                                            <span>@lang('In Process')</span>
                                            <span class="tab-circle text-center">{{count($orderStatistics['INPROCESS'])}}</span>
                                        </a>
                                    </li>
{{--                                    <li class="nav-item">--}}
{{--                                        <a class="color-gray" data-toggle="tab" href="#tab-3">--}}
{{--                                            <span>@lang('Finished Packing')</span>--}}
{{--                                            <span class="tab-circle text-center">{{count()}}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
                                    <li class="nav-item">
                                        <a class="color-gray" data-toggle="tab" href="#tab-4">
                                            <span>@lang('In Shipping')</span>
                                            <span class="tab-circle text-center">{{count($orderStatistics['SHIPPING'])}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="color-gray" data-toggle="tab" href="#tab-5">
                                            <span>@lang('Completed')</span>
                                            <span class="tab-circle text-center">{{count($orderStatistics['COMPLETED'])}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="color-gray" data-toggle="tab" href="#tab-6">
                                            <span>@lang('Cancelled')</span>
                                            <span class="tab-circle text-center">{{count($orderStatistics['CANCELLED'])}}</span>
                                        </a>
                                    </li>
                                </ul>
                                <hr class="mb-23px">
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active show" role="tabpanel">
                                        @if(count($orderStatistics['NEW']))
                                            @foreach($orderStatistics['NEW'] as $order)
                                                @if(($order->status==\App\Model\Order::STATUS_NEW)&& $order->products()->first())
                                                    @include('buyer.order._list-order')
                                                @endif
                                            @endforeach
                                        @else
                                            <p>{{trans('messages.no_data_available')}}</p>
                                        @endif
                                    </div>
                                    <div id="tab-2" class="tab-pane" role="tabpanel">
                                        @if(count($orderStatistics['INPROCESS']))
                                            @foreach($orderStatistics['INPROCESS'] as $order)
                                                @if($order->products()->first())
                                                    @include('buyer.order._list-order')
                                                @endif
                                            @endforeach
                                        @else
                                            <p>{{trans('messages.no_data_available')}}</p>
                                        @endif
                                    </div>
{{--                                    <div id="tab-3" class="tab-pane" role="tabpanel">--}}

{{--                                        @if(count($orderStatistics['SCHEDULE_PICKUP']))--}}
{{--                                            @foreach($orderStatistics['SCHEDULE_PICKUP'] as $order)--}}
{{--                                                @if($order->status==\App\Model\Order::STATUS_SCHEDULE_PICK_UP && $order->products()->first())--}}
{{--                                                    @include('buyer.order._list-order')--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        @else--}}
{{--                                            <p>{{trans('messages.no_data_available')}}</p>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
                                    <div id="tab-4" class="tab-pane" role="tabpanel">
                                        @if(count($orderStatistics['SHIPPING']))
                                            @foreach($orderStatistics['SHIPPING'] as $order)
                                                @if($order->status==\App\Model\Order::STATUS_SHIPPING && $order->products()->first())
                                                    @include('buyer.order._list-order')
                                                @endif
                                            @endforeach
                                        @else
                                            <p>{{trans('messages.no_data_available')}}</p>
                                        @endif
                                    </div>
                                    <div id="tab-5" class="tab-pane" role="tabpanel">
                                        @if(count($orderStatistics['COMPLETED']))
                                            @foreach($orderStatistics['COMPLETED'] as $order)
                                                @if($order->status==\App\Model\Order::STATUS_COMPLETED && $order->products()->first())
                                                    @include('buyer.order._list-order')
                                                @endif
                                            @endforeach
                                        @else
                                            <p>{{trans('messages.no_data_available')}}</p>
                                        @endif
                                    </div>
                                    <div id="tab-6" class="tab-pane" role="tabpanel">
                                        @if(count($orderStatistics['CANCELLED']))
                                            @foreach($orderStatistics['CANCELLED'] as $order)
                                                @if($order->status==\App\Model\Order::STATUS_CANCELLED && $order->products()->first())
                                                    @include('buyer.order._list-order')
                                                @endif
                                            @endforeach
                                        @else
                                            <p>{{trans('messages.no_data_available')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
@endsection
