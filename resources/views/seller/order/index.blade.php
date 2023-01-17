@extends('layouts.seller')

@section('content')
    <div class="container">
        <div class="body-home-seller">
            <div class="row title-home d-flex justify-content-between">
                <h2 class="product-card-subtitle">@lang('Orders')</h2>
            </div>
            @include('seller.order._order_nav')

            <div class="tab-content">
                <div id="list-order">
                    <hr class="head">
                    @include('seller.order._list_order')
                </div>
                @if ($paged->currentPage() < $paged->lastPage())
                    <a href="javascript:void(0)" class="button load-more js-load-more-order" data-page="{{ $paged->currentPage() + 1 }}">
                        Load More
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        // moment.locale('en', {
        //     calendar : {
        //         lastDay : '[Yesterday at] LT',
        //         sameDay : '[Today at] LT',
        //         nextDay : '[Tomorrow at] LT',
        //         lastWeek : '[last] dddd [at] LT',
        //         nextWeek : 'dddd [at] LT',
        //         sameElse : 'L'
        //     }
        // });
        //
        // $(function () {
        //     moment().calendar();
        // })

        function updateSummary() {
            $.get("{!! route('seller.order.ajax_get_summary') !!}", function (data) {
                Object.keys(data).forEach(function (k) {
                    let total = data[k];
                    if(k==2){
                        total = total + data[3];
                    }
                    $('#order-status-number-' + k).text(total);
                })
            });
        }

        $(function () {
            $(document).on('click', '.viewdetails', function () {
                $(this).addClass('d-none');console.log($(this).closest('.order-item'));
                $(this).closest('.order-item').find('.close-details').parent().parent().removeClass('d-none');
            });

            $(document).on('click', '.close-details', function () {
                $(this).parent().parent().addClass('d-none');
                $(this).closest('.order-item').find('.viewdetails').removeClass('d-none');
            });

            $(document).on('click', '.js-proceed-order-by-dc', function (e) {
                e.preventDefault();
                var self = this;
                window.processCB = function () {
                    $(self).closest('.order-item').remove();
                }
            });

            $(document).on('click', '.js-change-order-to-in-process', function (e) {
                e.preventDefault();
                var self = this;
                $('.loader').show();

                var order = $(this).data('order');
                $("input[type='radio'][name='expect_time']").prop('checked', false);
                $('#orderId').html(order.id);
                JsBarcode("#barcode", order.id, {
                    height:29,
                    displayValue: true
                });
                $('#orderIdForLabel').html(order.id);
                $('#orderWeight').html(order.total_weight+'g');
                $('#orderShipFee').html('Rp.'+order.billing_shipping_fee);
                $('#orderInsuranceFee').html('Rp.'+order.billing_insurance_fee);
                $('#orderNameForLabel').html(order.billing_name);
                $('#orderPhoneForLabel').html('('+'+'+order.billing_phone+')');
                $('#orderAddressForLabel').html(order.billing_address + ', ' + order.billing_district + ', ' + order.billing_city + ', ' + order.billing_province);
                $('#orderName').html(order.billing_name);
                $('#orderAddress').html(order.billing_address + ', ' + order.billing_district + ', ' + order.billing_city + ', ' + order.billing_province);
                $('#orderPhone').html('('+'+'+order.billing_phone+')');
                $('#btnProceedOrder').data('url', $(this).data('url'));

                window.processCB = function () {
                    $(self).closest('.order-item').remove();
                }
            });

            $(document).on('click', '#btnProceedOrder', function (e) {
                e.preventDefault();
                var time = $("input[name='expect_time']:checked").val();
                if (!time){
                    bootoast.toast({
                        message: "Please select Pick-Up Time!",
                        type: 'danger',
                        position: 'rightBottom',
                    });
                }else{
                    startLoading();
                    $.post($(this).data('url'), {expect_time : time}, function (data) {

                        console.log(data);
                        if (data.error) {
                            bootoast.toast({
                                message: data.error.message,
                                type: 'danger',
                                position: 'rightBottom'
                            });
                        } else {
                            updateSummary();
                            if (typeof window.processCB == 'function') {
                                window.processCB();
                                window.processCB = null;
                            }

                            bootoast.toast({
                                message: 'The order has been updated to in process',
                                type: 'success',
                                position: 'rightBottom',
                            });
                            $("#modalProceed .close").click();
                        }

                    }).fail(function(xhr, status, error) {
                        console.log(xhr.responseJSON.message);
                        bootoast.toast({
                            message: xhr.responseJSON.message,
                            type: 'danger',
                            position: 'rightBottom',
                        });
                    }).always(function () {
                        stopLoading();
                    });

                }

            });

            $(document).on('click', '.js-change-order-to-cancelled', function (e) {
                e.preventDefault();
                var self = this;
                startLoading();

                $.post($(this).data('url'), {id: $(this).data('id')}, function (data) {
                    if (data.error) {
                        bootoast.toast({
                            message: data.error.message,
                            type: 'danger',
                            position:'rightBottom'
                        });
                    } else {
                        updateSummary();
                        $(self).closest('.order-item').remove();
                        bootoast.toast({
                            message: 'The order has been updated to cancelled',
                            type: 'success',
                            position: 'rightBottom'
                        });
                    }
                }).always(function () {
                    stopLoading();
                });
            });

            $('#modalDC').on('show.bs.modal', function (event) {
                var url = $(event.relatedTarget).data('url')
                $('#btnProceedByDC').data('url', url);
            })

            $(document).on('click', '#btnProceedByDC', function (e) {
                e.preventDefault();
                startLoading();
                $.ajax({
                    type: "GET",
                    url: $(this).data('url'),
                    dataType: "json",
                    success: function(data){
                        updateSummary();
                        if (typeof window.processCB == 'function') {
                            window.processCB();
                            window.processCB = null;
                        }
                       console.log(data)
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        stopLoading();
                        var responseText = JSON.parse(XMLHttpRequest.responseText);
                        console.log(responseText);
                        bootoast.toast({
                            message: responseText.error.message,
                            type: 'danger',
                            position: 'rightBottom'
                        });
                    }
                }).always(function() { //use this
                    stopLoading();
                });
            });

            // Load more
            $('.js-load-more-order').click(function (e) {
                e.preventDefault();
                var self = this;

                if ($(self).hasClass('loading')) {
                    return;
                }

                $(self).addClass('loading');
                $('.loader').show();

                $.get("{!! url()->current() !!}", $(this).data(), function (data) {
                    $('#list-order').append(data.html_data);

                    if (data.is_next_page) {
                        $(self).data('page', parseInt(data.current_page) + 1);
                    } else {
                        $(self).remove();
                    }
                }).always(function () {
                    $(self).removeClass('loading');
                    $('.loader').hide();
                });
            });
        });

        $(function () {
            var url = window.location.pathname,
                urlRegExp = new RegExp(url.replace(/\/$/,'') + "$");

            $('.tab-orders a').each(function(){
                // and test its normalized href against the url pathname regexp
                if(urlRegExp.test(this.href.replace(/\/$/,''))){
                    $(this).parent().addClass('active');
                }
            });
        });
    </script>
    <script>
        $('#modalShipLabel').modal('hide');
        $(document.body).removeClass("modal-open");
        $(".modal-backdrop show").remove();
    </script>
@endsection