<header class="header-seller-registration header-seller">
    <div class="header-top">
        <div class="container d-flex justify-content-between">
            <div class="left">
                <p>Download App (Coming Soon)</p>
            </div>
            <div class="right d-flex justify-content-between">
                <a href="{{route('home')}}">Back To Home Page</a>
                <a href="#">Help Center</a>
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand logo d-flex" href="{{ route('home') }}">
                    <img class="d-block w-100 h-50" src="{{ asset('asset-seller/Img/Logo.png') }}">
                    <span>shukshuk<font class="color-span">Seller</font></span>
                </a>
                <div style="border-left: 1px solid #97A3A2;
                            height: 32px;
                            margin-left: 16px;
                            margin-right: 16px
                ">
                </div>
                <p style="color: #97A3A2;">Registration</p>
                @include('seller.register._step_nav')
            </nav>
        </div>
    </div>
</header>