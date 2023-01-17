@extends('layouts.seller')

@section('content')
    <div class="container">
        <div class="body-home-seller">
            <div class="row title-home d-flex justify-content-between">
                <h2 class="product-card-subtitle">@lang('Payment')</h2>
            </div>
            @include('seller.payment._payment_nav')
            <div class="tab-content">
                <div id="list-order">
                    <hr class="head">
                </div>
                @include('seller.payment._list_bank')

            </div>
        </div>
    </div>
@endsection

