import ApiService from './api.service.js';

export default {

    getCheckoutCart(buyNowCart = false, ref = '') {
        return ApiService.get(`/checkout-cart?buy-now-cart=${buyNowCart ? 1 : 0}&ref=${ref}`);
    },

    getCheckoutCartById(checkoutId) {
        return ApiService.get(`/checkout-cart?ref=${checkoutId}`);
    },

    updateRowQuantity(rowId, quantity, checkoutId) {
        return ApiService.post(`/checkout-cart/update-quantity`, {
            row_id: rowId,
            quantity: quantity,
            checkout_id: checkoutId
        })
    },
    changeSelected(rowId, selected, checkoutId) {
        return ApiService.post(`/checkout-cart/change-selected`, {
            row_id: rowId,
            selected: selected,
            checkout_id: checkoutId
        })
    },
    changeSelectedStore(storeId, selected, checkoutId){
        return ApiService.post(`/checkout-cart/chane-selected-store`, {
            store_id: storeId,
            selected: selected,
            checkout_id: checkoutId
        })
    },
    updateShippingOption(storeId, shippingOptionId, checkoutId) {
        return ApiService.post(`/checkout-cart/update-shipping-option`, {
            store_id: storeId,
            shipping_option_id: shippingOptionId,
            checkout_id: checkoutId
        });
    },

    updateShippingInsurance(storeId, enableInsurance, checkoutId) {
        return ApiService.post(`/checkout-cart/update-shipping-insurance`, {
            store_id: storeId,
            enable_insurance: enableInsurance,
            checkout_id: checkoutId
        });
    },

    updateAddress(userAddressId, checkoutId) {
        return ApiService.post(`/checkout-cart/update-address`, {
            user_address_id: userAddressId,
            checkout_id: checkoutId
        });
    },

    saveOrder(cart) {
        return ApiService.post(`/checkout-cart/save-order`, {cart});
    },

    payment() {
        return ApiService.get(`/checkout-cart/payment`);
    },

    createPayment(paymentMethod, checkoutId) {
        return ApiService.post(`/checkout-cart/payment?ref=${checkoutId}`, {
            payment_method: paymentMethod
        })
    },

    getPaymentFeeentFee(paymentMethod, checkoutId) {
        return ApiService.post(`/checkout-cart/payment-fee?ref=${checkoutId}`,{
            payment_method: paymentMethod
        })
    }
};
