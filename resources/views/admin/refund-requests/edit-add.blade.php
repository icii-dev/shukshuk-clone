@php
    $edit = !is_null($dataTypeContent->getKey());
     $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <form class="form-edit-add"
              role="form"
              action="@if(isset($dataTypeContent->id)){{ route('admin.refund.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
              method="POST"
              enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if($edit)
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Order Information</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="status">Order Id</label>
                                <input type="text" class="form-control" id="status" name="status"
                                       placeholder="Store Name"
                                       value="{{ $dataTypeContent->id ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="status">Store Name</label>
                                <input type="text" class="form-control" id="status" name="status"
                                       placeholder="Store Name"
                                       value="{{ $dataTypeContent->store->name ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Billing Total</label>
                                <input type="text" class="form-control" id="refund_status" name="refund_status"
                                       placeholder="Refund Products Price"
                                       value="{{ moneyFormat($billingTotal['total']) ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Payment Fee</label>
                                <input type="text" class="form-control" id="refund_status" name="refund_status"
                                       placeholder="Refund Products Price"
                                       value="{{ moneyFormat($billingTotal['paymentFee']) ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Shipping Fee</label>
                                <input type="text" class="form-control" id="refund_status" name="refund_status"
                                       placeholder="Refund Products Price"
                                       value="{{ moneyFormat($dataTypeContent->billing_shipping_fee) ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Insurance Fee</label>
                                <input type="text" class="form-control" id="refund_status" name="refund_status"
                                       placeholder="Refund Products Price"
                                       value="{{ moneyFormat($dataTypeContent->billing_insurance_fee) ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Refund Amount (to buyer)</label>
                                <input type="text" class="form-control" id="refund_status" name="refund_status"
                                       placeholder="Refund Products Price"
                                       value="{{ moneyFormat($refundAmount) ?? '' }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Customer Information</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="status">Customer Name</label>
                                <input type="text" class="form-control" id="status" name="status"
                                       placeholder="Name"
                                       value="{{ $dataTypeContent->billing_name ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="status">Customer Email</label>
                                <input type="text" class="form-control" id="status" name="status"
                                       placeholder="Name"
                                       value="{{ $dataTypeContent->user->email ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Customer Address</label>
                                <input type="text" class="form-control" id="refund_status" name="refund_status"
                                       placeholder="Customer Address"
                                       value="{{ $dataTypeContent->billing_address ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Customer Phone</label>
                                <input type="text" class="form-control" id="refund_status_2" name="refund_status_2"
                                       placeholder="Customer Address"
                                       value="{{ $dataTypeContent->billing_phone ?? '' }}" disabled>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Status</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="status">Order Status</label>
                                <input type="text" class="form-control" id="status" name="status"
                                       placeholder="Order Status"
                                       value="{{ $dataTypeContent->getStatusName($dataTypeContent->status)}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Payment Status</label>
                                <input type="text" class="form-control" id="payment_status" name="payment_status"
                                       placeholder="Payment Status"
                                       value="{{ $dataTypeContent->payment->status ?? '' }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Note</label>
                                <input type="text" class="form-control" id="note" name="note"
                                       placeholder="Note"
                                       value="">
                            </div>
                            <div class="form-group">
                                <label for="refund_status">Refund Status</label>
                                <select class="form-control" name="status">
                                    <option value="{{\App\Model\Order::REFUND_REJECT}}" @if(isset($dataTypeContent->refund_status) && $dataTypeContent->refund_status == 0) selected="selected"@endif>Reject</option>
                                    <option value="{{\App\Model\Order::REFUND_ACCEPT}}" @if(isset($dataTypeContent->refund_status) && $dataTypeContent->refund_status == 1) selected="selected"@endif>Accept</option>
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </div>

                </div>
            </div>
            <!-- panel-body -->


        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
              enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
            <input name="image" id="upload_file" type="file"
                   onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
            {{ csrf_field() }}
        </form>

    </div>



    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;
        function deleteHandler(tag, isMulti) {
            return function() {
                $file = $(this).siblings(tag);
                params = {
                    slug:   '{{ $dataType->slug }}',
                    filename:  $file.data('file-name'),
                    id:     $file.data('id'),
                    field:  $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '{{ csrf_token() }}'
                }
                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
            };
        }
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                }
            });
            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
            @endif
            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });
            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));
            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {
                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });
                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop