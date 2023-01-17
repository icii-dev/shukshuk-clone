<template>
  <div>
    <div class="row">
      <div class="col-sm-12  col-md-12 col-lg-8 col-xs-8">
        <h6 style="margin-bottom: 16px;" class="card-title-product">{{$t('Shipping Address')}}</h6>
        <UserAddress v-model="userAddress" @input="onChangeUserAddress"></UserAddress>

        <!-- shopping cart -->
        <div class="cart-store-order">
          <h6 class="title-card mobi-title-card card-title-product" style="margin-bottom: 16px">{{$t('Shopping Cart')}}</h6>
          <div class="cart-content">
            <div class="card" style="margin-bottom: 16px" v-for="(store, storeIndex) in cart.store_orders">
              <div class="card-header d-flex justify-content-between align-items-center card-header-responsive">
<!--                <p class="color-gray web-block">{{$t('Products in cart')}}</p>-->
                <div class="custom-control custom-checkbox" style="padding-left: 16px">
                  <input type="checkbox"
                         class="custom-control-input"
                         v-model="store.selected"
                         @change="changeSelectedStore(store)"
                         :id="`store-selected-${store.id}`"
                  >
                  <label class="custom-control-label selected-checkbox-label"
                         :for="`store-selected-${store.id}`"
                         style="">{{$t('Select All')}}</label>
                </div>
                <div class="d-flex align-items-center">
                  <img src="/vendor/buyer/Img/store-outline.svg">
                  <a :href=store.url class="truncate-overflow-one">{{store.name}}</a>
                </div>
              </div>
              <div class="your-cart" style="margin: 16px 0px 16px 16px">
                <!--product-->
                <div class="product" style="margin-bottom: 0" v-for="(product, productIndex) in store.products"
                     :key="product.row_id">
                  <div class="row left d-flex align-items-center justify-content-between">
                    <div class="col-sm-6 col-md-7 col-lg-7 row">
                      <div class="custom-control custom-checkbox align-self-center" style="padding: unset">
                        <input type="checkbox"
                               @change="selectProduct(product.row_id, product.selected)"
                               v-model="product.selected"
                               style="position: relative"
                               :id="`selected-${product.row_id}`"
                               class="custom-control-input"
                        >
                        <label :for="`selected-${product.row_id}`" class="custom-control-label selected-checkbox-label"
                               style="padding: unset; margin-bottom: 16px"></label>
                      </div>
                      <div class="">
                        <img :src="product.thumbnail_url" alt=""  @error='defaultImg' class="img-item web-block">
                        <img :src="product.thumbnail_url" alt=""  @error='defaultImg' class="img-your-cart-responsive mobi-block" style="margin-bottom: 0;">
                      </div>
                      <div class="col-7 detail-product-yourcart">
                        <a :href="product.url" target="_blank"
                           class="name-product truncate-overflow-one">{{ product.name }}</a>
                        <div class="checkout-product-option" style="padding-top: 8px;"
                             v-for="(optionValue, optionName) in product.options" :key="optionName">
                          <span>{{optionName}}: {{optionValue}}</span></div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3 " style="padding: 28px 0;">
                      <div class="d-flex amount-main amount-details" style="width: 160px;">
                        <button class="button-1 col qty-btn" @click="subQuantity(product)"
                                :disabled="listProductsInProgress[product.row_id]"><img
                            src="/vendor/buyer/Img/reduction.svg" alt=""></button>
                        <input type="text"
                               v-model="model[storeIndex]['products'][productIndex]['quantity']"
                               :disabled="listProductsInProgress[product.row_id]"
                               class="input number numbar-main" style="height: 40px;">
                        <button class="col button-2 qty-btn" @click="addQuantity(product)"
                                :disabled="listProductsInProgress[product.row_id]"><img
                            src="/vendor/buyer/Img/add.svg" alt=""></button>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3 rigfht-sale flex-column prices-sale-off price-mobi" v-if="!!product.discount_percent"
                         style="text-align: right; max-width: fit-content">
                      <p class="text-sale ">{{product.price_old * product.quantity |
                          formatCurrency}}</p>
                      <h3 class="card-title-product">{{product.total | formatCurrency}}</h3>
                      <p class="sale-off text-left web-block" style="float: right">{{showPrice(product.discount_percent, product.discount_type)}}</p>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 rigfht-sale flex-column" v-else
                         style="text-align: right;">
                      <h3 class="card-title-product web-block" style="padding-bottom: 52px;padding-top: 36px;">{{ product.total | formatCurrency}}</h3>
                      <h3 class="card-title-product mobi-block" style="padding-bottom: 36px;padding-top: 36px;">{{ product.total | formatCurrency}}</h3>
                    </div>
                  </div>

                </div>
                <!-- #product -->
              </div>
              <hr style="margin: 0 16px">
              <div class="cart-item-card">
                <div class="row">
                  <div class="form-group col-md-6 col-sm-12" style="padding-right: 56px;">
                    <div class="wrap-select">
                      <select v-model="model[storeIndex]['shipping_option_id']" class="form-control"
                              @change="onChangeShippingOption(store, $event.currentTarget.value)" style="background-color: #F6F8F8;">
                        <option :value="shippingOption.id"
                                v-for="shippingOption in store.shipping_options">
                          {{shippingOption.name}}
                        </option>
                      </select>
                    </div>
                  </div>
