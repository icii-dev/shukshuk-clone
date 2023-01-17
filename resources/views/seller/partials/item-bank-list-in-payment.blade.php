@php
    $store = auth()->user()->store;
    $banks = $store->banks;
@endphp
<div class="body">
    @if ($banks->count() > 0)
        @foreach($banks as $bank)
        <div class="row">
            <div class="col-1 stt text-center">{{$loop->iteration}}</div>
{{--            <div class="col-2">{{$bank->bank_code}}</div>--}}
            <div class="col-3">{{$bank->name}}</div>
            <div class="col-2">{{$bank->account_holder_name}}</div>
            <div class="col-2">{{$bank->account_number}}</div>
            <div class="col">
                <a href="#" onclick="loadModalEdit({{$bank->id}})">
                    Edit
                </a>
                <a style="color: #EB4242; margin-left: 12px" href="#" onclick="loadModalDelete({{$bank->id}})">
                    Delete
                </a>
            </div>
        </div>
        <hr>
        @endforeach
    @else
        <p class="body-seller-home-empty text-center">@lang('Adding your banks!')</p>
    @endif
</div>

<div class="modal" id="editBankModal">
    <div class="modal-dialog" style="max-width: 480px">
        <div class="modal-content" style="padding: 16px">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title color-black">@lang('Add Bank Account')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form class="modal-body" id="editBankForm">
                <div class="form-group" style="margin-top: 0px">
                     <span>@lang('You can use this bank account to withdraw your money')
                    </span>
                </div>
                <div class="form-group">
                    <label>@lang('Select Bank')</label>
                    <div class="wrap-select">
                        <select id="edit_bank_code" class="selectpicker form-control" name="bank_code"
                                onchange="document.getElementById('edit_bank_name').value=this.options[this.selectedIndex].text">
                            <option value="" selected disabled>@lang('Select Bank')</option>
                        </select>
                        <img class="img-select"
                             src="{{ asset('asset-seller/Img/arrow-black.svg') }}" alt="">
                    </div>
                </div>
                <input type="hidden" name="name" id="edit_bank_name" value="" />
                <input type="hidden" name="id" id="edit_bank_id" value="" />
                <div class="form-group">
                    <label>@lang('Account Name')</label>
                    <input class="form-control" name="account_holder_name" id="edit_account_holder_name">
                </div>
                <div class="">
                    <label>@lang('Account No.')</label>
                    <input class="form-control" name="account_number" id="edit_account_number">
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn col-3" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn secondary col-3" onclick="updateBank()">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="deleteBankModal">
    <div class="modal-dialog" style="max-width: 480px">
        <div class="modal-content" style="padding: 16px">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title color-black">@lang('Delete Bank Account')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form class="modal-body" id="editBankForm">
                <div class="form-group" style="margin-top: 0px">
                     <span>@lang('Are you sure want to delete your bank account? You will need at least 1 bank account to withdraw your money.')
                    </span>
                </div>
                <input type="hidden" name="id" id="delete_bank_id" value="" />
            </form>
            <div class="modal-footer">
                <button type="button" class="btn col-3" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn bg-red col-3" onclick="deleteBank()">Delete</button>
            </div>
        </div>
    </div>
</div>


@push('scripts-2')
    <script>
        function loadModalEdit(bankId){
            event.preventDefault();
            startLoading();
            $.get("banks/"+bankId, function (data) {
                var bank = data.data.bank;
                var listBank = data.data.listBank;
                $("#edit_bank_code option").remove();
                $("#edit_bank_code").append('<option value="" selected disabled>@lang('Select Bank')</option>')
                $.each(listBank, function (key, value){
                    var code = value.code;
                    var name = value.name;
                    $("#edit_bank_code").append('<option class="bank-code-options" data-content="'+name+'" value="'+code+'">'+name+'</option>');
                });
                $("#edit_bank_code").selectpicker("refresh");

                $('#edit_bank_name').val(bank.name);
                $('#edit_bank_id').val(bank.id);
                $('#edit_account_holder_name').val(bank.account_holder_name);
                $('#edit_account_number').val(bank.account_number);
                $('#editBankModal').modal();
                $('#edit_bank_code').val(bank.bank_code);
                $('#edit_bank_code').selectpicker("refresh");
            }).always(function() { //use this
                stopLoading();
            });
        }

        function updateBank(){
            startLoading();
            var id = $('#edit_bank_id').val();
            $.ajax({
                url: 'banks/' + id,
                type: 'PATCH',
                data: $('#editBankForm').serialize(),
                success: function(res) {
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

        function loadModalDelete(bankId){
            $("#delete_bank_id").val(bankId);
            $("#deleteBankModal").modal();
        }

        function deleteBank(){
            var deleteBankId = $("#delete_bank_id").val();
            $.ajax(
                {
                    url: "banks/" + deleteBankId,
                    type: 'DELETE',
                    success: function (response){
                        window.location.reload();
                    }
                });
        }
    </script>
@endpush