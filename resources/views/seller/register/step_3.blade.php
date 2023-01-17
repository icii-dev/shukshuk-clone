@extends('layouts.seller_register')
@section('head')
    <style>
        div.dropdown-menu.open{
            max-height: 320px !important;
            overflow: hidden;
        }
        ul.dropdown-menu.inner{
            max-height: 280px !important;
            overflow-y: auto;
        }
        div.dropdown-menu.show{
            min-width: 370px !important;
            overflow: hidden;
        }
    </style>
@endsection
@section('content')
    <div class="content content-seller">
        <div class="container">
            <div class="tab-content">
                <div>
                    <div class="container">
                        <form id="form-step-3" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="body-seller-refistration">
                                <div class="seller-information">
                                    <h2>@lang('Finishing Your Registration')</h2>
                                    <p class="about-seller d-block">
                                        @lang('One last step before we proceed your seller registration. Please provide an active bank account.')
                                    </p>
                                </div>
                                <div class="col-5 sl-regis-information max-w-400">
                                    @if ($errors->any())
                                        <div class="alert alert-danger pb=0">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="detail-checkbox form-group">
{{--                                        <label class="color-gray">Preferred Payment Method</label>--}}
                                        @php
                                            $storePaymentMethods = [];
                                            if ($store) {
                                                $storePaymentMethods = $store->paymentMethods->pluck('id')->toArray();
                                            }
                                        @endphp
                                        @foreach(getListPaymentMethod() as $paymentMethodId => $paymentMethodName)
                                            @php
                                            $checked = in_array($paymentMethodId, old('payment_method_ids', $storePaymentMethods));
                                            @endphp
{{--                                            <div class="wrap-check">--}}
{{--                                                <label class="custom-control custom-checkbox">--}}
{{--                                                    <input type="checkbox" name="payment_method_ids[]"--}}
{{--                                                           value="{{ $paymentMethodId }}"--}}
{{--                                                           class="custom-control-input"--}}
{{--                                                           {{ $checked ? 'checked' : '' }}--}}
{{--                                                    >--}}
{{--                                                    <span class="custom-control-label"></span>--}}
{{--                                                    <span class="custom-text">{{ $paymentMethodName }}</span>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
                                        @endforeach
                                        <div class="error-message-holder"></div>
                                    </div>
                                    <div class="detail-checkbox form-group">
                                        <label>
                                            @lang('Add your bank account for you to withdraw your money:')
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Select Bank')</label>
                                        <div class="wrap-select">
                                            <select id="bank_code" class="selectpicker form-control" name="bank_code" onchange="document.getElementById('bank_name').value=this.options[this.selectedIndex].text">
                                                <option value="" selected disabled>@lang('Select Bank')</option>
                                            </select>
                                            <img class="img-select"
                                                 src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <input type="hidden" name="bank_name" id="bank_name" value="" />
                                        <div class="form-group">
                                            <label>@lang('Account Name')</label>
                                            <input class="form-control" name="account_holder_name">
                                        </div>
                                    <div class="form-group">
                                        <label>@lang('Account No.')</label>
                                        <input class="form-control" name="account_number">
                                    </div>

{{--                                    <p class="color-red">We recommend you to use Shukshuk Delivery. We’re not--}}
{{--                                        responsible to guarantee the product shipping if you’re using self-delivery.</p>--}}
                                </div>
                                <hr>
                                <div class="d-flex justify-content-center">
                                    <p>@lang('By clicking on the Register button, you agree to our') <a href="{{route('footer.about', 'terms-conditions')}}">Terms & Conditions</a> @lang('and our') <a href="{{route('footer.about', 'privacy-policy')}}">Privacy Policy</a>.</p>
                                </div>
                                <div class="mb-1 d-flex justify-content-center">
                                    <p>@lang('Please check and continue.')</p>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="col-md-5 col-sm-12 max-w-400">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="pt-3">Step 3 of 3</p>
                                            </div>
                                            <div class="col-6">
                                                <button dusk="btn-continue" class="btn btn-customer secondary">@lang('Continue')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="review">
                                    <a href="{{ route('seller.register.step_2') }}">&#x2190; @lang('Previous Step')</a>
                                </div>
                            </div>
                        </form>
                        <!-- #form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#form-step-2').validate({
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    var parent = $(element).closest('.form-group');

                    if (parent.length > 0
                        && parent.find('.error-message-holder').length > 0) {
                        console.log(1);
                        error.appendTo(
                            parent.find('.error-message-holder')
                        )
                    } else {
                        console.log(2);
                        error.insertAfter(element);
                    }
                },
            });
        });
    </script>

{{--    bank--}}
    <script>
        getAvailableBank();
        function getAvailableBank() {
            startLoading();
            $.ajax({
                url: "{{route('seller.disbursement.getBanks')}}",
                data: $('#withDrawForm').serialize(),
                dataType: "json",
                success: function(data){
                    stopLoading();
                    // $("#withdrawModal").modal();
                    $("#bank_code option").remove();
                    $("#bank_code").append('<option value="" selected disabled>@lang('Select Bank')</option>')
                    $.each(data, function (key, value){
                        var code = value.code;
                        var name = value.name;
                        $("#bank_code").append('<option class="bank-code-options" data-content="'+name+'" value="'+code+'">'+name+'</option>');
                    });
                    $("#bank_code").selectpicker("refresh");
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                }
            });
        }


    </script>
@endsection
