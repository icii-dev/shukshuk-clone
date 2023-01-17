<footer class="@yield('footer-custom')">
    <div class="container wrap-footer">
        <div class="row">
            <div class="col-xl-3 col-md-12 col-f-sm-12 footer-about" style="padding-bottom: 12px;">
                <div class="logo-footer">
                    <img src="{{ asset("vendor/buyer/Img/logo-footer.svg") }}" alt="">
                    <span>Shukshuk</span>
                </div>
                <p class="description-text"><p class="description-text" style="white-space: nowrap;">
                    @lang('ShukShuk is an online marketplace')<p> @lang('that aims to support transactions between buyers and sellers in Continental Asia.')</p>
            </div>
            <div class="col-xl-8 col-md-12 col-f-sm-12 footer-right">
                <div class="menu-footer">
                    <div class="row">
                        @foreach($menuFooters as $menu)
                            @if($menu->parent_id == null)
                            <div class="col-3 col-f-sm-12 mobi-padding-footer">
                                <h3 class="title-menu">{{$menu->title}}</h3>
                                <ul>
                                    @foreach($menuFooters as $menuChildren)
                                        @if($menuChildren->parent_id == $menu->id)
                                        <li><a class="description-text" href="{{route('footer.about', $menuChildren->url)}}" style="white-space: nowrap">{{$menuChildren->title}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                                @endif
                            @endforeach()
                            <div class="col-3 col-f-sm-12 web-block">
                                <h3 class="title-menu ">@lang('Coming Soon')</h3>
                                <ul class="d-flex">
                                    <li>
                                        <a href="#">
                                            <img src="{{ asset("vendor/buyer/Img/appstore.png") }}" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="google-play" src="{{ asset("vendor/buyer/Img/googleplay.png") }}" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="copy-right">Shukshuk © 2020</p>
</footer>
