<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/cart', 'Api\CartController@index')->name('cart');
Route::post('/cart/add', 'Api\CartController@store')->name('cart.store');
Route::post('/cart/update', 'Api\CartController@update')->name('cart.store');
Route::post('/cart/remove', 'Api\CartController@remove')->name('cart.remove');
Route::get('cart/destroy', 'Api\CartController@destroyCart')->name('cart.destroy');
Route::post('/buynow/add', 'Api\CartController@buynow')->name('cart.store');

Route::get('wishlist/{idProduct}', 'Api\WishlistController@store')->name('wishlist.add');
Route::get('wishlist-store/{idStore}', 'Api\WishlistController@wishlistStore')->name('wishlistStore.add');

Route::post('/checkout','Api\CheckoutController@store')->name('checkout.store');

//indonesia address
Route::get('/get-list-cities/{province_id}', 'Api\AddressController@cities')->name('address.cities');
Route::get('/get-list-districts/{city_id}', 'Api\AddressController@districts')->name('address.districts');

// Address options
Route::get('/provinces', 'Api\AddressController@getListProvinceOption')->name('address.province-options');
Route::get('/provinces/{provinceId}/cities', 'Api\AddressController@getListCityOption')->name('address.city-options');
Route::get('/cities/{cityId}/districts', 'Api\AddressController@getListDistrictOption')->name('address.district-options');


//reviews & rating
Route::middleware('auth')->name('users.')->group(function () {
    Route::post('/reviews','Api\ReviewController@store')->name('reviews');
});

Route::post('/checkout/get-shipping-options', 'Api\CheckoutController@getShippingOptions');
