<?php

// @todo: for test

use App\Jobs\SendEmailCancelOrder;
use Carbon\Carbon;


Route::get('lang/{locale}', function ($locale) {
    Session::put('lang',$locale);
    return redirect()->back();
})->name('lang');


Route::group(['as' => ''], function () {
    Route::get('/', 'Buyer\HomeController@index')->name('home');
    Route::get('wishlist', 'Buyer\WishlistController@index')->name('wishlist');

//    Route::get('store/category/{cat}/{sub_cat}/{rating}', 'Buyer\StoreController@sellerCategory')->name('store.category');
    Route::get('store/category/{type}/{category_slug}/{sub_cat}/{rating}',
        'Buyer\StoreController@sellerCategory')->name('store.category');
    Route::get('store/{slug}', 'Buyer\StoreController@index')->name('store.index');
    Route::get('store/preview/{slug}', 'Buyer\StoreController@index')->name('store.preview.index');
    Route::post('store/search-products', 'Buyer\StoreController@searchProducts')->name('store.search-products');
    Route::post('store/search-products-category',
        'Buyer\StoreController@searchProductsByCategory')->name('store.search-products-category');

    Route::get('product/{slug}', 'Buyer\ProductsController@show')->name('product.show');
    Route::get('product/view/{slug}', 'Buyer\ProductsController@view')->name('product.view');
    Route::get('product/category/{cat}/{sub_cat}/{rating}',
        'Buyer\ProductsController@category')->name('product.category');
    Route::get('product/reviews/{productID}', 'Buyer\ProductsController@reviewsPagination')->name('product.reviews');
    Route::post('/ajax/product/get-shipping-fee', 'Buyer\ProductsController@getShippingFee')->name('product.ajax.getShippingFee');

    //about
    Route::get('about/{slug}', 'Buyer\AboutController@index')->name('footer.about');

    Route::get('/thankyou', 'ConfirmationController@index')->name('confirmation.index');

    Route::get('/search/quick-response', 'Buyer\SearchController@quickSearch')->name('search.quick');
    Route::get('/search/quick-response/store/{id}',
        'Buyer\SearchController@quickSearchInStore')->name('search.quick.in-store');
    Route::get('/search', 'Buyer\SearchController@search')->name('search');
    Route::get('/search-algolia', 'ShopController@searchAlgolia')->name('search-algolia');

    Route::get('/auth/redirect/{social}', 'Auth\SocialAuthController@redirect')->name('auth.social');
    Route::get('/auth/callback/{social}', 'Auth\SocialAuthController@callback');


    // User address
    Route::get('/user-addresses', 'Buyer\UserAddressController@getList')->name('user-address.get-list');
    Route::get('/user-addresses/{id}', 'Buyer\UserAddressController@show')->name('user-address.get-one');
    Route::post('/user-addresses/create', 'Buyer\UserAddressController@create')->name('user-address.create');
    Route::post('/user-addresses/{id}/update', 'Buyer\UserAddressController@update')->name('user-address.update');
    Route::delete('/user-addresses/{id}', 'Buyer\UserAddressController@delete')->name('user-address.delete');
    Route::put('/user-addresses/{id}/set-default',
        'Buyer\UserAddressController@setDefault')->name('user-address.set-default');

    // Checkout
    Route::get('/checkout-cart', 'Buyer\CheckoutController@getCart')->name('checkout-cart');
//    Route::post('/checkout-cart/update-cart', 'Buyer\CheckoutController@updateCheckoutCart')->name('checkout-cart.update-quantity');
    Route::post('/checkout-cart/change-selected',
        'Buyer\CheckoutController@changeSelected')->name('checkout-cart.change-selected');
    Route::post('/checkout-cart/chane-selected-store',
        'Buyer\CheckoutController@changeSelectedForStore')->name('checkout-cart.change-selected-store');
    Route::post('/checkout-cart/update-quantity',
        'Buyer\CheckoutController@updateQuantity')->name('checkout-cart.update-quantity');
    Route::post('/checkout-cart/update-address',
        'Buyer\CheckoutController@updateAddress')->name('checkout-cart.update-address');
    Route::post('/checkout-cart/update-shipping-option',
        'Buyer\CheckoutController@updateShippingOption')->name('checkout-cart.update-shipping-option');
    Route::post('/checkout-cart/update-shipping-insurance',
        'Buyer\CheckoutController@updateShippingInsurance')->name('checkout-cart.update-shipping-insurance');

    Route::get('/checkout-cart/payment', 'Buyer\CheckoutController@payment')->name('checkout-cart.payment');
    Route::post('/checkout-cart/payment', 'Api\CheckoutController@createPayment')->name('checkout-cart.payment');
    Route::post('/checkout-cart/payment-fee',
        'Api\CheckoutController@getPaymentFee')->name('checkout-cart.payment-fee');
    Route::post('/checkout-cart/save-order', 'Api\CheckoutController@saveOrder')->name('checkout-cart.save-order');

    /*
         * Web hook
         */
    //update payment status
    Route::post('/payment-status', 'WebHook\XenditCallbackController@updatePaymentStatus')->name('payment.status');
    Route::post('/disbursement-update', 'WebHook\XenditCallbackController@updateDisbursement')->name('payment.status');

    Route::post('/shipment/callback', 'WebHook\ShipmentController@callback');
    Route::put('/shipment/callback', 'WebHook\ShipmentController@callback');
});

