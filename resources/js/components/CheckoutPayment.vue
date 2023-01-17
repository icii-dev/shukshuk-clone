<template>
    <div>
      <div class="row">
        <div class="col-sm-12  col-md-12 col-lg-8 col-xs-8" style="padding: 0 12px">
          <div class="title-payment card-title-product web-block">{{ $t('Payment Method') }}</div>
          <div class="payment-channel web-block">
            <form class="form-step1-1" style="margin-bottom: 0">
              <div style="border-bottom: 1px solid #E4E8E8;padding: 16px 0;">
                <div class="wrap-check d-flex justify-content-between align-items-center">
                  <div class="wrap-check">
                    <label class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" name="payment"
                             v-model="methodChecked" :value="methodCard"
                             v-on:change="getPaymentFee">
                      <span class="custom-control-label"> </span>
                      <span class="custom-text link-product">{{ $t('Credit card') }}</span>
                    </label>
                  </div>
                  <div>
                    <span><img src="/vendor/buyer/svg/MasterCard-logo.png" height="16px"/></span>
                    <span><img src="/vendor/buyer/svg/visa-logo.png" height="16px"/></span>
                  </div>
                </div>
              </div>
              <div class="wrap-check payment-channel-item justify-content-between" style="padding: 24px 21px; display:none;">
                <p class="description-text">
                  {{$t('alert card payment')}}
                </p>
                <div class="mt-3">
                  <button class="add-credit-card" disabled>
                    <span></span>
                  </button>
                </div>

              </div>
              <div class="wrap-check payment-channel-item d-flex justify-content-between align-items-center">
                <label class="custom-control custom-radio"
                       dusk="test-default-payment">
                  <input type="radio" class="custom-control-input" name="payment"
                         v-model="methodChecked" :value="methodBankTransfer"
                         v-on:change="getPaymentFee">
                  <span class="custom-control-label"></span>
                  <span class="custom-text link-product">{{$t('Bank Transfer')}}</span>
                </label>
                <div>
                  <span><img src="/vendor/buyer/svg/BCA.png" height="16px"/></span>
                  <span><img src="/vendor/buyer/svg/Bank2.png" height="16px"/></span>
                  <span><img src="/vendor/buyer/svg/CIMB.png" height="16px"/></span>
                </div>
              </div>
              <div class="wrap-check payment-channel-item d-flex justify-content-between align-items-center">
                <label class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" name="payment"
                         v-model="methodChecked" :value="methodVirtual"
                         v-on:change="getPaymentFee">
                  <span class="custom-control-label"></span>
                  <span class="custom-text link-product">{{ $t('Bank Virtual Accounts') }}</span>
                </label>
                <div>
                  <span><img src="/vendor/buyer/svg/BCA.png" height="16px"/></span>
                  <span><img src="/vendor/buyer/svg/Bank2.png" height="16px"/></span>
                  <span><img src="/vendor/buyer/svg/CIMB.png" height="16px"/></span>
                </div>
              </div>
              <div class="wrap-check payment-channel-item d-flex justify-content-between align-items-center">
                <label class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" name="payment"
                         v-model="methodChecked" :value="methodEWallets"
                          v-on:change="getPaymentFee"
                  >
                  <span class="custom-control-label"></span>
                  <span class="custom-text link-product">E-Wallet</span>
                </label>
                <div>
                  <span><img src="/vendor/buyer/svg/dana-logo.svg" height="16px"/></span>
                  <span><img src="/vendor/buyer/svg/ovo-logo.svg" height="16px"/></span>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4 col-xs-4" style="padding: 0 12px">
          <div class="title-payment card-title-product web-block">{{$t('Order Summary')}}</div>
          <div class="card mt-16px web-block">
            <div class="card-header d-flex justify-content-start" style="padding: 24px">
              <p style="white-space: nowrap;padding-right: 50px" class="color-gray link-product">{{ $t('Reference Number') }}</p>
              <p><b class="truncate-overflow-one link-product">{{cart.checkout_id ? cart.checkout_id.toUpperCase() : ''}}</b></p>
            </div>
            <div class="card-body"  style="padding: 4px 24px;">
              <div class="text-fee d-flex justify-content-between">
                <p class="color-gray link-product">{{$t('Total Price')}} ({{cart.total_items}} Item<template v-if="cart.total_items">s</template>
                  )
                </p>
                <h6 class="card-title-product" style="margin-bottom: 0">{{ cart.subtotal | formatCurrency }}</h6>
              </div>
              <div class="text-fee d-flex justify-content-between">
                <p class="color-gray link-product">{{ $t('Shipping Fee') }}</p>
                <h6 class="card-title-product" style="margin-bottom: 0">{{ cart.total_shipping_fee | formatCurrency }}</h6>
              </div>
              <div class="text-fee d-flex justify-content-between">
                <p class="color-gray link-product">{{$t('Shipping Insurance')}}</p>
                <h6 class="card-title-product" style="margin-bottom: 0">{{ cart.total_insurance_fee | formatCurrency }}</h6>
              </div>
              <div class="text-fee d-flex justify-content-between">
                <p class="color-gray link-product">{{$t('Payment Fee')}}</p>
                <h6 class="card-title-product" style="margin-bottom: 0">{{ paymentFee | formatCurrency }}</h6>
              </div>
            </div>
            <div class="card-footer" style="padding: 8px 24px;">
              <div class="mt-3 d-flex justify-content-between">
                <p class="color-gray link-product">{{$t('Total Amount')}}</p>
                <h5 class="product-title" style="margin-top:-8px ">{{cart.total + paymentFee | formatCurrency}}</h5>
              </div>
              <div class="mt-5 mb-3">
                <p class="color-gray link-product text-center">{{$t('All prices are inclusive Tax 10%')}}</p>
                <button class="btn primary w-100 mt-2"
                        dusk="btn-pay-now"
                        @click.prevent="payment"
                        :disabled="isSaveInprocess"
                        style="padding-top: 14px;">
                    <img src="/vendor/buyer/svg/lock.svg">
                    <span class="link-product">{{ $t('Pay Now') }}</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mb-30px">
        <div class="col-sm-12  col-md-8 col-lg-8 col-xs-8">
          <div class="mobi-payment card-title-product custom-shipping" >{{$t('Shipping Address')}}</div>
          <div class="payment-channel payment-channel-extra" style="padding-bottom: 20px">
            <div class="justify-content-between text-top phone-padding custom-padding-address mobi-block" style="padding-bottom: 4px">
              <div class="phone recipient-name card-title-product" >
                {{userAddress.recipient_name}}
              </div>
              <div class="phone description-text">
                +{{userAddress.phone}}
              </div>
            </div>
            <div class="d-flex justify-content-between mobi-block">
              <div class="description-text mobi-block">
                {{userAddress.addresses}}
              </div>
            </div>
            <div class=" d-flex justify-content-between text-top" style="padding-bottom: 8px">
              <div class="phone recipient-name card-title-product web-block" >
                {{userAddress.type}}
              </div>
              <a :href="`${routeCheckout}?ref=${checkoutId}`" id="change-address" role="tab" class="mobi-pt-8px">
                <img src="/vendor/buyer/svg/pen.svg"/>
                <span class="link-product ">{{ $t('Change Shipping Address') }}</span>
              </a>
            </div>
            <div class="d-flex justify-content-between text-top phone-padding custom-padding-address web-block" style="padding-bottom: 4px">
              <div class="phone description-text">
                {{userAddress.recipient_name}}(+{{userAddress.phone}})
              </div>
            </div>
            <div class="d-flex justify-content-between web-block">
              <div class="description-text">
                {{userAddress.addresses}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12  col-md-12 col-lg-8 col-xs-8 mobi-block" style="padding: 0 12px;">
          <div class="title-payment mobi-payment mobi-block" style="padding-bottom: 8px;">{{ $t('Payment Method') }}</div>
          <div class="payment-channel mobi-block" style="padding-bottom: 0;">
          <form class="form-step1-1">
            <div class="wrap-check payment-channel-item d-flex justify-content-between" style="padding-bottom: 0;">
              <select class="form-control" name="payment" title="select payment method"
                      v-model="methodChecked"  v-on:change="getPaymentFee"
                      style="border-radius: 4px; background-color: #F6F8F8;">
                <option :value="methodCard">{{ $t('Credit card') }}</option>
                <option :value="methodBankTransfer">{{ $t('Bank Transfer') }}</option>
                <option :value="methodVirtual">{{ $t('Bank Virtual Accounts') }}</option>
                <option :value="methodEWallets">E-Wallet</option>
              </select>
            </div>
          </form>
          <!--                      <div class="custom-control custom-checkbox">-->
          <!--                        <input type="checkbox" class="custom-control-input" checked>-->
          <!--                        <label class="custom-control-label">Save My Card</label>-->
          <!--                      </div>-->
        </div>
        </div>
        <div class="col-4">
          <div class="title-payment card-title-product web-block" style="margin: 48px 0 16px 0">{{$t('Shopping Cart')}}</div>
          <div class="payment-channel web-block" style="padding: 26px 24px">
            <div class="product justify-content-between" style="padding-bottom: 6px">

              <div v-for="(store, storeIndex) in cart.store_orders">
                <div class="product-item d-flex justify-content-between"
                     v-for="(product, productIndex) in store.products"
                     :key="product.row_id">
                  <div class="d-flex justify-content-start" style="width: 70%"
                       v-if="product.selected"
                  >
                    <img @error='defaultImg' class="d-block mr-3 img-fluid" :src="product.thumbnail_url"
                         width="68"  alt="" style="height: initial">
                    <div>
                      <a :href="product.url"
                         class="color-custom truncate-overflow-one">{{product.name}}</a>
                      <div class="checkout-product-option"
                           v-for="(optionValue, optionName) in product.options"
                           :key="optionName">
                        <span>{{optionName}}: {{optionValue}}</span></div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-end" style="width: 30%"
                       v-if="product.selected"
                  >
                    <p class="font-weight-bold">{{product.total |
                      formatCurrency}}</p>
                  </div>
                </div>
              </div>

            </div>
            <div class="web-block">
              <p class="color-gray"></p>
              <a href="#" data-toggle="modal" data-target="#orderDetailModal" role="button" class="btn-customer secondary btn">
                {{$t('View Detail')}}
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="mobi-block grand-total">
              <div class="container" style="padding: 0;">
                <div class="d-flex justify-content-between in-line">
                  <p class="link-product">Total Price ({{cart.total_items}} Item
                    <template v-if="cart.total_items">s</template>
                    )
                  </p>
                  <h6>{{ cart.subtotal | formatCurrency }}</h6>
                </div>
                <div class="d-flex justify-content-between in-line">
                  <p class="link-product">{{ $t('Shipping Fee') }}</p>
                  <h6>{{ cart.total_shipping_fee | formatCurrency }}</h6>
                </div>
                <div class="d-flex justify-content-between in-line">
                  <p class="link-product">{{$t('Shipping Insurance')}}</p>
                  <h6>{{ cart.total_insurance_fee | formatCurrency }}</h6>
                </div>
                <div class="text-fee d-flex justify-content-between">
                  <p class="link-product">Payment Fee</p>
                  <h6>{{ paymentFee | formatCurrency }}</h6>
                </div>
                <hr>
                <div class="d-flex justify-content-between wrap-total">
                  <p class="tax link-product" style="font-weight: bold">All price are inclusive Tax 10%</p>
                  <div>
                    <p class="text-right">Total</p>
                    <h2>{{cart.total + paymentFee | formatCurrency}}</h2>
                  </div>
                </div>
<!--                                        <a id="continue-disabled-mobi" class="btn-customer btn-disabled btn col-12" href="#"-->
<!--                                           role="button">Pay Now</a>-->
                <div id="show-btn-payment">
                  <ul class="nav">
                    <li class="w-100">
                      <p class="color-gray text-center web-block">All prices are inclusive Tax 10%</p>
                      <button class="btn primary w-100 mt-2" @click.prevent="payment"
                              :disabled="isSaveInprocess" id="continue-disabled-mobi">{{$t('Pay Now')}}
                      </button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

      <!-- Modal -->
      <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 640px;">
          <div class="modal-content">
            <div class="modal-header">
              <p class="custom-font card-title-product">{{ $t('Shopping Cart') }}</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 11px">
                <span aria-hidden="true"><img src="/vendor/buyer/svg/VectorX.svg"/> </span></button>
            </div>
            <div class="modal-body">
              <div class="card" v-for="(store, storeIndex) in cart.store_orders">
                <div class="your-cart" style="border-radius: 8px;
                padding: 0;background-color: #FFFFFF;
                   border-bottom: 1px solid #E4E8E8;margin: 18px 32px 0 32px;">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                      <img src="/vendor/buyer/Img/store-outline.svg" style="padding-right: 11px">
                      <a :href=store.url>{{store.name}}</a>
                    </div>
<!--                    <chat-button  style="padding: 0 !important;" class="btn-chat-payment" :store-id="store.id" :user-id="userId">-->
<!--                      {{ $t('Message Seller') }}-->
<!--                    </chat-button>-->
                  </div>
                  <div class="product" v-for="(product, productIndex) in store.products"
                       :key="product.row_id" style="margin-bottom: 0;margin-top: -4px;" >
                    <div class="row d-flex align-items-center justify-content-between">
                      <div class="col-8 d-flex justify-content-start">
                        <img :src="product.thumbnail_url" alt=""
                             @error='defaultImg'class="img-your-cart-responsive cart-detail-payment">
                        <div class="justify-content-between" style="margin-top: 16px">
                          <a :href="product.url" target="_blank"
                             class="name-product truncate-overflow-one">{{ product.name }}</a>
                          <div class="checkout-product-option" style="padding-top: 8px;"
                               v-for="(optionValue, optionName) in product.options" :key="optionName">
                            <span style="white-space: nowrap">{{optionName}}: {{optionValue}}</span></div>
                        </div>
                      </div>
                      <div class="col-4  justify-content-end" v-if="!!product.discount_percent"  style="text-align: right;">
                        <p class="text-sale ">{{product.price_old * product.quantity |formatCurrency}}</p>
                        <h3 class="card-title-product" style="padding-bottom: 8px">{{ product.total | formatCurrency}}</h3>
                        <p class="sale-off web-block" style="display: initial">{{product.discount_percent}}% off</p>
                      </div>
                      <div class="col-4 d-flex justify-content-end" v-else>
                        <h3 class="card-title-product" style="padding-bottom: 52px;">{{ product.total | formatCurrency}}</h3>
                      </div>
                    </div>
                    <div class="card-header-payment-view link-product" style="padding-top: 8px;padding-bottom: 6px;">
                      Note:-{{ product.note}}
                    </div>
                  </div>
                  <div class="d-flex justify-content-between cart-item-card-payment-view" style="padding-top: 0;">
                    <p class="color-gray link-product">{{$t('Delivery Method')}}:</p>
                    <div v-switch="store.shipping_option_id">
                      <p class="color-black link-product" v-case="'REG'">Regular</p>
                      <p class="color-black link-product" v-case="'ND'">Next Day</p>
                      <p class="color-black link-product" v-case="'SD'">Same Day</p>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between cart-item-card-payment-view">
                    <p class="color-gray link-product">{{$t('Duration')}}:</p>
                      <div v-switch="store.shipping_option_id">
                        <p class="color-black link-product" v-case="'REG'">2-3 days to arrive</p>
                        <p class="color-black link-product" v-case="'ND'">Package will arrive tomorrow</p>
                        <p class="color-black link-product" v-case="'SD'">Package will arrive in the same day</p>
                      </div>
                  </div>
                  <div class="d-flex justify-content-between cart-item-card-payment-view" style="margin-bottom: 20px">
                    <p class="color-gray link-product">Delivery Fee:</p>
                    <p class="color-black link-product">{{store.shipping_fee + store.insurance_fee | formatCurrency}}</p>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between cart-item-card-payment-view" style="padding-right:24px;padding-top: 16px">
                <p class="color-gray text-center link-product">{{$t('All prices are inclusive Tax 10%')}}</p>
                <h6 class="color-black text-center card-title-product"><b>Total</b></h6>
              </div>
              <div class="d-flex justify-content-between" style="padding-right:24px ">
                <p class="color-gray text-center"></p>
                <p class="product-subtitle">{{cart.total + paymentFee | formatCurrency}}</p>
              </div>
            </div>
            <div class="modal-footer" style="padding: 12px 0px">

            </div>
          </div>
        </div>
      </div>
    </div>

</template>
<script>
  import CheckoutService from '../services/checkout.service';
  import UserAddressService from '../services/address.service';
  import Vue from 'vue'
  import VSwitch from 'v-switch-case'

  Vue.use(VSwitch)

  export default {
    name: "Checkout",
    props: ['routeCheckout', 'checkoutId','userId'],
    data() {
      return {
        cart: {},
        userAddress: {},
        methodChecked: [],
        methodCard: ["CREDIT_CARD"],
        methodVirtual: ["BCA", "BRI", "MANDIRI", "BNI", "PERMATA"],
        methodBankTransfer: ["BCA", "BRI", "MANDIRI", "BNI", "PERMATA", "BSS"],
        methodEWallets: ["OVO", "DANA"],
        methodOutlet: ["ALFAMART"],
        isSaveInprocess: false,
        paymentFee: 0,
      }
    },
    mounted(){
      this.methodChecked = this.methodCard;
      this.getPaymentFee();
    },
    computed: {},
    created() {
      this.fetch();
    },
    methods: {
      async fetch() {
        this.showLoading();
        try {
          const {data} = await CheckoutService.getCheckoutCartById(this.checkoutId);
          this.cart = data;
          this.userAddress = await UserAddressService.getOne(this.cart.buyer_address.id);
          this.userAddress = this.userAddress.data;
        }
        catch (e) {
          console.log(e);
        }
        this.hideLoading();
      },
      async payment() {
        const _this = this;
        this.showLoading();
        try {
          const invoice = await CheckoutService.createPayment(this.methodChecked, this.checkoutId);
          window.location.href = invoice.data.invoice_url;
          console.log(invoice);
        }
        catch (e) {
            if(e.message){
              let errors = e.response.data.errors;
              // console.log(e.message);
              $.each(errors, function (key, value) {
                _this.errorMessage(value);
              });
            }else {
              _this.errorMessage(e.message);
              // this.hideLoading();
            }

        }
        this.hideLoading();
      },
      async getPaymentFee() {
        this.showLoading();
        try {
          let fee = await CheckoutService.getPaymentFeeentFee(this.methodChecked, this.checkoutId);
          this.paymentFee = fee.data;
        }
        catch (e) {
          console.log(e);
        }
        console.log(this.paymentFee);
        this.hideLoading();
      },
      defaultImg(event){
        var url = location.protocol + "//" + location.host;
        event.target.src = url + '/img/not-found.jpg';
      }
    }
  }
  function openForm() {
    document.getElementById("myForm").style.display = "block";
  }

  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }
