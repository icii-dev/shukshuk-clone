<style>
    .form-group{
        margin-top: 16px;
        margin-bottom: 32px;
    }
    .form-group label {
         margin-bottom: 0px;
    }
    .bank-info{
        margin-left: 16px;
    }
</style>
<!-- Withdraw Modal -->
<div class="modal" id="withdrawModal">
    <div class="modal-dialog" style="max-width: 480px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title color-black">@lang('Withdraw Money')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form class="modal-body" id="withDrawForm">
                <div class="form-group" style="margin-top: 0px">
                     <span>@lang('withdraw description pop-up')
                    </span>
                </div>

                <div id="withdrawStep1">
                    <div class="form-group">
                        <label>@lang('Balance') {{env('APP_CURRENCY', 'IDR')}}
                            {{getStoreBalance($store)}}
                        </label>
                    </div>
                    <div class="form-group">
                        <label>@lang('Withdraw Amount')</label>
                        <input class="form-control" name="amount">
                    </div>
                    <div class="form-group">
                        <label>@lang('Select Account Destination')</label>
                        @foreach($store->banks as $bank)
                        <div class="card-body row" onclick="selectBank({{$bank->id}})">
                            <div class="radio-style">
                                <input type="radio" name="bank_id" value="{{$bank->id}}">
                                <span class="checkmark"></span>
                            </div>
                            <div class="bank-info">
                                <div class="uppercase">{{$bank->name}}</div>
                                <label>Account Number: {{$bank->account_number}}</label>
                                <br>
                                <label>Account Name: {{$bank->account_holder_name}}</label>
                            </div>
                        </div>
                        @endforeach

                        <div class="card-body row">
                            <img src="{{asset('asset-seller/Img/mdi_add_circle_green.svg')}}">
                            <a href="{{route('seller.payment.banks')}}" style="margin-left: 8px">Add Bank Account</a>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center" style="padding-top: 0px">
                        <button type="button" class="col-6 btn" data-dismiss="modal">Cancel</button>
                        <button type="button" class="col-6 btn secondary" onclick="withdraw()">Withdraw</button>
                    </div>

                </div>
            </form>


        </div>
    </div>
</div>
