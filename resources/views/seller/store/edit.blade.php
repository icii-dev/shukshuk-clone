@extends('layouts.seller_product_edit_add')

@push('stylesheets')
    <link rel="stylesheet" href="{{asset('asset-common/css/croppie.min.css')}}">
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />
    <style>
        .iti { width: 100%; }
        .cr-image{
            /*max-width: 300px;*/
        }
    </style>
@endpush

@section('content')
    <div class="content content-home-seller">
        <div class="header-sellersHome  bg-cover-seller-2">
            <div class="container">
                <a id="back" href="{{ route('seller.home') }}"style="font-size:14px ; color: #30B6A4;"><- Back</a>
                <span style="margin-left: 30px;font-weight: 500;">@lang('Manage Store')</span>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <form method="post" onsubmit="process(event);">
            @if ($errors->any())
                <div class="alert alert-danger pb=0">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf
            <div class="body-edit-product">
                <div class="row f-sm-col-reverse">
                    <div class="col-sm-12 col-md-5 right-body-edit ">
                        <div class="detail-form form-group">
                            <label class="gray-name">@lang('Store Name')</label>
                            <input type="text" class="form-control" name="name" value="{{old('name', $store->name)}}" required="">
                        </div>
                        <div class="detail-form form-group">
                            <label class="gray-name">@lang('Store Description')</label>
                            <textarea name="description" class="form-control" rows="12">{{old('description', $store->description)}}</textarea>
                        </div>
                        <div class="detail-form form-group">
                            <label class="gray-name">@lang('Phone Number')</label><br>
                            <input type="tel" class="form-control" name="phone" id="phone" value="{{old('phone', $store->seller->phone)}}">
                        </div>
                        <div class="detail-form form-group">
                            <label class="gray-name">@lang('Store Address')</label>
                            <input type="text" class="form-control" name="address" value="{{old('address', $store->address)}}">
                        </div>
                        <div class="detail-form form-group">
                            <label class="gray-name">@lang('Store Location')</label>
                            <div class="wrap-select">
                                <select class="selectpicker" name="address_province_id" style="width:auto;" required>
                                    @foreach($provinces as $province)
                                        <option value="{{$province->id}}"
                                                @if(isset($storeProvince->id) && $province->id == $storeProvince->id)
                                                selected
                                                @endif>{{$province->name}}</option>
                                    @endforeach
                                </select>
                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                            </div>
                            <div class="error-message-holder"></div>
                        </div>

                        <div class="detail-form form-group">
                            <div class="wrap-select">
                                <select class="selectpicker" id="cities" name="address_city_id" style="width:auto;" required>
                                    @foreach($listCityDefault as $city)
                                        <option value="{{$city->id}}"
                                                @if(isset($storeCity->id) && $city->id == $storeCity->id)
                                                selected
                                                @endif>{{$city->name}}</option>
                                    @endforeach
                                </select>
                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                            </div>
                            <div class="error-message-holder"></div>
                        </div>

                        <div class="detail-form form-group">
                            <div class="wrap-select">
                                <select class="selectpicker" id="districts" name="address_district_id" style="width:auto;" required>
                                    @foreach($listDistrictDefault as $district)
                                        <option value="{{$district->id}}"
                                                @if(isset($storeDistrict->id) && $district->id == $storeDistrict->id)
                                                selected
                                                @endif>{{$district->name}}</option>
                                    @endforeach
                                </select>
                                <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
                            </div>
                            <div class="error-message-holder"></div>
                        </div>
                        <div class="detail-form form-group">
                            <label class="gray-name">@lang('Store status')</label>
                            @if($store->status == \App\Model\Store::STATUS_WAITING_APPROVAL)
                                <div>
                                    <span class="badge badge-warning">@lang('Waiting for approval')</span>
                                </div>
                            @else
                            <div class="wrap-check d-flex">
                                <label id="check-1" class="custom-control d-flex custom-checkbox custom-crile crile-1">
                                    <input id="input-1" type="radio" name="is_closed" class="custom-control-input" value="{{\App\Model\Store::STATUS_ACTIVE}}" {{old('status', $store->status) == \App\Model\Store::STATUS_ACTIVE ? 'checked' : ''}}>
                                    <span class="custom-control-label d-inline-block"></span>
                                    <span class="custom-text color-black">@lang('Store Open')</span>
                                </label>
                                <label id="check-2" class="d-flex custom-control custom-checkbox custom-crile">
                                    <input id="input-2" type="radio" name="is_closed" class="custom-control-input" value="{{\App\Model\Store::STATUS_DEACTIVE}}" {{old('status', $store->status) == \App\Model\Store::STATUS_DEACTIVE ? 'checked' : ''}}>
                                    <span class="custom-control-label d-inline-block"></span>
                                    <span class="custom-text color-black">@lang('Store is Close')</span>
                                </label>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col"></div>
                    <div class="col-md-6 col-sm-12 right-edit ">
                        <p class="p-gray">
                            @lang('Store Profile Photo')
                        </p>
                        <div class="change-profile d-flex">
                            <img onclick="openAvatarBrowseFile();" style="border-radius: 50%" id="avatar-edited-image" src="{{getStoreAvatarUrlForSeller($store->avatar_image)}}" alt="">
                            <span class="click-openfile color-second" onclick="openAvatarBrowseFile();">@lang('Change Profile Photo')</span>
                            <input class="d-none" type="file" id="avatar-file-input" name="files" title="Load File">
                        </div>
                        <p class="p-gray">
                            @lang('Store Cover')
                        </p>
                        <div class="form-check-inline" style="margin-bottom: 29px">
                            <div class="custom-control custom-radio" style="padding-left: 12px">
                                <input type="radio" id="rd_1" name="is_cover_video" value="0" class="custom-control-input" @if(!$store->is_cover_video) checked @endif>
                                <label class="custom-control-label green" for="rd_1">@lang('Using Image')</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="rd_2" name="is_cover_video" value="1" class="custom-control-input" @if($store->is_cover_video) checked @endif>
                                <label class="custom-control-label green" for="rd_2">@lang('Using Video')</label>
                            </div>
                        </div>
                        <div class="template" id="coverImage" @if($store->is_cover_video) style="display: none" @endif>
                            <img onclick="openCoverBrowseFile();" id="cover-edited-image" class="img-fluid bg-cover-store img-border-store-cover" src="{{getStoreCoverUrlForSeller($store->cover_image)}}" alt="">
{{--                            <span class="click-openfile color-second" onclick="openCoverBrowseFile();">Change Cover</span>--}}
                            <input class="form-control col-6" type="button" value="@lang('Change Cover')" onclick="openCoverBrowseFile();"
                                   style="font-size: 14px;
                                    line-height: 140%;
                                    text-align: center;
                                    letter-spacing: -0.011em;
                                    color: #30B6A4;
                                    border: 1px solid #30B6A4;
                                    margin-bottom: 20px"
                                    >
                            <input class="d-none" type="file" id="cover-file-input" name="files" title="@lang('Load File')">
                            <p class="p-gray">
                                @lang('Recommended image size is 1740x720 px')
                            </p>
                        </div>
                        <div class="template" id="coverVideo" @if(!$store->is_cover_video) style="display: none" @endif>
                            <input type="text" class="form-control col-9" name="cover_video"
                                   placeholder="@if($store->cover_video) {{$store->cover_video}} @else @lang('Youtube Link') @endif"
                                   value="@if($store->cover_video) {{$store->cover_video}} @endif"
                            >
                            <div style="margin-top: 25px; color: #4E5662">
                                <p>@lang('Video upload tips:')</p>
                                <p>&rarr; @lang('You can tell a quick story of your store by creating a nice video about it')</p>
                                <p>&rarr; @lang('Don’t create a very long duration video. We recommend to share your story within 1 to 1.5 minutes.')</p>
                                <p>&rarr; @lang('Max. video file size is 50MB')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="hr-body-edit">
                <div class="container p-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-4 d-flex small-row">
                                <button type="submit" class="btn-customer secondary btn btn-save">
                                    @lang('Save')
                                </button>
                                <button type="reset" class="btn-customer btn-cancel btn" style="width: 86px">@lang('Cancel')</button>
                        </div>
                        <div class="row">
                            <p class="col-8">@lang('Save any changes before viewing your store')</p>
                            <div class="col-4">
                                <a class="btn-customer primary-icon btn" href="{{route('store.preview.index', $store->id)}}" role="button">
                                    <img src="{{asset('asset-seller/Img/store.svg')}}">
                                    <p>@lang('View Store')</p>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>

    <!-- Crop cover modal -->
    <div class="modal fade" id="cover-crop-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="cover-crop-zone" style="with: 100%; height: 400px"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-primary-custom btn ml-2" id="cover-crop-btn"style="width: auto">
                        <span class="lds-ring"><span></span></span>
                        Save
                    </button>
                    <button type="button" class="btn-custom btn-default-custom btn" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- #crop cover modal -->

    <!-- Crop avatar modal -->
    <div class="modal" id="avatar-crop-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="avatar-crop-zone" style="width: 100%; height: 400px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-default-custom btn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-custom btn-primary-custom btn ml-2" id="avatar-crop-btn"style="width: auto">
                        <span class="lds-ring"><span></span></span>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- #Crop avatar modal -->
