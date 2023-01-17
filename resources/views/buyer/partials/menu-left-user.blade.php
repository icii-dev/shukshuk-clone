<div class="avatar text-center">
    <img src="{{asset('vendor/buyer/Img/avatar-1.png')}}" alt="">
    <h3 class="truncate-overflow-one mt-24px">Tin Tran</h3>
</div>

<ul class="nav tab-user" style="margin-top:60px">
    <li>
        <a class="{{ (\Request::route()->getName() == 'users.edit') ? 'active' : '' }} a-tab-order" href="{{route('users.edit')}}">
            <div class="account">
                <div class="d-flex order">
                    <i class="fas fa-user-circle"></i>
                    <p>@lang('Account')</p>
                </div>
            </div>
        </a>
    </li>
    <li id="li-my-oder">
        <a class="{{ (\Request::route()->getName() == 'users.orders') ? 'active' : '' }} {{ (\Request::route()->getName() == 'order.show') ? 'active' : '' }} a-tab-order" href="{{route('users.orders')}}">
            <div class="account">
                <div class="d-flex order">
                    <img id="icon-order" src="{{ asset("vendor/buyer/Img/order-black.svg") }}" alt="">
                    <p>@lang('My Order')</p>
                </div>
            </div>
        </a>
    </li>
{{--    <li >--}}
{{--        <div class="account">--}}
{{--            <div class="d-flex order">--}}
{{--                <img src="{{ asset("vendor/buyer/Img/ic_rewards.svg") }}" alt="">--}}
{{--                <p>My Reward</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li>--}}
{{--        <div class="account">--}}
{{--            <div class="d-flex order">--}}
{{--                <img src="{{ asset("vendor/buyer/Img/ic_payment.svg") }}" alt="">--}}
{{--                <p>@lang('Payments')</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
</ul>
