@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .process-step .btn:focus{outline:none}
        .process{display:table;width:100%;position:relative}
        .process-row{display:table-row}
        .process-step button[disabled]{opacity:1 !important;filter: alpha(opacity=100) !important}
        .process-row:before{top:30px;bottom:0;position:absolute;content:" ";width:100%;height:1px;background-color:#ccc;z-order:0}
        .process-step{display:table-cell;text-align:center;position:relative}
        .process-step p{margin-top:4px}
        .btn-circle{width:60px;height:60px;text-align:center;font-size:12px;border-radius:50%}
        .voyager .nav-tabs, .voyager .nav-tabs>li>a:hover {
            background-color: #fff;
        }
    </style>
@stop

@section('page_title', 'Store review')

@section('page_header')
    <h1 class="page-title">
        Store Review
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">

        <div class="row">
            <div class="col-md-8">

                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="process">
                            <div class="process-row nav nav-tabs">
                                <div class="process-step">
                                    <button type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#menu1"><i class="fa fa-info fa-2x"></i></button>
                                    <p><small>Seller<br />information</small></p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu2"><i class="fa fa-file-text-o fa-2x"></i></button>
                                    <p><small>Store<br />information</small></p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu3"><i class="fa fa-check fa-2x"></i></button>
                                    <p><small>Payment<br />& Delivery</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="seller-information">
                                <h2>Store Information</h2>
                                <p class="about-seller d-block">Admin checks shop information correctly before accepting.</p>
                            </div>
                            <div id="menu1" class="tab-pane fade active in">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="gray-name">First Name *</label>
                                        <input id="firstname" name="first_name" type="text" class="form-control"
                                               placeholder="{{$seller->first_name}}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="gray-name">Last Name *</label>
                                        <input id="lastname" name="last_name" type="text" class="form-control"
                                               placeholder="{{$seller->last_name}}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="gray-name">Email Address *</label>
                                        <input id="email" name="email" type="text" class="form-control"
                                               placeholder="{{$seller->email}}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="color-gray">Date of Birth</label>
                                        <input name="date" id="datepicker" class="form-control" placeholder="@if($seller->dob) {{ date_format($seller->dob, 'd/m/yy')}} @endif" disabled/>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="color-gray">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            <input id="phone" type="text" class="form-control" name="phone" placeholder="{{$seller->phone}}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="gray-name" for="nationality_id">Country of Citizenship *</label>
                                        <select name="nationality_id" class="form-control" disabled>
                                            <option value="1" @if($seller->nationality_id == '1') selected @endif>Vietnam</option>
                                            <option value="2" @if($seller->nationality_id == '2') selected @endif>Indonesia</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="gray-name" for="residence_id">Country of Residence *</label>
                                        <select class="form-control" name="residence_id" disabled>
                                            <option value="1" @if($seller->nationality_id == '1') selected @endif>Vietnam</option>
                                            <option value="2" @if($seller->nationality_id == '2') selected @endif>Indonesia</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="color-gray mt-16px">Proof of ID</label>
                                        <div class="detail-form wrap-update-img">
                                            <img class="img-responsive" src="{{displaySellerImage($seller->proof_image)}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-offset-2 col-md-6">
                                        <label class="gray-name">ID Number *</label>
                                        <input name="id_number" type="text" class="form-control" placeholder="{{$seller->id_number}}" disabled>
                                    </div>
                                </div>
                                <hr>
                                <ul class="list-unstyled list-inline pull-right">
                                    <li><button type="button" class="btn btn-info next-step">Next <i class="fa fa-chevron-right"></i></button></li>
                                </ul>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="gray-name">Type of Seller (Individual/NGO/Company)</label>
                                                <select class="form-control" name="type" title="Select type of seller" disabled>
                                                    @foreach(getListStoreType() as $typeId => $typeName)
                                                        @php
                                                            $selected = old('type', $store ? $store->type : '') === $typeId;
                                                        @endphp
                                                        <option value="{{ $typeId }}" {{ $selected ? 'selected' : '' }}>{{ $typeName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="gray-name">Type of Industry</label>
                                                <input type="text" class="form-control"
                                                       placeholder="{{Arr::get($store, 'industry.name')}}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="gray-name">Product Category Type</label>
                                                <input type="text" class="form-control"
                                                       placeholder="{{$store->categories['name']}}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="gray-name">Store Name *</label>
                                                <input type="text" class="form-control"
                                                       placeholder="{{$store->name}}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="gray-name">Store Description </label>
                                                <textarea id="address" name="address" class="form-control"
                                                          placeholder="Type your store description (Keep it short and obvious)"
                                                          rows="5" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{--                                    end content 1--}}
                                    <div class="col-md-6 col-md-offset-1">
                                        <div class="row">
                                            @if($store->type != \App\Model\Store::TYPE_INDIVIDUAL)
                                            <div class="form-group">
                                                <label class="gray-name">Proof of NGO/Company seller only</label>
                                                @foreach($store->proof_images as $proofImage)
                                                <div class="detail-form wrap-update-img update-photo">
                                                    <img class="img-responsive" src="{{getStoreProofImageUrl($proofImage)}}">
                                                </div>
                                                    @endforeach
                                            </div>
                                            @endif
                                            <br>
                                            <div class="form-group">
                                                <label class="gray-name">Store Profile Photo</label>
                                                <div class="detail-form wrap-update-img">
                                                    <img class="img-responsive" src="{{getStoreAvatarUrl($store->avatar_image)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
{{--                                    end content 2--}}
                                </div>
                                <ul class="list-unstyled list-inline pull-right">
                                    <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
                                    <li><button type="button" class="btn btn-info next-step">Next <i class="fa fa-chevron-right"></i></button></li>
                                </ul>
                            </div>
                            <div id="menu3" class="tab-pane fade">
                                <div class="row">
                                    <div class="detail-checkbox form-group col-md-12">
                                        <label class="color-gray">Preferred Payment Method</label>
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
                                            <div class="wrap-check">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="payment_method_ids[]"
                                                           value="{{ $paymentMethodId }}"
                                                           class="custom-control-input"
                                                            {{ $checked ? 'checked' : '' }}
                                                    disabled>
                                                    <span class="custom-control-label"></span>
                                                    <span class="custom-text">{{ $paymentMethodName }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                        <div class="error-message-holder"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="gray-name">Preferred Delivery Method</label>
                                        <div class="wrap-select">
                                            <select class="form-control" name="delivery_unit_id"
                                                    title="Select Delivery Method" disabled>
                                                @foreach(getListDeliveryUnit() as $deliveryUnitId => $deliveryUnitName)
                                                    @php
                                                        $selected = old('delivery_unit_id', $store ? $store->delivery_unit_id : '') === $deliveryUnitId;
                                                    @endphp
                                                    <option value="{{ $deliveryUnitId }}" {{ $selected ? 'selected' : '' }}>{{ $deliveryUnitName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-unstyled list-inline pull-right">
                                    <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
                                    <li><button type="button" class="btn btn-info next-step">Next <i class="fa fa-chevron-right"></i></button></li>
                                </ul>
                            </div>
                            <div id="menu4" class="tab-pane fade">
                                <h3>Menu 4</h3>
                                <p>Some content in menu 4.</p>
                                <ul class="list-unstyled list-inline pull-right">
                                    <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
                                    <li><button type="button" class="btn btn-info next-step">Next <i class="fa fa-chevron-right"></i></button></li>
                                </ul>
                            </div>
                            <div id="menu5" class="tab-pane fade">
                                <h3>Menu 5</h3>
                                <p>Some content in menu 5.</p>
                                <ul class="list-unstyled list-inline pull-right">
                                    <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
                                    <li><button type="button" class="btn btn-success"><i class="fa fa-check"></i> Done!</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="panel panel-bordered">
                    <div class="panel-heading" style="padding: 0px 20px">
                        <h3><b>Action</b></h3>
                        <h4>Current state: {!! stringStatusOfStore($store->status) !!}</h4>
                    </div>
                    <div class="panel-body">
                        <div>
                            <p>Please censor the information carefully...</p>
                        </div>
                        <div class="form-group text-center">
                            <form class="modal-content" action="{{route('admin.stores.approval', $store->id)}}" method="POST" enctype="multipart/form-data">
                               @csrf
                                <input type="hidden" name="status" value="{{\App\Model\Store::STATUS_ACTIVE}}">
                            <button dusk="btn-accept" type="submit" class="btn btn-info col-md-5">Accept</button>
                            </form>
                            <a class="btn btn-warning col-md-5 col-md-offset-2" data-toggle="modal" data-target="#reject_store">Reject</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-warning" id="reject_store">
        <div class="modal-dialog">
            <form class="modal-content" action="{{route('admin.stores.approval', $store->id)}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <h4>Reason for the rejection</h4>
                        <select class="form-control" name="code_reason">
                            <option>{{trans('reject.sell_incorrect')}}</option>
                            <option>{{trans('reject.store_incorrect')}}</option>
                            <option value="0">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control hidden" placeholder="Enter the reason for the reject"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="status" value="{{\App\Model\Store::STATUS_DEACTIVE}}">
{{--                        <input type="hidden" name="status">--}}
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="submit" class="btn btn-warning" id="confirm_delete">Yes, Reject it!</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End REject File Modal -->

@stop



@section('javascript')
{{--    display error toast--}}
    <script>
        @if(Session::has('errors'))
            @foreach ($errors->all() as $error)
            let alert = "{{$error}}";
            toastr.error(alert);
            @endforeach
        @endif
    </script>
    <script>
        $(function () {
            $('select[name="code_reason"]').on('change', function(){
                if($(this).val()==0){$('textarea[name="message"]').removeClass('hidden').add('required')}
                else{if(!$('textarea[name="message"]').hasClass('hidden')){$('textarea[name="message"]').addClass('hidden')}}
            });

            
        });
    </script>
<script>
    $(function() {
        $('#confirm_delete').on('click', function () {
            $('#reject_store').hide();
        });
        $('.btn-circle').on('click', function () {
            $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
            $(this).addClass('btn-info').removeClass('btn-default').blur();
        });

        $('.next-step, .prev-step').on('click', function (e) {
            var $activeTab = $('.tab-pane.active');

            $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

            if ($(e.target).hasClass('next-step')) {
                var nextTab = $activeTab.next('.tab-pane').attr('id');
                $('[href="#' + nextTab + '"]').addClass('btn-info').removeClass('btn-default');
                $('[href="#' + nextTab + '"]').tab('show');
            } else {
                var prevTab = $activeTab.prev('.tab-pane').attr('id');
                $('[href="#' + prevTab + '"]').addClass('btn-info').removeClass('btn-default');
                $('[href="#' + prevTab + '"]').tab('show');
            }
        });
    });
</script>
@stop


