<!-- Step Nav -->
<div class="w-100">
    <ul class="nav d-flex justify-content-end">
        <li id="li-step-1" class="detail-step d-flex step-active-color">
            <a id="item-step-1" class="item-step nav-link d-flex active" href="javascript:void(0);">
                <span class="d-block rounded-circle number">1</span>
                <span class="text">@lang('Seller Information')</span>
            </a>
        </li>
        <li id="li-step-2" class="detail-step d-flex">
            <a id="item-step-2" class="nav-link d-flex {{ $step >1 ? 'active' : '' }}" href="javascript:void(0);">
                <span class="d-block rounded-circle number">2</span>
                <span class="text">@lang('Store Information')</span>
            </a>
        </li>
        <li id="li-step-3" class="detail-step d-flex">
            <a id="item-step-3" class="nav-link d-flex {{ $step > 2 ? 'active' : '' }}" href="javascript:void(0);">
                <span class="d-block rounded-circle number">3</span>
                <span class="text">@lang('Finishing Your Registration')</span>
            </a>
        </li>
    </ul>
</div>
<!-- #step Nav -->
