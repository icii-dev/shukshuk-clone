@extends('layouts.seller_register')

@section('head')
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />
    <style>
        .iti { width: 100%; }
    </style>
@endsection

@section('content')
    <div class="content content-seller">
        <div class="container">

        <!--  -->
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="container">
                        <form id="form-step-1" enctype="multipart/form-data"
                              action="{{ route('seller.register.step_1') }}" method="post">
                            @csrf
                            <div class="body-seller-refistration">
                                <div class="seller-information">
                                    <h2>@lang('Seller Information')</h2>
                                    <p class="about-seller d-block">@lang('Let’s start by completing your profile.')</p>
                                </div>
                                <div class="col-5 sl-regis-information  max-w-400">
                                    <!-- Error -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger pb=0">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                @endif
                                <!-- #Error -->

                                    <div class="group">
                                        <div class="row">
                                            <div class="col-6 form-group">
                                                <label class="gray-name" for="first-name">@lang('First Name') *</label>
                                                <input
                                                        id="first-name"
                                                        name="first_name"
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="@lang('First Name')"
                                                        value="{{old('first_name', $seller ? $seller->first_name : '')}}"
                                                        required/>
                                            </div>
                                            <div class="col-6 form-group">
                                                <label class="gray-name" for="last-name">@lang('Last Name') *</label>
                                                <input id="last-name" name="last_name" type="text"
                                                       class="form-control"
                                                       placeholder="@lang('Last Name')"
                                                       value="{{ old('last_name',  $seller ? $seller->last_name : '') }}"
                                                       required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name" for="email">@lang('Email Address') *</label>
                                        <input name="email"
                                               type="text"
                                               id="email"
                                               class="form-control"
                                               placeholder="Email"
                                               value="{{ old('email', $seller ? $seller->email : '') }}"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label class="color-gray" for="dob">@lang('Date of Birth') *</label>
                                        <input name="dob" id="dob" class="form-control" style="width: 100%"
                                               placeholder="dd-mm-yyyy"
                                               value="{{old('dob', $seller && $seller->dob ? $seller->dob->format('d-m-Y') : '')}}"
                                               required/>
                                    </div>
                                    <div class="form-group">
                                        <div class="note form-group profile-name">
                                            <label class="color-gray">@lang('Phone Number') *</label>
{{--                                            <input--}}
{{--                                                    id="phone"--}}
{{--                                                    name="phone"--}}
{{--                                                    type="text"--}}
{{--                                                    class="form-control"--}}
{{--                                                    placeholder="@lang('Your Phone Number')"--}}
{{--                                                    value="{{ old('phone', $seller ? $seller->phone : '') }}"--}}
{{--                                                    required--}}
{{--                                            />--}}
                                            <input type="tel" class="form-control"
                                                   name="phone" id="phone"
                                                   value="{{ old('phone', $seller ? $seller->phone : '') }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name" for="nationality_id">@lang('Country of Citizenship') *</label>
                                        <select name="nationality_id" class="form-control" required>
                                            @foreach(getListCountry() as $countryId => $countryName)
                                                @php
                                                    $selected = old('nationality_id', $seller ? $seller->nationality_id : '') === $countryId;
                                                @endphp
                                                <option value="{{ $countryId }}" {{ $selected ? 'selected' : '' }}>
                                                    {{ $countryName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name" for="residence_id">@lang('Country of Residence') *</label>
                                        <select class="form-control" name="residence_id" required>
                                            @foreach(getListCountry() as $countryId => $countryName)
                                                @php
                                                    $selected = old('residence_id', $seller ? $seller->residence_id : '') === $countryId;
                                                @endphp
                                                <option value="{{ $countryId }}" {{ $selected ? 'selected' : '' }}>{{ $countryName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">@lang('ID Number') *</label>
                                        <input name="id_number" type="text" class="form-control"
                                               value="{{ old('id_number', $seller ? $seller->id_number : '') }}"
                                               required/>
                                    </div>
                                    <div class="form-group">
                                        <label class="color-gray mt-16px">Proof of ID *</label>
                                        <div class="detail-form wrap-update-img js-image-proof-id">
                                            <p class="label img-selected-name" data-text="Upload ID Photo">Upload ID Photo</p>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input
                                                            id="proof-image-upload"
                                                            type="file"
                                                            name="proof_image_upload"
                                                            class="custom-file-input update-img js-id-photo-upload"
                                                            {{ $seller ? '' : 'required' }}
                                                    />
                                                </div>
                                            </div>
                                            <div class="error-message-holder" style="margin-top: 8px"></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-center">
                                    <div class="col-md-5 col-sm-12 max-w-400">
                                        <div class="row">
                                            <div class="col-6"><p class="pt-3">Step 1 of 3</p></div>
                                            <div class="col-6">
                                                <button dusk="btn-continue" class="btn btn-customer secondary">@lang('Continue')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- submit button holder -->
                            </div>
                        </form>
                    </div>
                    <!-- #.container -->
                </div>
                <!-- #.tab-1 -->
            </div>
            <!-- #.tab-content -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            preferredCountries: ["id", "sg", "kr", "vn"],
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        function process(event) {
            // event.preventDefault();
            const phone = phoneInput.getNumber();
            $("#phone").val(phone);
            return true;
        }
    </script>
    <script>
        $(function () {
            $('#dob').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy'
            });

            $('#form-step-1').validate({
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    var parent = $(element).closest('.form-group');

                    if (parent.length > 0
                        && parent.find('.error-message-holder').length > 0) {
                        error.appendTo(
                            parent.find('.error-message-holder')
                        )
                    } else {
                        error.insertAfter(element);
                    }
                },
            });

            $('input[type="file"]').on("change", function() {
                var file = $(this)[0].files[0];

                if (!file) {
                    var $label = $(this).closest('.js-image-proof-id').find(".label");

                    $label.html(
                        $label.data('text')
                    );

                    return;
                }

                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

                if (!allowedExtensions.exec(file.name) ) {
                    bootoast.toast({
                        message: "Please select a valid image file !",
                        type: 'danger',
                        position: 'rightBottom',
                    });

                    $(this).val("");

                    return;
                }

                if (file.size > 8 * 1024 * 1024) {
                    bootoast.toast({
                        message: "File too large !",
                        type: 'danger',
                        position: 'rightBottom',
                    });

                    $(this).val("");

                    return;
                }

                $(this).closest('.js-image-proof-id').find(".label").html(file.name);
            });
        });
    </script>
@endsection