<!--                  <div class="form-group col-md-4 col-sm-12" style="padding: 0;">-->
<!--                  </div>-->
                  <div class="col-md-4 col-sm-6 d-flex align-items-center" style="padding: 0;">
                    <div class="custom-control custom-checkbox" style="padding-left: 16px;">
                      <input type="checkbox" :id="`insurance-${storeIndex}`"
                             class="custom-control-input"
                             v-model="model[storeIndex]['enable_insurance']"
                             @change="onChangeShippingInsurance(store, $event.currentTarget.checked)">
                      <label class="custom-control-label" :for="`insurance-${storeIndex}`">{{$t('Shipping Insurance')}}</label>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 d-flex justify-content-end align-items-center shipping-fee-mobi">
                    <h3 class="">{{store.shipping_fee + store.insurance_fee | formatCurrency}}</h3>
                  </div>
                </div>
              </div>

              <div class="cart-item-card" v-if="store.error">
                <div class="row">
                  <div class="col-12 text-danger">
                    {{store.error_message}}
                  </div>
                </div>
              </div>

              <div class="cart-item-card d-flex justify-content-between" style="border: 0px">
                <p class="color-gray">Subtotal ({{ orderStoreTotalItem[store.id] }} item
                  <template v-if="orderStoreTotalItem[store.id]>1">s</template>
                  )
                </p>
                <h3 class="">{{ store.total | formatCurrency }}</h3>
              </div>

            </div>
          </div>

        </div>
        <!-- #shopping cart -->
      </div>
      <div class="col-sm-12 col-md-12 col-lg-4 col-xs-4">
        <h6 style="margin-bottom: 16px;" class="card-title-product">{{$t('Order Summary')}}</h6>
        <div class="card mt-16px" style="border: none;">
          <div class="card-header d-flex justify-content-start" style="padding: 24px">
            <p style="white-space: nowrap;padding-right: 50px" class="color-gray link-product">{{$t('Reference Number')}}</p>
            <p><b class="truncate-overflow-one link-product">{{cart.checkout_id ? cart.checkout_id.toUpperCase() : ''}}</b></p>
          </div>
          <div class="card-body" style="padding: 4px 24px;">
            <div class="text-fee d-flex justify-content-between">
              <p class="color-gray link-product">{{$t('Total Price')}} ({{cart.total_items}} Item
                <template v-if="cart.total_items">s</template>
                )
              </p>
              <h6 class="card-title-product" style="margin-bottom: 0">{{ cart.subtotal | formatCurrency }}</h6>
            </div>
            <div class="text-fee d-flex justify-content-between">
              <p class="color-gray link-product">{{$t('Shipping Fee')}}</p>
              <h6 class="card-title-product" style="margin-bottom: 0">{{ cart.total_shipping_fee | formatCurrency }}</h6>
            </div>
            <div class="text-fee d-flex justify-content-between">
              <p class="color-gray link-product">{{$t('Shipping Insurance')}}</p>
              <h6 class="card-title-product" style="margin-bottom: 0">{{ cart.total_insurance_fee | formatCurrency }}</h6>
            </div>
          </div>
          <div class="card-footer" style="padding: 8px 24px;">
            <div class="mt-3 d-flex justify-content-between">
              <p class="color-gray link-product">{{$t('Total Amount')}}</p>
              <h5 class="product-title" style="margin-top:-8px ">{{cart.total | formatCurrency}}</h5>
            </div>
            <div class="mt-5 mb-3">
              <p class="color-gray text-center link-product">{{$t('Please make sure your order and shipping address are correct')}}</p>
              <button class="btn primary w-100 mt-2"
                      dusk="btn-make-payment"
                      @click.prevent="saveOrder"
                      :disabled="isSaveInprocess">
                {{ $t('Make Payment') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import CheckoutService from '../services/checkout.service'
import UserAddress from './UserAddress'
export default {
  name: "Checkout",
  components: {
    UserAddress
  },
  props: {
    buyNowCart: {},
    refId: {},
  },
  data() {
    return {
      cart: {},
      userAddress: null,
      listProductsInProgress: {},
      listStoresInprogress: {},
      isSaveInprocess: false,
      userAddressId: null,
    }
  },
  created() {
    this.fetch();
  },
  computed: {
    orderStoreTotalItem() {
      const orderStoreTotalItem = {};
      this.cart.store_orders.forEach(_store => {
        orderStoreTotalItem[_store.id] = _store.products.reduce((_total, _product) => {
          return _total + _product.quantity;
        }, 0);
      });
      return orderStoreTotalItem;
    },
    model: {
      get() {
        const model = [];
        this.cart.store_orders.forEach((_store, _storeKey) => {
          model[_storeKey] = {
            shipping_option_id: _store.shipping_option_id,
            enable_insurance: _store.enable_insurance,
            products: []
          };
          if(_store){
            _store.products.forEach((_product, _productKey) => {
              model[_storeKey]['products'][_productKey] = {
                quantity: _product.quantity
              }
            });
          }

        });
        return model;
      },
      set() {
      }
    },
    checkoutId() {
      if (typeof(this.cart.checkout_id) !== "undefined") {
        return this.cart.checkout_id;
      }
      return this.refId;
    }
  },
  methods: {
    async fetch() {
      this.showLoading();
      const {data} = await CheckoutService.getCheckoutCart(Number(this.buyNowCart), this.checkoutId);
      this.cart = data;
      if (this.userAddressId) {
        try {
          const response = await CheckoutService.updateAddress(this.userAddressId, this.checkoutId);
          this.cart = response.data;
        }
        catch (e) {
        }
      }
      this.hideLoading();
    },
    onPickedAddress(userAddress) {
      this.userAddress = userAddress
    },
    async addQuantity(product) {
      this.showLoading();
      const newQuantity = product.quantity + 1;
      this.$set(this.listProductsInProgress, product.row_id, true);
      try {
        const response = await CheckoutService.updateRowQuantity(product.row_id, newQuantity, this.checkoutId);
        this.cart = response.data;
      }
      catch (e) {
        console.log(e.response.data.errors);
        let res = e.response.data.errors;
        if(res){
          res.forEach(function (message) {
            $.notify({
              content :message,
              alertType: "alert-warning",
              timeout: 5000
            });
          });
        }
      }
      this.$delete(this.listProductsInProgress, product.row_id);
      this.hideLoading();
    },
    async subQuantity(product) {
      this.showLoading();
      const newQuantity = product.quantity - 1;
      this.$set(this.listProductsInProgress, product.row_id, true);
      try {
        const response = await CheckoutService.updateRowQuantity(product.row_id, newQuantity, this.checkoutId);
        this.cart = response.data;
      }
      catch (e) {
        console.log(e.response.data.errors);
        let res = e.response.data.errors;
        if(res){
          res.forEach(function (message) {
            $.notify({
              content :message,
              alertType: "alert-warning",
              timeout: 5000
            });
          });
        }
      }
      this.$delete(this.listProductsInProgress, product.row_id);
      this.hideLoading();
    },
    async selectProduct(rowId, selected) {
      this.showLoading();
      // this.$set(this.listProductsInProgress, product.row_id, true);
      try {
        const response = await CheckoutService.changeSelected(rowId, selected, this.checkoutId);
        this.cart = response.data;
      }
      catch (e) {
      }
      // this.$delete(this.listProductsInProgress, product.row_id);
      this.hideLoading();
    },
    async changeSelectedStore(store) {
      this.showLoading();
      // this.$set(this.listProductsInProgress, product.row_id, true);
      try {
        const response = await CheckoutService.changeSelectedStore(store.id, store.selected, this.checkoutId);
        this.cart = response.data;
      }
      catch (e) {
      }
      // this.$delete(this.listProductsInProgress, product.row_id);
      this.hideLoading();
    },
    async onChangeShippingOption(store, shipping_option_id) {
      this.showLoading();
      try {
        const {data} = await CheckoutService.updateShippingOption(store.id, shipping_option_id, this.checkoutId);
        this.cart = data;
      }
      catch (e) {
      }
      this.hideLoading();
    },
    async onChangeShippingInsurance(store, checked) {
      this.showLoading();
      try {
        const {data} = await CheckoutService.updateShippingInsurance(store.id, checked, this.checkoutId);
        this.cart = data;
      }
      catch (e) {
      }
      this.hideLoading();
    },
    async onChangeUserAddress(userAddressId) {
      if (!this.checkoutId) {
        this.userAddressId = userAddressId;
        return;
      }
      this.showLoading();
      try {
        const response = await CheckoutService.updateAddress(userAddressId, this.checkoutId);
        this.cart = response.data;
      }
      catch (e) {
      }
      this.hideLoading();
    },
    async payment() {
      CheckoutService.payment(this.cart);
    },
    async saveOrder() {
      const _this = this;
      this.showLoading();
      try {
        this.isSaveInprocess = true;
        const {data} = await CheckoutService.saveOrder(this.cart);
        if (typeof (data.errors) !== 'undefined') {
          // handle error
          return;
        }
        window.location.href = data.url;
      }
      catch (e) {
        const data = e.response.data;
        if (typeof data.errors !== 'undefined' && Array.isArray(data.errors)) {
          data.errors.forEach((errorText) => {
            _this.errorMessage(errorText);
          });
        }
        if (typeof data.reload !== 'undefined') {
          window.location.reload();
        }
      }
      this.isSaveInprocess = false;
      this.hideLoading();
    },
    defaultImg(event){
      var url = location.protocol + "//" + location.host;
      event.target.src = url + '/img/not-found.jpg';
    },
    showPrice(price, type){
      if(type == "PERCENT"){
        return price + "% off";
      }
      return "- " + price + "Rp";
    }
  }
}
</script>

<style scoped>
.custom-control-input:checked~.selected-checkbox-label::before {
  color: #fff;
  background-color: #413EC1;
  border: 2px solid #413EC1;
  top: -10px;
  margin-top: 8px;
}
.selected-checkbox-label:before{
  border: 2px solid #413EC1;
  top: unset;
}
.img-item{
  width: 96px;
  height: 96px;
  margin-left: 12px;
}
.cart-store-order {
  padding-bottom: 20px;
}
.card {
  filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.04));
  border-radius:8px;
}
.card .text-fee {
  margin: 20px 0px;
}
.title-card {
  margin-top: 48px;
}
.card-header, .card-footer {
  background-color: #ffffff;
}
.cart-item-card {
  padding: 16px 0;
  margin: 0 16px;
  border-bottom: 1px solid #E4E8E8;
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
  padding: 0 16px;
  background-color: #FFFFFF;
}
.your-cart .product {
  /*margin-top: 16px;*/
}
label.custom-control-label {
  padding-left: 12px;
}
.modal-body {
  background-color: white;
}
/*qty-btn {*/
/*    border:*/
/*} .*/
.qty-btn {
  border: none;
  background-color: #fff;
}
.qty-btn:hover {
  background-color: #F6F8F8;
}
.detail-product-yourcart{
  padding: unset;
  padding-left: 16px;
}
@media (min-width: 0) and (max-width: 576px) {
  .mobi-title-card{
    margin-top: 36px!important;
  }
  .cart-content {
    border-radius: 8px;
    padding: 0;
    padding-bottom: 8px;
    background-color: #FFFFFF;
  }
  .price-mobi{
    text-align: left!important;
  }
  .amount-main {
    margin-bottom: 0;
    margin-left: 16px!important;
    border: 1px solid #E4E8E8;
    box-sizing: border-box;
    border-radius: 4px;
    background-color: #ffff;
    width: 144px!important;
    padding: 0;
  }
  .detail-product-yourcart {
    margin-right: 48px;
    margin-bottom: 24px;
  }
  .mobi-max-width{
    max-width: 30%;
  }
}

</style>
