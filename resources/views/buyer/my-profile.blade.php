@extends('layouts.buyer')

@section('title', 'Shopping Cart')

@section('extra-header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />
    <style>
        .iti { width: 100%; }
    </style>

@endsection

@section('page-id', 'gray')
@section('content')
    <div class="content">
        <div class="container full-sm">
            <div class="row">
                <div id="page-accout" class="mobi-block w-100">
                    <div class="sp-user">
                        <div class="container">
                            <div class="user-mobi">
                                <div class="avatar text-center">
                                    <img style="width: 80px; height: 80px;" class="rounded-circle" src="{{ userImage($user->avatar) }}" alt="">
                                    <h3>{{$user->name}} {{$user->last_name}}</h3>
                                    <span id="edit-accout" class="edit">Edit Account</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-user container">
                        <div class="item-user d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset("vendor/buyer/Img/mdi_store_mall_directory.svg") }}" alt="">
                                <div>
                                    <p>@lang('Manage Store')</p>
                                    <p class="color-gray">Manage your store</p>
                                </div>
                            </div>
                            <img class="mr-0" src="{{ asset("vendor/buyer/Img/arrow-right.svg") }}" alt="">
                        </div>
                        <div class="item-user d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset("vendor/buyer/Img/ic_payment.svg") }}" alt="">
                                <div>
                                    <p>Payment</p>
                                    <p class="color-gray">Manage your credit/debit cards</p>
                                </div>
                            </div>
                            <img class="mr-0" src="{{ asset("vendor/buyer/Img/arrow-right.svg") }}" alt="">
                        </div>
                        <div class="item-user d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset("vendor/buyer/Img/mdi_card_giftcard.svg") }}" alt="">
                                <div>
                                    <p>My Reward</p>
                                    <p class="color-gray">View and redeem your rewards</p>
                                </div>
                            </div>
                            <img class="mr-0" src="{{ asset("vendor/buyer/Img/arrow-right.svg") }}" alt="">
                        </div>
                        <div class="item-user d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset("vendor/buyer/Img/mdi_settings.svg") }}" alt="">
                                <div>
                                    <p>Settings</p>
                                    <p class="color-gray"> Push notifications, subscription, etc</p>
                                </div>
                            </div>
                            <img class="mr-0" src="{{ asset("vendor/buyer/Img/arrow-right.svg") }}" alt="">
                        </div>
                        <div class="item-user d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset("vendor/buyer/Img/mdi_help.svg") }}" alt="">
                                <div>
                                    <p>Help Center</p>
                                    <p class="color-gray">Contact our support to help you</p>
                                </div>
                            </div>
                            <img class="mr-0" src="{{ asset("vendor/buyer/Img/arrow-right.svg") }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-3 col-collap web-block">

                    @include('buyer.partials.menu-left-user')
                </div>
                <div class="col-md-9 col-sm-12 col-collap">
                    <div id="tab-mobi" class="tab-content d-sm-none">
                        <div id="home" class="container tab-pane active">
                            <div class="col-12  personal-information">
                                <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data" class="step-accound" onsubmit="process(event);">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="profile-picture d-flex">
                                        <div class="wrap-camera">
                                            <img id="userAvatar" class="rounded-circle" src="{{ userImage($user->avatar) }}" alt="">
                                            <div class="camera mobi-block" onclick="openfileDialog();"><i class="fas fa-camera"></i></div>
                                        </div>
                                        <span class="click-openfile web-block" onclick="openfileDialog();">@lang('Change Profile Picture')</span>
                                        <input class="d-none" type="file" id="fileLoader" name="avatar" title="Load File"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 fist-name">
                                            <div class="form-group">
                                                <label class="color-gray">@lang('First Name')</label>
                                                <input id="first-name" name="name" type="text" class="form-control" value="{{$user->name}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 last-name">
                                            <div class="form-group">
                                                <label class="color-gray">@lang('Last Name')</label>
                                                <input id="name" name="last_name" type="text" class="form-control" value="{{$user->last_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="color-gray">Email</label>
                                                <input name="email" type="text" class="form-control" placeholder="@lang('Enter email')" value="{{$user->email}}" disabled>
                                            </div>
                                        </div>
{{--                                        <div class="col-md-6 col-sm-12 " id="show_hide_password">--}}
{{--                                            <div class="form-group ">--}}
{{--                                                <label class="color-gray">Password</label>--}}
{{--                                                <div class="pass-word">--}}
{{--                                                    <input class="form-control" id="password-1" type="password" name="password" onkeyup="checkpass1()" value="1111111111">--}}
{{--                                                    <div class="show-hidden">--}}
{{--                                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="color-gray">@lang('Date of Birth')</label>
                                                <input id="datepicker" class="form-control" name="date_of_birth"
                                                       @if($userAddress->date_of_birth) value="{{date('d-m-Y', strtotime($userAddress->date_of_birth))}}"
                                                       @else() placeholder=" DD-MM-YY" @endif />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="note form-group profile-name">
                                                <label class="color-gray">@lang('Phone Number')</label>
                                                <div class="btn-group phone">
                                                    <input type="tel" class="form-control" name="phone" id="phone" value="{{old('phone', $userAddress->phone)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wrap-address">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label class="color-gray">@lang('Billing Address')</label>
                                            <textarea id="address" name="addresses" class="form-control" placeholder="Address" rows="5">{{$userAddress->addresses}}</textarea>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label>@lang('Province')</label>
                                            <div class="wrap-select">
                                                <select name="province_id" class="selectpicker" title="Province">
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->id}}"
                                                                @if(isset($userAddress->province_id) && $province->id == $userAddress->province_id)
                                                                selected
                                                                @endif
                                                        >
                                                            {{$province->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label>@lang('City')</label>
                                            <div class="wrap-select">
                                                <select class="selectpicker" name="regency_id" title="Cities" id="cities" style="width:auto;">
                                                    @if(isset($userAddress->province_id))
                                                        @foreach(App\Model\AddressCity::where('province_id',$userAddress->province_id)->get() as $city)
                                                            <option value="{{$city->id}}"
                                                                    @if($city->id == $userAddress->regency_id)
                                                                    selected
                                                                    @endif
                                                            >{{$city->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label>@lang('District')</label>
                                            <div class="wrap-select">
                                                <select class="selectpicker" title="District" id="districts" name="district_id" style="width:auto;">
                                                    @if(isset($userAddress->province_id))
                                                        @foreach(App\Model\AddressDistrict::where('regency_id',$userAddress->regency_id)->get() as $district)
                                                            <option value="{{$district->id}}"
                                                                    @if($district->id == $userAddress->district_id)
                                                                    selected
                                                                    @endif
                                                            >{{$district->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn-customer secondary btn col-md-3 col-sm-12 mt-20px">@lang('Save')</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('vendor/buyer/script/address.js') }}"></script>
    <script type="text/javascript" src="{{ asset("vendor/buyer/script/user-profile.js") }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            preferredCountries: ["id", "sg", "kr", "vn"],
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        function process(event) {
            const phone = phoneInput.getNumber();
            $("#phone").val(phone);
            return true;
        }
    </script>
    @if (session()->has('success_message'))
        <script>
            $.notify({
                content :'{{ session()->get('success_message') }}',
                alertType: "alert-success",
                timeout: 3000
            });
        </script>
    @endif

{{--    show errors from validate--}}
    @if(count($errors) > 0)
        @foreach ($errors->all() as $error)
            <script>
                $.notify({
                    content :'{{ $error }}',
                    alertType: "alert-warning",
                    timeout: 5000
                });
            </script>
        @endforeach
    @endif

{{--    show error during processing--}}
    @if(session()->has('error_message'))
        <script>
            $.notify({
                content :'{{ session()->get('error_message') }}',
                alertType: "alert-warning",
                timeout: 5000
            });
        </script>
    @endif
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     var input = document.getElementById('flag');
        //     if (localStorage['flag']) {
        //         input.value = localStorage['flag'];
        //     }
        //     input.onchange = function () {
        //         localStorage['flag'] = this.value;
        //     }
        // });
    </script>
@endsection