//user
Route::middleware('auth')->group(function () {
    Route::get('/checkout/{type}', 'Buyer\CheckoutController@index')->name('checkout.index');
    Route::get('/checkout-success/{checkout_id}', 'Buyer\CheckoutController@success')->name('checkout.success');

    Route::get('/my-profile', 'Buyer\UsersController@edit')->name('users.edit');
    Route::patch('/my-profile', 'Buyer\UsersController@update')->name('users.update');

    Route::get('/orders', 'Buyer\OrdersController@index')->name('users.orders');
    Route::get('/orders/{order}', 'Buyer\OrdersController@show')->name('order.show');
    Route::get('/orders/{order}/received', 'Buyer\OrdersController@received')->name('order.received');
    Route::get('/order/{order_id}/cancel', 'Buyer\OrdersController@cancel')->name('order.cancel');


    /* Messenger */
    Route::get('/messenger', 'Buyer\MessengerController@index')->name('buyer.messenger.index');
    Route::get('/messenger/{storeId}',
        'Buyer\MessengerController@initChatWithStore')->name('buyer.messenger.init_chat_with_store');
});

Route::group(['prefix' => 'admin', 'as' => ''], function () {
    if (App::environment('production', 'staging')) {
        URL::forceScheme('https');
    }
    Route::get('products/{id}/status/{status}', 'Admin\ProductsController@status')->name('admin.products.status');
    Route::get('products/{id}/featured/{status}', 'Admin\ProductsController@featured')->name('admin.products.featured');
    Route::put('components/{id}/delete_value',
        'Admin\ComponentsController@delete_value')->name('admin.components.delete_value');
    Route::delete('components/delete/{id}', 'Admin\ComponentsController@delete')->name('admin.components.delete');
    Route::get('components/{id}/move_up', 'Admin\ComponentsController@move_up')->name('admin.components.move_up');
    Route::get('components/{id}/move_down', 'Admin\ComponentsController@move_down')->name('admin.components.move_down');

    Route::put('users/{id}', 'Admin\UsersController@updateInfo')->name('admin.users.update');

    Route::get('stores/{id}/featured/{status}', 'Admin\StoresController@featured')->name('admin.stores.featured');
    Route::post('stores/{id}/approval', 'Admin\StoresController@approval')->name('admin.stores.approval');
    Route::get('stores/index', 'Admin\StoresController@index')->name('admin.stores.index');
    Route::get('stores/pending', 'Admin\StoresController@index')->name('admin.stores.pending');
    Route::get('stores/deactive', 'Admin\StoresController@index')->name('admin.stores.deactive');
    Route::get('stores/draft', 'Admin\StoresController@index')->name('admin.stores.draft');
//    Route::get('refunds', 'Admin\OrderRefundController@index')->name('admin.refunds');
    Route::get('refunds/{id}/edit', 'Admin\RequestRefundController@review')->name('admin.refund.edit');
    Route::put('refunds/update/{id}', 'Admin\RequestRefundController@createRefund')->name('admin.refund.update');
    Route::get('refund-requests', 'Admin\RequestRefundController@index')->name('admin.order-refunds');
    Voyager::routes();
});

Auth::routes();

Route::group(['as' => 'mobile.'], function () {
    Route::get('/register/mobile', 'Auth\RegisterController@registerMobileView')->name('register');
    Route::get('/login/mobile', 'Auth\LoginController@loginMobileView')->name('login');
    Route::get('/reset-password/mobile',
        'Auth\ForgotPasswordController@resetPasswordMobileView')->name('resetPassword');
});

