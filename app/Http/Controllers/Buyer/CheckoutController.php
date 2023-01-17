<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Model\AddressProvince;
use App\Model\Order;
use App\Model\Product;
use App\Model\OrderProduct;
use App\Mail\OrderPlaced;
use App\Model\ProductVariant;
use App\Service\CartService;
use App\Service\PaymentService;
use App\Service\ProductService;
use App\Service\StoreService;
use App\Service\UserAddressService;
use Gloudemans\Shoppingcart\CartItemOptions;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CheckoutRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index($type, Request $request)
    {
//        if ($type === 'buynow') {
//            $cart = Cart::instance('buynow');
//            $isBuynow = true;
//        } else {
//            $cart = Cart::instance('shopping');
//            $isBuynow = false;
//        }
//        $provinces = AddressProvince::with('cities')->get();
//        $userAddress = (Auth::user()) ? auth()->user()->address()->first() : null;
//        $cartTotal = $cart->total();
//        $cart = $cart->content();

        $ref = $request->get('ref', '');

        $this->seo()->setTitle(
            trans('checkout.title', [])
        );
        $this->seo()->setDescription(
            trans('checkout.description', [])
        );

//        // Group cart product by store.
//        $cartGrouped = collect($cart)->groupBy(function ($item) {
//            /** @var CartItemOptions $option */
//            $option = $item->options;
//
//            return $item->options->store['id'];
//        })->toArray();
//
//        $storeIds = array_map(function ($group) {
//            return Arr::get($group, '0.options.store.id');
//        }, $cartGrouped);
//
//        $stores = $storeService->getPublishedByIds($storeIds);
//
//        $shippingFee = [];
//        foreach ($stores as $store) {
//            $shippingFee[$store->id] = [
//                'id' => $store->id,
//                'store_address_id' => $store->district_id,
//                'buyer_address_id' => $userAddress ? $userAddress->district_id : null,
//                'fee' => 0,
//                'picked_option' => '',
//                'options' => ''
//            ];
//        }
//
//        session()->put('checkout.shipping_fee', $shippingFee);

        if ($type === 'buynow') {
            $isBuynow = true;
        } else {
            $isBuynow = false;
        }
//        if(is_mobile()){
//            return view('buyer.mobile.checkout')->with([
////            'provinces' => $provinces,
////            'userAddress' => $userAddress,
////            'cart' => $cart,
//                'isBuynow' => $isBuynow,
//                'ref'      => $ref
////            'cartTotal' => $cartTotal,
////            'cartGrouped' => $cartGrouped,
////            'shippingFee' => $shippingFee
//            ]);
//        }
        return view('buyer.checkout')->with([
//            'provinces' => $provinces,
//            'userAddress' => $userAddress,
//            'cart' => $cart,
            'isBuynow' => $isBuynow,
            'ref'      => $ref
//            'cartTotal' => $cartTotal,
//            'cartGrouped' => $cartGrouped,
//            'shippingFee' => $shippingFee
        ]);
    }


    public function success($checkout_id, ProductService $productService)
    {
        if (is_mobile()) {
            return view('buyer.mobile.checkout-success');
        }
        $orders = Order::with('products')->where('checkout_id', $checkout_id)->get();
        if (!$orders->count()) {
            abort(404);
        }
//        get all items in cart
        $cart = array();
        $total = 0;
        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                array_push($cart, $product);
            }
            $total += $order->billing_total;
        }

        // products also like
        $mightAlsoLike = $productService->getPagedRelated($product->id, 1, 5);
