
<div class="container">
        <ul class="row home-seller d-flex js-seller-main-nav">
            <li class="nav-item">
                <a class="d-flex" href="{{ route('seller.order.index') }}">
                    <div class="d-flex">
                    <svg class="menu-left-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 6H21" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 10C16 11.0609 15.5786 12.0783 14.8284 12.8284C14.0783 13.5786 13.0609 14 12 14C10.9391 14 9.92172 13.5786 9.17157 12.8284C8.42143 12.0783 8 11.0609 8 10" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </div>
                    <p class="p-active">@lang('Orders')</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex" href="{{ route('seller.product.index') }}">
                    <div class="d-flex">
                        <svg class="menu-left-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="ic_product" d="M16.6118 9.45269L7.61182 4.2627" stroke="#97A3A2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21.1118 16.0531V8.05312C21.1115 7.7024 21.0189 7.35793 20.8434 7.05429C20.6678 6.75064 20.4156 6.49849 20.1118 6.32312L13.1118 2.32312C12.8078 2.14759 12.4629 2.05518 12.1118 2.05518C11.7607 2.05518 11.4159 2.14759 11.1118 2.32312L4.11182 6.32312C3.80808 6.49849 3.5558 6.75064 3.38028 7.05429C3.20476 7.35793 3.11218 7.7024 3.11182 8.05312V16.0531C3.11218 16.4039 3.20476 16.7483 3.38028 17.052C3.5558 17.3556 3.80808 17.6078 4.11182 17.7831L11.1118 21.7831C11.4159 21.9587 11.7607 22.0511 12.1118 22.0511C12.4629 22.0511 12.8078 21.9587 13.1118 21.7831L20.1118 17.7831C20.4156 17.6078 20.6678 17.3556 20.8434 17.052C21.0189 16.7483 21.1115 16.4039 21.1118 16.0531Z" stroke="#97A3A2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3.38184 7.0127L12.1118 12.0627L20.8418 7.0127" stroke="#97A3A2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.1118 22.1327V12.0527" stroke="#97A3A2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p>@lang('Products')</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex" href="{{ route('seller.promo.index') }}">
                    <svg class="menu-left-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0)">
                            <path d="M18.8906 5.01385L4.89062 19.0139" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.39062 9.01385C7.77134 9.01385 8.89062 7.89457 8.89062 6.51385C8.89062 5.13314 7.77134 4.01385 6.39062 4.01385C5.00991 4.01385 3.89062 5.13314 3.89062 6.51385C3.89062 7.89457 5.00991 9.01385 6.39062 9.01385Z" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.3906 20.0139C18.7713 20.0139 19.8906 18.8946 19.8906 17.5139C19.8906 16.1331 18.7713 15.0139 17.3906 15.0139C16.0099 15.0139 14.8906 16.1331 14.8906 17.5139C14.8906 18.8946 16.0099 20.0139 17.3906 20.0139Z" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0">
                                <path d="M0 12C0 5.37258 5.37258 0 12 0V0C18.6274 0 24 5.37258 24 12V12C24 18.6274 18.6274 24 12 24V24C5.37258 24 0 18.6274 0 12V12Z" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>

                    <p>@lang('Promo')</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex" href="{{ route('seller.statistic.index') }}">
                    <svg class="menu-left-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 6L18.29 8.29L13.41 13.17L9.41 9.17L2 16.59L3.41 18L9.41 12L13.41 16L19.71 9.71L22 12V6H16Z" fill="#ACB4B4"/>
                    </svg>
                    <p>@lang('Statistic')</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex" href="{{ route('seller.payment.banks') }}">
                    <svg class="menu-left-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_5905_14415)">
                            <path d="M20.8906 4.01367H2.89062C1.78606 4.01367 0.890625 4.9091 0.890625 6.01367V18.0137C0.890625 19.1182 1.78606 20.0137 2.89062 20.0137H20.8906C21.9952 20.0137 22.8906 19.1182 22.8906 18.0137V6.01367C22.8906 4.9091 21.9952 4.01367 20.8906 4.01367Z" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M0.890625 10.0137H22.8906" stroke="#ACB4B4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_5905_14415">
                                <rect width="24" height="24" fill="white" transform="translate(-0.109375 0.0136719)"/>
                            </clipPath>
                        </defs>
                    </svg>

                    <p>@lang('Payment')</p>
                </a>
            </li>
        </ul>
    </div>


