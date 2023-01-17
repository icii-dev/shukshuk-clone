@extends('layouts.seller')

@section('content')
    <div id="mySidepanel" class="sidepanel">
        <div class="body-sidepanel">
            <div class="row wrap-body">
                <div class="col-10 col-sidepanel">
                    <div class="sp-loin">
                        <div class="container">
                            <div class="wrap-login-mobi d-none">
                                <div class="title-login d-flex justify-content-center">
                                    <p>Don’t have account?</p>
                                    <a href="#">Register Now</a>
                                </div>
                                <a class="btn-customer secondary btn col-12 btn-login-mobi" href="#"
                                   role="button">Login</a>
                                <p class="text-center or-with">or login with</p>
                                <div class="row face-google">
                                    <div class="col-6"><a href="#"><img class="w-100 d-block" src="{{ asset('asset-seller/Img/FB-Sign-In.svg') }}"
                                                                        alt=""></a></div>
                                    <div class="col-6"><a href="#"><img class="d-block w-100"
                                                                        src="{{ asset('asset-seller/Img/Google-Sign-In.svg') }}" alt=""></a></div>
                                </div>
                            </div>
                            <div class="account-mobi">
                                <div class="avatar text-center">
                                    <img src="{{ asset('asset-seller/Img/avatar-1.png') }}" alt="">
                                    <h3>Boby Haryanto</h3>
                                    <a href="#">Register As Seller -&gt;</a>
                                    <p class="color-red log-out-mobi">Log Out</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile">
                        <div class="account">
                            <a href="#">
                                <div class="d-flex order">
                                    <p>@lang('Manage Store')</p>
                                </div>
                            </a>
                        </div>
                        <div class="account">
                            <a href="#">
                                <div class="d-flex order">
                                    <p>Orders</p>
                                </div>
                            </a>
                        </div>
                        <div class="account">
                            <a href="#">
                                <div class="d-flex order">
                                    <p>Messages</p>
                                </div>
                            </a>
                        </div>
                        <div class="account">
                            <a href="#">
                                <div class="d-flex order">
                                    <p>Notification</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="footer-sidepannel">
                        <p>About Us</p>
                        <p>Help Center</p>
                        <div class="logo-footer sp d-flex">
                            <img src="{{ asset('asset-seller/Img/logo-light.svg') }}" alt="">
                            <p>PT. Shukshuk Indonesia</p>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="wrap-close h-100 w-100 m-auto" onclick="closeNav()">
                        <a href="javascript:void(0)" class="closebtn d-block" onclick="closeNav()"><img
                                    class="w-100 d-block" src="{{ asset('asset-seller/Img/X.svg') }}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content content-seller">
        <div class="container">
            <div>
                <ul class="nav step d-flex justify-content-center">
                    <li id="li-step-1" class="detail-step d-flex detail-step-w20 step-active-color">
                        <a id="item-step-1" class="item-step active nav-link d-flex" data-toggle="tab" href="#tab-1">
                            <span class="d-block rounded-circle number">1</span>
                            <span class="text">@lang('Delivery Information')</span>
                        </a>
                    </li>
                    <li id="li-step-2" data-toggle="tab" class="detail-step d-flex detail-step-w20">
                        <a id="item-step-2" class="nav-link d-flex" href="#tab-2">
                            <span class="d-block rounded-circle number">2</span>
                            <span class="text">Payment Method</span>
                        </a>
                    </li>
                    <li id="li-step-3" class="detail-step d-flex">
                        <a id="item-step-3" class="nav-link d-flex" href="#tab-3">
                            <span class="d-block rounded-circle number">3</span>
                            <span class="text">Complete Order</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="container">
                        <div class="body-seller-refistration">
                            <div class="seller-information">
                                <h2>Seller Information</h2>
                                <p class="about-seller d-block">Let’s start by completing your profile</p>
                            </div>
                            <div class="col-5 sl-regis-information  max-w-400">
                                <form id="form-step-1">
                                    <div class="group">
                                        <div class="row">
                                            <div class="col-6 form-group">
                                                <label class="gray-name">First Name *</label>
                                                <input id="firstname" name="first_name" type="text" class="form-control"
                                                       placeholder="First Name" required>
                                            </div>
                                            <div class="col-6 form-group">
                                                <label class="gray-name">Last Name *</label>
                                                <input id="lastname" name="last_name" type="text" class="form-control"
                                                       placeholder="Last Name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">Email Address *</label>
                                        <input id="email" name="email" type="text" class="form-control"
                                               placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="color-gray">Date of Birth</label>
                                        <input name="date" id="datepicker" lass="form-control" placeholder="DD-MM-YY"/>
                                    </div>
                                    <div class="form-group">
                                        <div class="note form-group profile-name">
                                            <label class="color-gray">Phone Number</label>
                                            <div class="btn-group phone">
                                                <div class="wrap-select wrap-flag col-2">
                                                    <select class="selectpicker">
                                                        <option data-content='<span class="flag-icon flag-icon-id"></span>'></option>
                                                        <option data-content='<span class="flag-icon flag-icon-vn"></span>'></option>
                                                    </select>
                                                    <img class="img-select web-block" src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                                </div>
                                                <input id="phone" name="phone" type="text" class="form-control"
                                                       placeholder="Your Phone Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name" for="nationality_id">Country of Citizenship *</label>
                                        <select name="nationality_id" class="form-control" required>
                                            <option value="1">Vietnam</option>
                                            <option value="2">Indonesia</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name" for="residence_id">Country of Residence *</label>
                                        <select class="form-control" name="residence_id" required>
                                            <option value="1">Vietnam</option>
                                            <option value="2">Indonesia</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">ID Number *</label>
                                        <input name="id_number" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="color-gray mt-16px">Proof of ID</label>
                                        <div class="detail-form wrap-update-img">
                                            <p>Upload ID Photo</p>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input
                                                            type="file"
                                                            name="proof_image_upload"
                                                            class="custom-file-input update-img"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-5 col-sm-12 max-w-400">
                                    <div class="row">
                                        <div class="col-6"><p class="pt-3">Step 1 of 3</p></div>
                                        <div class="col-6">
                                            <ul class="nav">
                                                <li>
                                                    <a id="btn-step1" class="btn-customer secondary btn" href="#tab-2"
                                                       data-toggle="tab">Continue</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- submit button holder -->
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="container">
                        <div class="body-seller-refistration">
                            <div class="seller-information">
                                <h2>Store Information</h2>
                                <p class="about-seller d-block">Sed sodales risus sed fermentum, vitae et ipsum purus
                                    laoreet. Proin laoreet velit risus tellus. Eget eget ante turpis etiam malesuada
                                    ultrices. In maecenas est justo in sollicitudin.</p>
                            </div>
                            <div class="col-5 sl-regis-information  max-w-400">
                                <form id="form-step-2">
                                    <div class="form-group">
                                        <label class="gray-name">Type of Seller (Individual/NGO/Company)</label>
                                        <div class="wrap-select">
                                            <select class="selectpicker" title="Country">
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select>
                                            <img class="img-select" src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">Proof of NGO/Company seller only</label>
                                        <div class="detail-form wrap-update-img update-photo">
                                            <p>Upload ID Photo</p>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input update-img" value="Update">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">Type of Industry</label>
                                        <div class="wrap-select">
                                            <select class="selectpicker" title="Country">
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select>
                                            <img class="img-select" src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">Product Category Type</label>
                                        <div class="wrap-select">
                                            <select class="selectpicker" title="Country">
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select>
                                            <img class="img-select" src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">Store Name *</label>
                                        <input id="storename" name="storename" type="text" class="form-control"
                                               placeholder="Type your store name" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">Store Description</label>
                                        <textarea id="address" name="address" class="form-control"
                                                  placeholder="Type your store description (Keep it short and obvious)"
                                                  rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">Store Profile Photo</label>
                                        <div class="detail-form wrap-update-img">
                                            <p>Upload Store Profile Picture</p>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input update-img"
                                                           value="Update">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-5 col-sm-12  max-w-400">
                                    <div class="row">
                                        <div class="col-6"><p class="pt-3">Step 2 of 3</p></div>
                                        <div class="col-6">
                                            <ul class="nav">
                                                <li>
                                                    <a id="btn-step2" data-toggle="tab"
                                                       class="btn-customer secondary btn" href="#tab-3">Continue</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review">
                                <ul class="nav">
                                    <li>
                                        <a id="review-step-1" href="#tab-1" data-toggle="tab"><- Previous Step</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane">
                    <div class="container">
                        <div class="body-seller-refistration">
                            <div class="seller-information">
                                <h2>Finishing Your Registration</h2>
                                <p class="about-seller d-block">Sed sodales risus sed fermentum, vitae et ipsum purus
                                    laoreet. Proin laoreet velit risus tellus. Eget eget ante turpis etiam malesuada
                                    ultrices. In maecenas est justo in sollicitudin.</p>
                            </div>
                            <form>
                                <div class="col-5 sl-regis-information max-w-400">
                                    <div class="detail-checkbox form-group">
                                        <label class="color-gray">Preferred Payment Method</label>
                                        <div class="wrap-check">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-label"></span>
                                                <span class="custom-text">Bank Transfer (Virtual Account)</span>
                                            </label>
                                        </div>
                                        <div class="wrap-check">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-label"></span>
                                                <span class="custom-text">Credit Card (Visa, MasterCard)</span>
                                            </label>
                                        </div>
                                        <div class="wrap-check">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-label"></span>
                                                <span class="custom-text">E-Wallet (OVO)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="gray-name">Preferred Delivery Method</label>
                                        <div class="wrap-select">
                                            <select class="selectpicker" title="Select Duration">
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select>
                                            <img class="img-select" src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <p class="color-red">We recommend you to use Shukshuk Delivery. We’re not
                                        responsible to guarantee the product shipping if you’re using self-delivery.</p>
                                </div>
                            </form>
                            <hr>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-5 col-sm-12 max-w-400">
                                    <div class="row">
                                        <div class="col-6"><p class="pt-3">Step 3 of 3</p></div>
                                        <div class="col-6"><a id="btn-step3" class="btn-customer secondary btn"
                                                              href="#">Continue</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="review">
                                <ul class="nav">
                                    <li>
                                        <a id="review-step-2" href="#tab-2" data-toggle="tab"><- Previous Step</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4'
            });
        })
    </script>
    <script>
        $(function() {

            $(document).ready(function() {
                $('#form-step-1').validate({
                    rules: {
                        firstname: "required",
                        lastname: "required",
                        email: "required",
                        phone: "required",
                        contry: "required",
                        contry_1: "required",
                        contry_2: "required",
                    },
                    messages: {
                        firstname: "Cannot be empty",
                        lastname: "Cannot be empty",
                        email: "Cannot be empty",
                        phone: "Cannot be empty",
                        contry: "Cannot be empty",
                        contry_1: "Cannot be empty",
                        contry_2: "Cannot be empty",
                    }
                });
                $('#form-step-2').validate({
                    rules: {
                        storename: "required",
                        address: "required",
                    },
                    messages: {
                        storename: "Cannot be empty",
                        address: "Cannot be empty",
                    }
                });
            });
            $('#btn-step1').click(function() {
                $("#form-step-1").valid(); //validate form 1
            });
            $('#btn-step2').click(function() {
                $("#form-step-2").valid(); //validate form 2
            });
            $('#btn-step1,#li-step-2 a').click(function(e) {
                if($("#form-step-1").valid()){
                    $('.wrap-flag button').css("border","1px solid #ced4da");
                    $('#item-step-2').addClass('active');
                    $('#review-step-2').addClass('active');
                    $('#item-step-1,#item-step-3').removeClass('active');
                    $('#tab-1,#tab-3').removeClass('active');
                    $('#tab-2').addClass('active');
                    $("#tab-2").attr("aria-expanded","true");
                    $("#tab-1,#tab-3").attr("aria-expanded","flase");
                    $('#review-step-1').removeClass('active');

                }
                else{
                    $('.wrap-flag button').css("border","1px solid #EB4242");
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
            $('#btn-step2,#li-step-3 a').click(function(e) {
                if($("#form-step-2").valid()){
                    $('#item-step-3').addClass('active');
                    $('#item-step-1,#item-step-2').removeClass('active');
                    $('#tab-1,#tab-2').removeClass('active');
                    $('#tab-3').addClass('active');
                    $("#tab-3").attr("aria-expanded","true");
                    $("#tab-1,#tab-2").attr("aria-expanded","flase");
                    $('#review-step-1').removeClass('active');
                    $('#review-step-1').removeClass('active');
                }
                else{
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
            $('#li-step-1,#review-step-1').click(function () {
                $('#item-step-1').addClass('active');
                $('#review-step-1').addClass('active');
                $('#item-step-3,#item-step-2').removeClass('active');
                $('#tab-3,#tab-2').removeClass('active');
                $('#tab-1').addClass('active');
                $("#tab-1").attr("aria-expanded","true");
                $("#tab-2,#tab-3").attr("aria-expanded","flase");
                $('#review-step-1').removeClass('active');
            })
            $('#review-step-2').click(function () {
                $('#item-step-2').addClass('active');
                $('#review-step-2').addClass('active');
                $('#item-step-3,#item-step-1').removeClass('active');
                $('#tab-3,#tab-1').removeClass('active');
                $('#tab-2').addClass('active');
                $("#tab-2").attr("aria-expanded","true");
                $("#tab-1,#tab-3").attr("aria-expanded","flase");
                $('#review-step-1').removeClass('active');
                $('#review-step-2').removeClass('active');
            })
        });
    </script>
@endsection