// Seller
Route::middleware('auth')->prefix('/seller')->group(function () {
    /* Disbursement */
    Route::get('disbursement/ajax-get-banks',
        'Seller\DisbursementController@getBanks')->name('seller.disbursement.getBanks');
    Route::post('disbursement/ajax-withdraw',
        'Seller\DisbursementController@create')->name('seller.disbursement.withdraw');

    Route::middleware('not-seller')->group(function () {
        Route::get('/register', 'Seller\RegisterController@register')->name('seller.register');
        Route::get('/register/step-1', 'Seller\RegisterController@step1')->name('seller.register.step_1');
        Route::get('/register/step-2', 'Seller\RegisterController@step2')->name('seller.register.step_2');
        Route::get('/register/step-3', 'Seller\RegisterController@step3')->name('seller.register.step_3');

        Route::post('/register/step-1', 'Seller\RegisterController@postStep1');
        Route::post('/register/step-2', 'Seller\RegisterController@postStep2');
        Route::post('/register/step-3', 'Seller\RegisterController@postStep3');
    });

    /* Seller */
    Route::middleware('check-seller')->group(function () {
        Route::get('/', 'Seller\HomeController@index')->name('seller.home');

        /* Order */
        Route::get('/order/new', 'Seller\OrderController@listNew')->name('seller.order.index');
//        Route::get('/order/in-process', 'Seller\OrderController@listInprocess')->name('seller.order.schedule_pickup');
        Route::get('/order/schedule-pick-up',
            'Seller\OrderController@listSchedulePickup')->name('seller.order.schedule_pickup');
        Route::get('/order/shipping', 'Seller\OrderController@listShipping')->name('seller.order.list_shipping');
        Route::get('/order/completed', 'Seller\OrderController@listCompleted')->name('seller.order.list_completed');
        Route::get('/order/cancelled', 'Seller\OrderController@listCancelled')->name('seller.order.list_cancelled');

        Route::post('/order/{id}/ajax-change-status-to-in-process',
            'Seller\OrderController@ajaxChangeStatusToInprocess')->name('seller.order.ajax_change_status_to_in_process');
        Route::get('/order/{id}/ajax-proceed-by-dc',
            'Seller\OrderController@ajaxProceedByDC')->name('seller.order.ajax_proceed_by_dc');
        Route::post('/order/{id}/ajax-change-status-to-cancelled',
            'Seller\OrderController@ajaxChangeStatusToCancelled')->name('seller.order.ajax_change_status_to_in_cancelled');

        Route::get('/order/ajax-get-summary',
            'Seller\OrderController@ajaxGetSummary')->name('seller.order.ajax_get_summary');

        /* Product */
        Route::get('/product', 'Seller\ProductController@index')->name('seller.product.index');

        Route::get('/product/create', 'Seller\ProductController@create')->name('seller.product.create');
        Route::post('/product/create', 'Seller\ProductController@store');

        Route::get('/product/{id}/variant', 'Seller\ProductController@createProductVariant')->name('seller.product.create_product_variants');
        Route::post('/product/{id}/variant', 'Seller\ProductController@storeProductVariant');
//        Route::post('/product/{id}/variant/remove-photo', 'Seller\ProductController@removePhoto')->name('seller.product.create_product_variants.remove_photo');

        Route::get('/product/edit/{id}', 'Seller\ProductController@edit')->name('seller.product.edit');
        Route::post('/product/edit/{id}', 'Seller\ProductController@update');

        /* Promo */
        Route::get('/promo', 'Seller\PromoController@index')->name('seller.promo.index');

        /* Statistic */
        Route::get('/statistic', 'Seller\StatisticController@index')->name('seller.statistic.index');

        /* Payment */
        Route::get('/payment', 'Seller\PaymentController@index')->name('seller.payment.index');
        Route::get('/payment/banks', 'Seller\BankController@index')->name('seller.payment.banks');
        Route::get('/payment/banks/{bankId}', 'Seller\BankController@show')->name('seller.payment.banks.show');
        Route::patch('/payment/banks/{bankId}', 'Seller\BankController@update')->name('seller.payment.banks.update');
        Route::delete('/payment/banks/{bankId}', 'Seller\BankController@destroy')->name('seller.payment.banks.delete');
        Route::post('/payment/banks', 'Seller\BankController@store')->name('seller.payment.banks.store');

        /* Store */
        Route::get('/store/edit', 'Seller\StoreController@edit')->name('seller.store.edit');
        Route::post('/store/edit', 'Seller\StoreController@store');
        Route::post('/store/update-avatar', 'Seller\StoreController@updateAvatar')->name('seller.store.update_avatar');
        Route::post('/store/update-cover', 'Seller\StoreController@updateCover')->name('seller.store.update_cover');

        /* Notification */
        Route::get('/notification', function () {
            return 'Notification page';
        })->name('seller.notification.index');

        /* Messenger */
        Route::get('/messenger', 'Seller\MessengerController@index')->name('seller.messenger.index');
        Route::get('/messenger/{buyerId}', 'Seller\MessengerController@initChatWithBuyer')->name('seller.messenger.init_chat_with_buyer');

        /*
         * statistic
         */
        Route::get('statistic/balance', function (\App\Service\OrderService $orderService) {
            $store = auth()->user()->store;

            return $paged = $orderService->getListPagedOfStore(
                $store,
                request()->get('page', 1),
                100000,
                ['status' => [\App\Model\Order::STATUS_COMPLETED]]
            );
        });
    });
});

Route::get('test-tracking', function (\App\Service\ShippingService $shippingService) {
    $list = $shippingService->getListOverdueShipping();
    return $list;
});

Route::get('hotfix-banks', function (){
    $storeBanks = DB::table('store_bank')->get();
    foreach ($storeBanks as $storeBank){
        $bank = \App\Model\Bank::where('id', $storeBank->bank_id)->first();
        $bank->store_id=$storeBank->store_id;
        $bank->save();
    }
});


Route::get('test-payouts', 'Admin\OrderRefundController@createPayout');

Route::get('test', function (){
    $cancelDate = Carbon::now()->subDay(3);
   $order = \App\Model\Order::where('status', \App\Model\Order::STATUS_INPROCESS)
       ->whereDate('created_at', "<=", $cancelDate)
       ->first();
    SendEmailCancelOrder::dispatch(auth()->user(), $order->id)->delay(1);
});
