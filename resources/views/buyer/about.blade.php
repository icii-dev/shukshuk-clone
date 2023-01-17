@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-header')
@endsection

@section('page-id', 'about')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 content-about">
                <div class="content-about-header">
                    <h1>{{$page->title}}</h1>
                </div>
                <div class="content-about-body">
{{--                    @if($category->url == 'about-us')--}}
{{--                    <div>--}}
{{--                        <p>Shukshuk is an online marketplace that aims to support transactions between buyers and sellers in Continental Asia.--}}
{{--                        </p>--}}
{{--                        <br>--}}
{{--                        <!-- Nav tabs -->--}}
{{--                        <ul class="nav nav-tabs" role="tablist">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link active" data-toggle="tab" href="#home">Background</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" data-toggle="tab" href="#menu1">How it works</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" data-toggle="tab" href="#menu2">Team members</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}

{{--                        <!-- Tab panes -->--}}
{{--                        <div class="tab-content">--}}
{{--                            <div id="home" class="container tab-pane active">--}}
{{--                                <br>--}}
{{--                                <div>--}}
{{--                                    Matt was an avid traveller. In his travels across the Asian continent, he came across many wonderful people who made amazing products (e.g. cashmere in Mongolia, olive wood in Egypt etc.), and yet were struggling financially. There were also many honest, hardworking people who just lacked opportunities and hope, After many coffees (and teas) with this diverse group of people (many of whom became friends), he started dreaming of building an online marketplace that can support these businesses and people across Asia. In 2020, fate brought him together with a team of like-minded young people across Asia, all with the unique skills needed to make the online marketplace a reality. That led to the birth of Shukshuk. Shukshuk (pronounced as shook-shook) means “Market Market” in Arabic.--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div id="menu1" class="container tab-pane fade"><br>--}}
{{--                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>--}}
{{--                            </div>--}}
{{--                            <div id="menu2" class="container tab-pane fade"><br>--}}
{{--                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @else--}}
{{--                        {!! $page->body !!}--}}
{{--                    @endif--}}
                    {!! $page->body !!}
                </div>
            </div>
            <div class="col-3 menu-about web-block">
                @include('buyer.partials.nav.about_nav')
            </div>
        </div>
    </div>

@endsection
@section('footer-custom','about-footer')
@section('extra-footer')
    <script>

        $(function () {
            // Active menu right
            var url = window.location.pathname,
                urlRegExp = new RegExp(url.replace(/\/$/,'') + "$");
            $('.collapse a').each(function(){
                // and test its normalized href against the url pathname regexp
                if(urlRegExp.test(this.href.replace(/\/$/,''))){
                    console.log(url + '----' + urlRegExp);

                    $(this).parent().addClass('active');
                    $(this).parent().parent().addClass('show');
                }
            });
        })
    </script>
@endsection