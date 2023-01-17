
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated.js';

/* Fitler */
Vue.use(require('vue-moment'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import filters from './common/filters';

// Vue.component('example', require('./components/Example').default);
// Vue.component('blog-posts', require('./components/BlogPosts').default);

Vue.component('chat-button-to-buyer', require('./components/seller/ChatButtonToBuyer').default);
Vue.component('chat-button', require('./components/ChatButton').default);
Vue.component('count-unread', require('./components/CountUnread').default);
Vue.component('checkout', require('./components/Checkout').default);
Vue.component('checkout-payment', require('./components/CheckoutPayment').default);
Vue.component('user-address', require('./components/UserAddress').default);
Vue.component(
    'messenger',
    require('./components/Messenger').default
);

Vue.mixin({
    methods: {
        confirm(message) {
            return confirm(message);
        },

        errorMessage(message) {
            $.notify({
                content : message,
                alertType: "alert-danger",
                timeout: 8000,
            });
        },

        successMessage(message) {
            $.notify({
                content : message,
                alertType: "alert-success",
                timeout: 8000,
            });
        },

        warningMessage(message) {
            $.notify({
                content : message,
                alertType: "alert-warning",
                timeout: 8000,
            });
        },

        showLoading(message) {
            $('.loading-container').show();
        },

        hideLoading(message) {
            $('.loading-container').hide();
        }

    }
});

Vue.use(VueInternationalization);
const i18n = new VueInternationalization({
    locale: document.head.querySelector('meta[name="locale"]').content,
    messages: Locale
});

const app = new Vue({
    el: '#app',
    i18n
});

Vue.prototype.$log = console.log;
