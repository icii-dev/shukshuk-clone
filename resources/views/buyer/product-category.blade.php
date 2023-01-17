@extends('layouts.buyer')

@section('title', 'Product Category')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

    <div class="content">
        <div class="header-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <nav class="web-block" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
                            </ol>
                        </nav>
                        <div class="wrap-title d-flex justify-content-between">
                            <h1>{{$category->name}}</h1>
                            <img class="mobi-block" src="{{ asset("vendor/buyer/Img/info.svg") }}" alt="">
                        </div>
                        <p class="web-block">
                            {!! $category->description !!}
                        </p>
                    </div>

                    <div class="col-md-6 col-sm-12 web-block">
                        <img class="" src="{{ asset('vendor/buyer/Img/silk.jpg') }}">
                    </div>

                </div>
            </div>
        </div>
        <div class="filter web-block">
            <div class="container">

                    @include('buyer.partials.form-filter', ['filterAction' => url('product/category/')])
            </div>
        </div>
        <div class="store-product">
            <div class="container">
                <div class="row" id="featureProductsRow">
                    @foreach($products as $product)
                        @include('buyer.partials.product.item-product-list')
                    @endforeach
                </div>
                @if($products->nextPageUrl())
                <a href="" class="button load-more web-block">Load More</a>
                @endif
            </div>
            <div class="mobi-block wrap-btn-filter">
                <a class="btn-customer Filter btn" href="#" role="button">
                    <img src="{{ asset("vendor/buyer/Img/mdi_filter_list.svg") }}">
                    <p>Filter</p>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('extra-footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script type="text/javascript">
        var page = 2;
        $('.load-more').click(function(e){
            e.preventDefault();
            loadMoreProducts();
        });
        function loadMoreProducts() {
            $.ajax(
                {
                    url: window.location.href+'?page=' + page,
                    type: "get",
                    datatype: "html"
                }).done(function(data){
                page++;
                loadViewProduct(data);
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                alert('No response from server');
            });
        }
        // load product in id featureProductsRow
        function loadViewProduct(data) {
            if(data.links.next == null){
                $('.load-more').hide();
            }
            htmlCode="";
            $.each( data.data, function( key, value ) {
                htmlCode += printItemProduct(value);
            });

            $('#featureProductsRow').append(htmlCode);
        }
    </script>

@endsection