//        return $orders;
        // get status payment of invoice

        $this->seo()->setTitle(
            trans('checkout.success_title', [])
        );

        $this->seo()->setDescription(
            trans('checkout.success_description', [])
        );
        if(is_mobile()){
            return view('buyer.mobile.checkout-success')->with([
                'cart'  => $cart,
                'order' => $orders[0],
                'total' => $total,
            ]);
        }

        return view('buyer.checkout-success')->with([
            'cart'  => $cart,
            'order' => $orders[0],
            'total' => $total,
            'mightAlsoLike' => $mightAlsoLike,
        ]);
    }

    public function getCart(CartService $cartService, Request $request)
    {
        $checkoutId = $request->get('ref');

        if ($checkoutId) {
            return response()->json($cartService->getCheckoutCart($checkoutId, $request->get('buy-now-cart')));
        }

        return response()->json($cartService->getCheckoutCart(null, $request->get('buy-now-cart')));
    }

    public function updateCheckoutCartItemQuantity($rowId, Request $request, CartService $cartService)
    {
        $checkoutId = $request->get('checkout_id');

        $cartService->updateQuantityOfRowId(
            $rowId,
            $request->get('quantity'),
            $checkoutId
        );

        return response()->json(
            $cartService->getCheckoutCart($checkoutId)
        );
    }

    public function updateQuantity(Request $request, CartService $cartService)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:0,20'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => ['Quantity maximum 20 items']], 400);
        }

        //check stock
        $item = Cart::instance('shopping')->get($request->get('row_id'));
        $productId = $item->id;
        $productVariantId = $item->options->product_variant_id;
        $productVariant = ProductVariant::where('id', $productVariantId)->firstOrFail();
        if (!$cartService->isAvailableInStock($productId, $productVariant, $request->get('quantity'))) {
            return response()->json(['errors' => ['Sorry! We currently do not have enough items in stock.']], 400);
        }

        //update cart
        $checkoutId = $request->get('checkout_id');

        $cartService->updateQuantity(
            $request->get('row_id'),
            $request->get('quantity'),
            $checkoutId
        );

        return response()->json(
            $cartService->getCheckoutCart($checkoutId)
        );
    }

    public function changeSelected(Request $request, CartService $cartService){
        $checkoutId = $request->get('checkout_id');

        $cartService->changeSelected(
            $request->get('row_id'),
            $request->get('selected'),
            $checkoutId
        );

        return response()->json(
            $cartService->getCheckoutCart($checkoutId)
        );
    }

    public function changeSelectedForStore(Request $request, CartService $cartService){
        $checkoutId = $request->get('checkout_id');

        $cartService->changeSelectedForStore(
            $request->get('store_id'),
            $request->get('selected'),
            $checkoutId
        );

        return response()->json(
            $cartService->getCheckoutCart($checkoutId)
        );
    }

    public function updateAddress(Request $request, CartService $cartService, UserAddressService $userAddressService)
    {
        $userAddressId = $request->get('user_address_id');
        $checkoutId = $request->get('checkout_id');

        $userAddress = $userAddressService
            ->getUserAddressByIdForUser($userAddressId, auth()->user(), $checkoutId);

        if ($userAddress) {
            $cartService->setUserAddress($userAddress, $checkoutId);
            $userAddressService->setAsDefault($userAddress);
        }

        return response()->json(
            $cartService->getCheckoutCart($checkoutId)
        );
    }

    public function updateShippingOption(Request $request, CartService $cartService)
    {
        $storeId = $request->get('store_id');
        $shippingOptionId = $request->get('shipping_option_id');
        $checkoutId = $request->get('checkout_id');

        if ($storeId && $shippingOptionId) {
            $cartService->updateShippingOption($storeId, $shippingOptionId, $checkoutId);
        }

        return response()->json(
            $cartService->getCheckoutCart($checkoutId)
        );
    }

    public function updateShippingInsurance(Request $request, CartService $cartService)
    {
        $checkoutId = $request->get('checkout_id');
        $storeId = $request->get('store_id');
        $enableInsurance = (boolean)$request->get('enable_insurance');

        $cartService->updateShippingInsurance($storeId, $enableInsurance, $checkoutId);

        return response()->json(
            $cartService->getCheckoutCart($checkoutId)
        );
    }

    public function payment(Request $request)
    {
        if (!$checkoutId = $request->get('ref')) {
            return redirect('/');
        }
//        if(is_mobile()){
//            return view('buyer.mobile.checkout-payment', [
//                'checkoutId' => $checkoutId
//            ]);
//        }
        return view('buyer.checkout-payment', [
            'checkoutId' => $checkoutId
        ]);
    }
}
