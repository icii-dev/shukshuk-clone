@push('stylesheets')
    <style>
        div.dropdown-menu.open { width: 100%; } ul.dropdown-menu.inner>li>a { white-space: initial; }
    </style>
@endpush
<div style="margin-bottom: 24px">@lang('You can use this bank account to withdraw your money:')</div>

<div class="sroll-bar">
    <div class="table table-home-seller">
        <div class="head">
            <div class="row detail-home color-gray">
                <div class="col-1 text-center">No.</div>
{{--                <div class="col-2">@lang('Bank Code')</div>--}}
                <div class="col-3">@lang('Bank Name')</div>
                <div class="col-2">@lang('Account Name')</div>
                <div class="col-2">@lang('Account No.')</div>
                <div class="col">@lang('Action')</div>
            </div>
        </div>
        <hr>
        @include('seller.partials.item-bank-list-in-payment')
    </div>
    <div>
        <a class="btn-customer secondary btn" style="margin-top: 16px;border-radius: 8px; width: 154px"
           href="#"
           data-toggle="modal" data-target="#addBankModal"
           onclick="getAvailableBank();"
        >
            @lang('Add Bank Account')
        </a></div>
</div>
<!-- Add Bank Modal -->
<div class="modal" id="addBankModal">
    <div class="modal-dialog" style="max-width: 480px">
        <div class="modal-content" style="padding: 16px">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title color-black">@lang('Add Bank Account')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form class="modal-body" id="saveBankForm">
                <div class="form-group" style="margin-top: 0px">
                     <span>@lang('You can use this bank account to withdraw your money')
                    </span>
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
                    <input class="form-control" name="account_holder_name" id="account_holder_name">
                </div>
                <div class="">
                    <label>@lang('Account No.')</label>
                    <input class="form-control" name="account_number" id="account_number">
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn col-3" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn secondary col-3" onclick="saveBank()">Add</button>
            </div>
        </div>
    </div>
</div>

@push('scripts-2')
<script>
    function getAvailableBank() {
        startLoading();
        $.ajax({
            url: "{{route('seller.disbursement.getBanks')}}",
            dataType: "json",
            success: function(data){
                stopLoading();
                setListBank(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        }).always(function() { //use this
            stopLoading();
        });
    }

    function setListBank(data){
        $("#bank_code option").remove();
        $("#bank_code").append('<option value="" selected disabled>@lang('Select Bank')</option>')
        $.each(data, function (key, value){
            var code = value.code;
            var name = value.name;
            $("#bank_code").append('<option class="bank-code-options" data-content="'+name+'" value="'+code+'">'+name+'</option>');
        });
        $("#bank_code").selectpicker("refresh");
    }

    function saveBank(){
        startLoading();
        $.ajax({
            type: "POST",
            url: "{{route('seller.payment.banks.store')}}",
            data: $('#saveBankForm').serialize(),
            dataType: "json",
            success: function(data){
                window.location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                var responseText = JSON.parse(XMLHttpRequest.responseText);
                var errors = responseText.errors;
                $.each( errors, function( key, value ) {
                    bootoast.toast({
                        message: value,
                        type: 'danger',
                        position: 'rightBottom'
                    });
                });
            },
            complete: function (){
                stopLoading();
            }
        });
    }
</script>
@endpush