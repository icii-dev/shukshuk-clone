@extends('layouts.seller')

@section('content')
    <div class="container">
        <div class="body-home-seller">
            <div class="row title-home d-flex justify-content-between">
                <h2 class="product-card-subtitle color-black align-self-center">@lang('Products')</h2>
                <div class="col-md-3 col-xl-2 col-sm-8">
                    <a class="btn-customer secondary btn"
                       href="{{ route('seller.product.create') }}" role="button"
                       dusk="add-product"
                    >
                        @lang('Add New Product')
                    </a></div>
            </div>

            <div class="sroll-bar">
                <div class="table table-home-seller">
                    <div class="head">
                        <div class="row detail-home">
                            <div class="col-1 text-center">No.</div>
                            <div class="col-3">@lang('Product Title')</div>
                            <div class="col-4">@lang('Description')</div>
                            <div class="col text-center">@lang('Price')</div>
                            <div class="col text-center">@lang('Stock')</div>
                            <div class="col text-center">@lang('Actions')</div>
                        </div>
                    </div>
                    <hr>
                    @include('seller.partials.item-product-list-in-store')
                </div>
            </div>

            @if ($pagedProduct->lastPage() > 1)
                <div class="row justify-content-md-end justify-content-sm-start">
                    <div class="col-md-7 col-sm-12 d-flex justify-content-between align-items-center">
                        <p class="color web-block">Page {{ $pagedProduct->currentPage() }}
                            of {{ $pagedProduct->lastPage() }}</p>
                        {{ $pagedProduct->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection