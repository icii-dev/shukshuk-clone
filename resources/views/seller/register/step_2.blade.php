\@extends('layouts.seller_register')
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
        .wrap-update-img p{
            width: 100%;
        }
        .bootstrap-select ul.dropdown-menu li:first-child {
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="content content-seller">
        <div class="container">
            <div class="tab-content">
                <div>
                    <div class="container">
                        <form id="form-step-2" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="body-seller-refistration">
                                <div class="seller-information">
                                    <h2>@lang('Store Information')</h2>
                                    <p class="about-seller d-block">@lang('Please kindly provide your store information rightly.')</p>
                                </div>

                                <div class="col-5 sl-regis-information  max-w-400">
                                    @if ($errors->any())
                                        <div class="alert alert-danger pb=0">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <label class="topic-label"><b>@lang('Store Details')</b></label>
                                    <div class="form-group">
                                        <label class="gray-name">@lang('Type of Seller (Individual/NGO/Company)') *</label>
                                        <div class="wrap-select">
                                            <select class="selectpicker" name="type" title="Select type of seller" required>
                                                @foreach(getListStoreType() as $typeId => $typeName)
                                                    @php
                                                        $selected = old('type', $store ? $store->type : '') === $typeId;
                                                    @endphp
                                                    <option value="{{ $typeId }}" {{ $selected ? 'selected' : '' }}>{{ $typeName }}</option>
                                                @endforeach
                                            </select>
                                            <img class="img-select"
                                                 src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                        </div>
                                        <div class="error-message-holder"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">@lang('Proof of NGO/Company seller only')</label>
                                        <div class="detail-form wrap-update-img update-photo js-image-picker">
                                            <p class="label img-selected-name" data-text="Upload Proof of NGO/Company">Upload Proof of NGO/Company</p>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="proof_image_upload"
                                                           class="custom-file-input update-img" value="Update">
                                                </div>
                                            </div>
                                            <div class="error-message-holder"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">@lang('Type of Industry')</label>
                                        <div class="wrap-select">
                                            <select class="selectpicker" name="industry_id"
                                                    title="@lang('Select type of industry')">
                                                @foreach(getListIndustry() as $industryId => $industryName)
                                                    @php
                                                        $selected = old('industry_id', $store ? $store->industry_id : '') == $industryId;
                                                    @endphp
                                                    <option value="{{ $industryId }}" {{ $selected ? 'selected' : '' }}>{{ $industryName }}</option>
                                                @endforeach
                                            </select>
                                            <img class="img-select"
                                                 src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                        </div>
                                        <div class="error-message-holder"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">@lang('Product Category Type')</label>
                                        <div class="wrap-select">
                                            <select class="selectpicker" name="category_id" title="@lang('Select category')">
                                                @foreach(getListCategory2Levels() as $category)
                                                    @php
                                                        $categoryId = $category['id'];
                                                        $categoryName = $category['name'];
                                                        $level = $category['level'];
                                                        $selected = old('category_id', $store ? $store->category_id : '') == $categoryId;
                                                    @endphp
                                                    <option value="{{ $categoryId }}" {{ $selected ? 'selected' : '' }}>{!! str_repeat('&nbsp;', ($level - 1) * 4) !!} {{ $categoryName }}</option>
                                                @endforeach
                                            </select>
                                            <img class="img-select"
                                                 src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                        </div>
                                        <div class="error-message-holder"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">@lang('Store Name') *</label>
                                        <input id="storename" name="name" type="text" class="form-control"
                                               placeholder="@lang('Type your store name')" value="{{ old('name', $store ? $store->name : '') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">@lang('Store description')</label>
                                        <textarea name="description" class="form-control"
                                                  placeholder="@lang('Type your store description (Keep it short and obvious)')"
                                                  rows="5">{{ old('description', $store ? $store->description : '') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">@lang('Store Profile Photo')</label>
                                        <div class="detail-form wrap-update-img js-image-picker">
                                            <p class="label img-selected-name" data-text="Upload Store Profile Picture">@lang('Upload Store Profile Picture')</p>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="avatar_image_upload"
                                                           class="custom-file-input update-img"
                                                           value="Update">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error-message-holder"></div>
                                    </div>

                                        <label class="topic-label"><b>@lang('Store Address')</b></label>
                                        <div class="form-group">
                                            <div class="wrap-select">
                                                <select class="selectpicker" data-title="@lang('Province')" name="address_province_id" style="width:auto;" required>
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->id}}"
                                                                @if(isset($userAddress->province_id) && $province->id == $userAddress->province_id)
                                                                selected
                                                                @endif
                                                        >{{$province->name}}</option>
                                                    @endforeach
                                                </select>
                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                            </div>
                                            <div class="error-message-holder"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="wrap-select">
                                                <select dusk="address-city-id" class="selectpicker" data-title="@lang('City')" id="cities" name="address_city_id" style="width:auto;" required>
                                                </select>
                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                            </div>
                                            <div class="error-message-holder"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="wrap-select">
                                                <select dusk="address-district-id" class="selectpicker" data-title="@lang('District')" id="districts" name="address_district_id" style="width:auto;" required>
                                                </select>
                                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                                            </div>
                                            <div class="error-message-holder"></div>
                                        </div>

                                        <div class="form-group">
                                            <textarea id="address" name="address" class="form-control" placeholder="@lang('Address')" rows="3" required>@if(isset($userAddress->addresses)){{$userAddress->addresses}}@endif</textarea>
                                        </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-center">
                                    <div class="col-md-5 col-sm-12  max-w-400">
                                        <div class="row">
                                            <div class="col-6"><p class="pt-3">Step 2 of 3</p></div>
                                            <div class="col-6">
                                                <button dusk="btn-continue" class="btn btn-customer secondary">@lang('Continue')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="review">
                                    <a href="{{ route('seller.register.step_1') }}">&#x2190; @lang('Previous Step')</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- #.container -->
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
                errorPlacement: function(error, element) {
                    var parent = $(element).closest('.form-group');
                    if (parent.length > 0
                        && parent.find('.error-message-holder').length > 0
                    ) {
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
                    var $label = $(this).closest('.js-image-picker').find(".label");

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

                $(this).closest('.js-image-picker').find(".label").html(file.name);
            });
        });
    </script>

{{--    address of store--}}
    <script type="text/javascript" src="{{ asset('vendor/buyer/script/address.js') }}"></script>
    <script>
        // global app configuration object
        var config = {
            routes: {
                url: "{{url('')}}" + "/",
                cities: "{{ route('address.cities', '') }}" +"/",
                districts: "{{ route('address.districts', '') }}" +"/",
            },
        };
    </script>
    <script type="text/javascript">
        $('select').on('change', function (e) {
            var select = $(e.currentTarget);

            if(select.hasClass('error')){
                // formSt1.valid();
            }
            if(select.attr("name")=='address_province_id'){
                getCitiesOfProvince(select.val());
                //refresh district
                $('#districts').html('').selectpicker('refresh');
            }
            else if(select.attr("name")=='address_city_id'){
                if(select.val()){
                    getDistrictOfCity(select.val());
                }
            }

        });

    </script>

@endsection
