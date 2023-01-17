<div class="wrap-review">
    <div class="star web-block">
        <div class="star-peview d-flex" data-toggle="modal" data-target="#received-star">
            @if($product->rating_cache)
                <div class="star d-flex">
                    <?php
                    showStars($product->rating_cache);
                    ?>
                </div>
                <p class="rate">{{$product->rating_cache}}</p>
                <p class="color-primary">({{$product->rating_count}} Reviews)</p>
            @endif
        </div>
    </div>
    <div class="progressbar mb-3 web-block">
        <div class="mb-1 item-progress d-flex justify-content-between col-lg-5 align-items-center col-md-8 col-select">
            <div>
                <span>5</span>
                <img class="progress-star" src="{{ asset("vendor/buyer/Img/start.svg") }}" alt="">
            </div>
            <div class="wrap-bar">
                <div class="bar" style="width: {{$percentageOfRatings['five']}}%;"></div>
            </div>
            <span>{{$percentageOfRatings['five']}}%</span>
        </div>
        <div class="mb-1 item-progress d-flex justify-content-between col-lg-5 align-items-center col-md-8 col-select">
            <div>
                <span>4</span>
                <img class="progress-star" src="{{ asset("vendor/buyer/Img/start.svg") }}" alt="">
            </div>
            <div class="wrap-bar">
                <div class="bar" style="width: {{$percentageOfRatings['four']}}%;"></div>
            </div>
            <span>{{$percentageOfRatings['four']}}%</span>
        </div>
        <div class="mb-1 item-progress d-flex justify-content-between col-lg-5 align-items-center col-select col-md-8">
            <div>
                <span>3</span>
                <img class="progress-star" src="{{ asset("vendor/buyer/Img/start.svg") }}" alt="">
            </div>
            <div class="wrap-bar">
                <div class="bar" style="width: {{$percentageOfRatings['three']}}%;"></div>
            </div>
            <span>{{$percentageOfRatings['three']}}%</span>
        </div>
        <div class="mb-1 item-progress d-flex justify-content-between col-lg-5 align-items-center col-select col-md-8">
            <div>
                <span>2</span>
                <img class="progress-star" src="{{ asset("vendor/buyer/Img/start.svg") }}" alt="">
            </div>
            <div class="wrap-bar">
                <div class="bar" style="width: {{$percentageOfRatings['two']}}%;"></div>
            </div>
            <span>{{$percentageOfRatings['two']}}%</span>
        </div>
        <div class="mb-1 item-progress d-flex justify-content-between col-lg-5 align-items-center col-select col-md-8">
            <div>
                <span>1</span>
                <img class="progress-star" src="{{ asset("vendor/buyer/Img/start.svg") }}" alt="">
            </div>
            <div class="wrap-bar">
                <div class="bar" style="width: {{$percentageOfRatings['one']}}%;"></div>
            </div>
            <span>{{$percentageOfRatings['one']}}%</span>
        </div>
    </div>
    <div class="wrap-Latest-Reviews d-flex justify-content-between">
        <h2 class="web-block">@lang('Latest Reviews')</h2>
        {{--                                        <div class="wrap-select col-lg-3 col-md-5 col-sm-12 col-select mb-sm-2">--}}
        {{--                                            <select class="selectpicker" title="All Reviews">--}}
        {{--                                                <option>Credit Cards</option>--}}
        {{--                                                <option>Ketchup</option>--}}
        {{--                                                <option>Relish</option>--}}
        {{--                                            </select>--}}
        {{--                                            <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">--}}
        {{--                                        </div>--}}
    </div>
    <ul id="reviewsList" class="detail-review">
    </ul>
</div>