@endsection

@push('scripts-2')
    <script type="text/javascript" src="{{asset('asset-common/js/croppie.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script type="text/javascript">
        $("input[name='is_cover_video']").on("click", function(){
            $('#coverImage').toggle();
            $('#coverVideo').toggle();
        });
    </script>
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
    <script type="text/javascript">
        function readFile(input, callback) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    if (typeof (callback) === 'function') {
                        callback(e.target.result);
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
            else {

            }
        }

        function openAvatarBrowseFile() {
            $('#avatar-file-input').trigger('click');
        }

        function openCoverBrowseFile() {
            $('#cover-file-input').trigger('click');
        }

        $(function () {
            var $coverCropper;
            var coverRawImage;

            $coverCropper = $('#cover-crop-zone').croppie({
                viewport: {
                    width: 869,
                    height: 360,
                },
                showZoomer: false,
                enableExif: true
            });

            $('#cover-crop-modal').on('shown.bs.modal', function(){
                $coverCropper.croppie('bind', {
                    url: coverRawImage
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            });

            $('#cover-file-input').on('change', function (e) {
                readFile(this, function (result) {
                    coverRawImage = result;
                    $('#cover-crop-modal').modal('show');
                });
            });

            $('#cover-crop-btn').click(function () {
                var $coverCropBtn = $(this);
                $coverCropBtn.addClass('loading');
                $coverCropBtn.attr('disabled', true);

                $coverCropper.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    var formData = new FormData();
                    formData.append('image', resp)

                    $.ajax({
                        url: "{{ route('seller.store.update_cover') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function (data) {
                            $('#cover-edited-image').attr('src', data.url);
                            // $('.bg-cover-seller-2').css('background-image', 'url(' + data.url + ')');
                            $('#cover-crop-modal').modal('hide');
                        }
                    })
                        .always(function () {
                            $coverCropBtn.removeClass('loading');
                            $coverCropBtn.attr('disabled', false);
                        });
                });
            });
        });

        $(function () {
            var $avatarCropper;
            var avatarRawImage;

            $avatarCropper = $('#avatar-crop-zone').croppie({
                viewport: { width: 300, height: 300 },
                boundary: { width: 320, height: 320 },
                showZoomer: true,
                enableResize: false,
                enableOrientation: true
            });

            $('#avatar-crop-modal').on('shown.bs.modal', function(){
                $avatarCropper.croppie('bind', {
                    url: avatarRawImage
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            });

            $('#avatar-file-input').on('change', function (e) {
                readFile(this, function (result) {
                    avatarRawImage = result;
                    $('#avatar-crop-modal').modal('show');
                });
            });

            $('#avatar-crop-btn').click(function () {
                var $avatarCropBtn = $(this);
                $avatarCropBtn.attr('disabled', true);
                $avatarCropBtn.addClass('loading');

                $avatarCropper.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    var formData = new FormData();
                    formData.append('image', resp);

                    $.ajax({
                        url: "{{ route('seller.store.update_avatar') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function (data) {
                            $('#avatar-edited-image').attr('src', data.url);
                            $('img.avatar-seller').attr('src', data.url);
                            $('#avatar-crop-modal').modal('hide');
                        },

                    })
                        .always(function() {
                            $avatarCropBtn.attr('disabled', false);
                            $avatarCropBtn.removeClass('loading');
                        });
                    ;
                });
            });
        });
    </script>
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
                formSt1.valid();
            }
            if(select.attr("name")=='address_province_id'){
                getCitiesOfProvince(select.val());
                //refresh district
                $('#districts').html('').selectpicker('refresh');
                // $('#cities').html('').selectpicker('refresh');
            }else if(select.attr("name")=='address_city_id'){
                getDistrictOfCity(select.val());
            }



        });
    </script>
@endpush
