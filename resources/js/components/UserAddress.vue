<template>
    <div>
        <div class="card mt-16px address-list" style="border: none;border-radius: 8px;">

            <div class="mt-16px" v-if="!addresses || addresses.length == 0">
                <div class="card-body d-flex justify-content-between">
                    <p class="color-gray description-text">{{$t('Address is still empty')}}</p>
<!--                    <a href="#" class="" @click.prevent="openAddForm">{{ $t('Add Shipping Address') }}</a>-->
                </div>
            </div>
            <div v-else>
              <div style="padding: 8px">
                <label class="card-body d-flex" style="padding: 0 24px;margin: 16px 0;" v-for="address in addresses">
                  <div class="address-radio">
                    <div class="radio-style">
                      <input type="radio" name="address-picker" :value="address.id" v-model="model" :checked="addresses.length==1">
                      <span class="checkmark"></span>
                    </div>

                  </div>
                  <div class="address-info">
                    <div class="address-title display-address">{{ $t( addressLabel(address.type) ) }}
                      <a href="#" @click.prevent="edit(address)" class="address-action action-edit">Edit</a><a href="#" @click.prevent="del(address)" class="address-action action-delete">{{$t('Delete')}}</a>
                    </div>
                    <div class="address-content">
                      {{ address.recipient_name }} ({{address.phone}})<br>
                      {{ fullAddress(address) }}
                    </div>
                  </div>
                </label>
              </div>

            </div>
        </div>
      <a href="#" class="add-shipping-address-btn-fixed web-block link-product" @click.prevent="openAddForm">{{ $t('Add Shipping Address') }}</a>
      <a href="#" class="mobi-block link-product" @click.prevent="openAddForm" style="float: right">{{ $t('Add Shipping Address') }}</a>
        <div class="modal my-modal" id="modal-add-address" data-backdrop="static">
            <div class="modal-dialog my-modal-dialog">
                <div class="modal-content">
                    <form method="post" id="address" @submit.prevent="save()">
                        <!-- Modal body -->
                        <div class="modal-body" style="padding: 15px; background-color: #fff">
                            <div class="form-group col-12">
                            <h5 class="modal-title" v-if="editingId">Edit Shipping Address</h5>
                            <h5 class="modal-title" v-else>{{ $t('Add Shipping Address') }}</h5>
                            </div>
                                <div class="form-group col-12">
                                  <label>{{ $t('Place') }}</label>
                                    <select name="" class="form-control" v-model="form.type">
                                        <option value="HOME">{{$t('Home')}}</option>
                                        <option value="COMPANY">{{$t('Company')}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-12 col-responsive form-group">
                                    <label>{{$t('Recipient name')}}</label>
                                    <input type="text" :placeholder="this.$t('Recipient name')" v-model="form.recipient_name" required  class="form-control">
                                </div>
                                <div class="col-sm-12 col-md-12 col-responsive form-group">
                                    <label>{{$t('Recipient phone')}}</label>
                                    <input type="text" :placeholder="this.$t('Recipient phone')" v-model="form.phone" required class="form-control">
                                </div>
                                <div class="col-sm-12 col-md-12 col-responsive form-group">
                                    <label>{{$t('Province')}}</label>
                                    <ProvinceInput v-model="form.province_id" />
                                </div>
                                <div class="col-sm-12 col-md-12 col-responsive form-group">
                                    <label>{{$t('City')}}</label>
                                    <CityInput v-model="form.regency_id" :province-id="form.province_id" />
                                </div>
                                <div class="col-sm-12 col-md-12 col-responsive form-group">
                                    <label>{{$t('District')}}</label>
                                    <DistrictInput v-model="form.district_id" :city-id="form.regency_id" />
                                </div>
                                <div class="col-12 col-responsive form-group">
                                    <label>{{$t('Address')}}</label> <span id="error-address"></span>
                                    <textarea  name="address" :placeholder="this.$t('Address')" v-model="form.addresses" class="form-control" minlength="10" required>
                                    </textarea>
                                </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-cancel" data-dismiss="modal">{{$t('Cancel')}}</button>
                            <button class="btn primary btn-primary" type="submit">{{$t('Save')}}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
function validateForm(){
  var name = document.forms["address"]["address"].value;

  if (name.length<10) {
    document.getElementById('error-address').innerHTML = "The addresses must be at least 10 characters."
  }
    return false;
}
</script>
<script>
    import AddressService from '../services/address.service';
    import Constant from '../common/constants'
    import Helper from '../common/helper';
    import ProvinceInput from './input/ProvinceInput';
    import CityInput from './input/CityInput';
    import DistrictInput from './input/DistrictInput';

    export default {
        name: "UserAddress",
        components: {
            ProvinceInput,
            CityInput,
            DistrictInput
        },
        props: {
          value: {}
        },
        data() {
            return {
                ...Constant,
                addresses: [],
                editing: null,
                editingItem: {},
                editingId: '',
                form: {
                    "district_id": '',
                    "regency_id": '',
                    "province_id": '',
                    "recipient_name": '',
                    "addresses": '',
                    "phone": '',
                    "type": ''
                },
            }
        },

        computed: {
          model: {
              get() {
                  return this.value;
              },
              set(value) {
                  this.$emit('input', value);
              }
          }
        },
        created() {
            this.fetch();
        },
        methods: {
            async fetch() {
                const _this = this;
                const {data} = await AddressService.getList();

                this.addresses = data;

                let defaultAddress = null;
                this.addresses.forEach(address => {
                    if (address.is_default) {
                        defaultAddress = address;
                    }
                });

                if (!defaultAddress && this.addresses.length) {
                    defaultAddress = this.addresses[0];
                }

                if (defaultAddress) {
                    this.$emit('input', defaultAddress.id);
                }
            },

            async save() {
                this.showLoading();
                const _this = this;
                try{
                    if (this.editingId) {
                        const {data} = await AddressService.update(this.editingId, this.form);

                        const index = this.addresses.findIndex(item => item.id == _this.editingId);
                        if (index) {
                            this.$set(this.addresses, index, data);
                        }
                        window.location.reload();
                    } else {
                        const {data} = await AddressService.create(this.form);
                        this.addresses.unshift(data);
                    }
                    this.resetForm();
                }
                catch (e) {
                    let errors = e.response.data.errors;
                    console.log(errors);
                    $.each(errors, function (key, value) {
                        console.log(value);
                        _this.errorMessage(value);

                    });
                }
                this.hideLoading();
            },

            resetForm() {
                $('#modal-add-address').modal('hide');
                this.form = {
                    "district_id": '',
                    "regency_id": '',
                    "province_id": '',
                    "recipient_name": '',
                    "addresses": '',
                    "phone": '',
                    "type": ''
                };

                this.editingId = null;
            },

            edit(address) {
                this.editingId = address.id;
                this.form = Object.assign({}, address);
                this.openAddForm();
            },

            addressLabel(addressType) {
                let addressLabel = '';
                switch (addressType) {
                    case this.USER_ADDRESS_TYPE_HOME:
                        addressLabel = 'Home Address';
                        break;
                    case this.USER_ADDRESS_TYPE_COMPANY:
                        addressLabel = 'Office Address';
                        break;
                }

                return addressLabel;
            },

            setAsDefault(address) {
                const {data} = AddressService.setAsDefault(address);
            },

            async del(address) {
                if (!await this.confirm("Do you want to delete?")) {
                    return;
                }

                this.showLoading();

                const {data} = await AddressService.delete(address.id);

                if (!data) {
                    return;
                }

                const index = this.getAddressIndexById(address.id);

                if (index !== -1) {
                    this.addresses.splice(index, 1);
                }

                this.hideLoading();
            },

            getAddressIndexById(id) {
                return this.addresses.findIndex(item => item.id === id);
            },

            openAddForm() {
                $('#modal-add-address').modal('show');
            },

            closeAddForm() {
                this.resetForm();
                $('#modal-add-address').modal('hide');
            },

            fullAddress(address) {
                const chunks = [];

                chunks.push(address.addresses);

                if (address.disctrict) {
                    chunks.push(address.disctrict.name);
                }

                if (address.city) {
                    chunks.push(address.city.name);
                }

                if (address.province) {
                    chunks.push(address.province.name);
                }

                return chunks.join(', ');
            }
        }
    }
</script>

<style scoped>
    .address-radio {
        float: left;
    }

    .address-info {
        display:block;
        padding-left: 20px;
        line-height: 1.8em;
    }

    .address-info .address-title {
        font-weight: 700;
        /*padding-bottom: 5px;*/
    }

    .address-info .address-content {
      font-family: "Inter";
      font-style: normal;
      font-weight: normal;
      font-size: 14px;
      line-height: 145%;
      /* or 20px */

      letter-spacing: 0.002em;
    }

    /* The.radio-style */
    .radio-style {
        display: block;
        position: relative;
        padding-left: 12px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .radio-style input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #FFFFFF;
        border-radius: 50%;
        border: 2px solid #30B6A4;
        box-sizing: border-box;
    }

    /* On mouse-over, add a grey background color */
    .radio-style:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .radio-style input:checked ~ .checkmark {
        background-color: #30B6A4;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .radio-style input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .radio-style .checkmark:after {
        top: 4px;
        left: 4px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }

    .address-action {

    }

    .action-edit {
        color: #413EC1;
        padding-left: 15px;
    }

    .action-edit:hover {
        color: #413EC1;
    }

    .action-delete {
        color: #EB4242;
        padding-left: 10px;

    }

    .action-delete:hover {
        color: #EB4242;
    }

    .add-shipping-address-btn {
        float:right;
    }

    .my-modal-dialog {
        max-width: 480px;
    }

    .my-modal-dialog .modal-body {
        padding: 15px;
    }

    .address-list {
        position:relative;

    }

    .address-list .add-shipping-address-btn {
        right: 0;
        padding: 1.25rem;
        position: absolute;
    }
    @media (min-width: 0) and (max-width: 576px) {
      .address-list .add-shipping-address-btn {
        right: 0;
        padding: 1px;
        position: absolute;
      }
      .display-address{
        white-space: nowrap;
        display: flex!important;
      }
    }

    .btn-cancel{
        width: 86px;
    }
    .btn-primary{
        width: 125px;
    }
    .modal-title{
        font-size: 16px;
        margin: 15px 0px;
    }
    .modal-footer{
        padding-top: 0px;
    }
</style>