</script>
<style scoped>
    .cart-store-order {
        padding-bottom: 20px;
    }

    .card {
        border: none;
    }

    .card .text-fee {
        margin: 10px 0px;
    }

    .title-card {
        margin-top: 48px;
    }

    .card-header, .card-footer {
        background-color: #ffffff;
    }

    .cart-item-card {
        padding: 10px 24px;
        border-bottom: 1px solid #E4E8E8;;
    }

    .cart-item-card .form-group {
        margin-bottom: 0px;
    }

    .cart-item-card .wrap-select {
        margin-bottom: 0px;
    }

    .custom-control-label:before {
    }

    .your-cart {
        border-radius: 8px;
        padding: 0px 32px;
    }

    .your-cart .product {
        margin-top: 16px;
    }

    label.custom-control-label {
        padding-left: 12px;
    }

    .product-item {
        margin-bottom: 12px;
    }
    .modal-header{
      padding: 24px 32px;
    }
    .modal-body{
      padding: 0;
      margin-top: 8px;
      overflow-y: auto;
      background-color: rgb(255, 255, 255);
    }
    .cart-detail-payment{
      margin-left: 32px;
      margin-bottom: 0;
      margin-top: 10px;
    }

    @media (min-width: 0) and (max-width: 576px) {
      .payment-channel-extra {
        padding-top: 0!important;
        padding-bottom: 40px!important;
      }
      .mobi-payment {
        font-weight: 600;
        font-size: 14px;
        margin-left: 20px !important;
      }
      .payment-channel {
        background-color: #FFFFFF;
        border-radius: 8px;
        padding-left: 20px;
        padding-right: 20px;
      }
      .custom-padding-address{
        padding-bottom: 16px!important;
      }
      .mobi-pt-8px{
        padding-top: 20px;
      }
    }
</style>
