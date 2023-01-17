<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CheckoutRequest;
use App\Jobs\SendOrderConfirmToBuyerEmail;
use App\Jobs\SendOrderEmail;
use App\Model\UserAddress;
use App\Model\Product;
use App\Service\CartService;
use App\Service\OrderService;
use App\Service\PaymentService;
use App\Service\UserAddressService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
//    public function store(CheckoutRequest $request, OrderService $orderService, CartService $cartService)
//    {
//
//        $cart = ($request->isBuynow) ? Cart::instance('buynow') : Cart::instance('shopping');
//
//        // Check race condition when there are less items available to purchase
//        // check is price update
//        // create list products in cart sort by store_id
//        $productsInCart = [];
//        $isUpdated = false;
//        foreach ($cart->content() as $itemCart) {
//            $item = Product::with('store')->find($itemCart->id);
//            //check quality of product in stock
//            if ($item->quantity < $itemCart->qty) {
//                return response()->json(['errors' => ['Not enough ' . $item->name . ' in stock.']], 400);
//            }
//            //is price update
////            $item->price = priceDiscountNotFormat($item->price,$item->discount);
//            if ($item->presentPrice() - $itemCart->price != 0) {
//                $cart->update($itemCart->rowId, ['price' => $item->price]);
//                $isUpdated = true;
//            }
//
//            // create array list products in cart sort by store_id
//            $item['qty'] = $itemCart->qty;
//            $item['subtotal'] = $item->presentPrice() * $item['qty'];
//            $item['options'] = $itemCart->options->options;
//            $item['note'] = $itemCart->options->note;
//
//            if (empty($productsInCart[$item->store_id])) {
//                $productsInCart[$item->store_id] = array();
//            }
//            array_push($productsInCart[$item->store_id], $item);
//        }
//        if ($isUpdated) {
//            return response()->json(['errors' => ['One or more products have updated prices'], 'reload' => true], 400);
//        }
//        //save customer address if user check save address
//        $user = auth()->user();
//        if (isset($user) && ($request->saveContact == 1 || $request->saveAddress == 1)) {
//            $userAddress = UserAddress::updateOrCreate(
//                [
//                    'customer_id' => auth()->user()->id,
//                ],
//                [
//                    'recipient_name' => $request->recipient_name,
//                    'province_id'    => $request->province,
//                    'regency_id'     => $request->city,
//                    'district_id'    => $request->district,
//                    'addresses'      => $request->address,
//                    'phone'          => $request->phone,
//                ]
//            );
//        }
//
//        try {
//            //create payment
//            $checkout_id = uniqid();
//            $paymentService = new PaymentService();
//
//            $customer_id = (isset($user)) ? (string)$user->id : $request->phone;
//            $customer_email = (isset($user)) ? $user->email : 'customer_new@shukshuk.com';
//            $amount = $cart->total();
//            $description = 'Order created on ' . date('H:i d-m-Y');
//            //need checkout_id => to send url payment success
//            $invoice_options['success_redirect_url'] = route('checkout.success', $checkout_id);
////            $invoice_options['payment_methods'] = ['CREDIT_CARD'];
//            $paymentResponse = $paymentService->createInvoice($customer_id, $amount, $customer_email, $description,
//                $invoice_options);
//
//            if (array_key_exists('error_code', $paymentResponse)) {
//                throw new Exception($paymentResponse['error_code']);
//            }
//
//            // save payment info
//            $paymentInfo = $paymentService->createPayment($paymentResponse);
//
//            $orders = array();
//
//            foreach ($productsInCart as $key => $productsOfStore) {
//                //create orders by store
//                try {
//                    $order = $orderService->addToOrdersTables($request, $productsOfStore, $checkout_id, $paymentInfo,
//                        null);
//                } catch (Exception $e) {
//                    return response()->json(['errors' => [$e->getMessage()]], 400);
//                }
//                Log::info('send email queue ' . $order->id);
//                SendOrderEmail::dispatch($order)->delay(1);
////                $email = $order->store->seller->email ? $order->store->seller->email : 'seller@gmail.com';
////                Mail::to($email, $order->billing_name)->send(new OrderPlaced($order));
//                array_push($orders, $order);
//
//            }
//
//            //check create order is false
//            if (empty($orders)) {
//                return response()->json(['errors' => ['Sorry! Can not create the order.']], 400);
//            }
//            // decrease the quantities of all the products in the cart
//            $orderService->decreaseQuantities($cart);
//
//            $cart->destroy();
//            SendOrderConfirmToBuyerEmail::dispatch($user)->delay(1);
//            session()->forget('coupon');
//            return response()->json(['invoice_url' => $paymentResponse['invoice_url']]);
//
//        } catch (Exception $e) {
//            return response()->json(['errors' => [$e->getMessage()]], 400);
//        }
//    }

    public function saveOrder(
        CartService $cartService,
        OrderService $orderService,
        PaymentService $paymentService,
        UserAddressService $userAddressService,
        Request $request
    ) {
        $requestCart = $request->get('cart');

        $checkoutId = $requestCart['checkout_id'];
        $checkoutCart = $requestCart;
        $user = auth()->user();

        // @todo: double Check cart

        try {
            if (!$checkoutCart['buyer_address']) {
                throw new Exception('Please add your shipping address');
            }
            $shippingAddressId = $checkoutCart['buyer_address']['id'];
            if (!$shippingAddressId || !$shippingAddress = $userAddressService->getById($shippingAddressId)) {
                throw new Exception('Please choose your shipping address');
            }

            // Validate all store have shipping address
            foreach ($checkoutCart['store_orders'] as $storeOrder) {
                if (env('APP_ENV') == 'production' && !$storeOrder['shipping_option_id']) {
                    foreach ($storeOrder['products'] as $product){
                        if($product['selected']){
                            throw new Exception(
                                sprintf('Please select a shipping method for "%s" store', $storeOrder['name'])
                            );
                        }
                    }
                }
            }
            if($checkoutCart['total_items']==0){
                throw new Exception(
                    sprintf('Please select at least 1 item')
                );
            }

            return response()->json(['url' => route('checkout-cart.payment') . '?ref=' . $checkoutId]);

        } catch (Exception $e) {
            return response()->json(['errors' => [$e->getMessage()]], 400);
        }
    }

    public function createPayment(
        Request $request,
        CartService $cartService,
        OrderService $orderService,
        PaymentService $paymentService,
        UserAddressService $userAddressService
    ) {
        try {
            $checkoutCartId = $request->get('ref');
            if (!$checkoutCartId) {
                throw new Exception('Something wrong');
            }

            $checkoutCart = $cartService->getCheckoutCart($checkoutCartId);
            $user = auth()->user();

            // Validate cart
            $shippingAddressId = $checkoutCart['buyer_address']['id'];
            if (!$shippingAddressId || !$shippingAddress = $userAddressService->getById($shippingAddressId)) {
                throw new Exception('Please add your shipping address');
            }

            // Validate all store have shipping address
            foreach ($checkoutCart['store_orders'] as $storeOrder) {
                if (env('APP_ENV') == 'production' && !$storeOrder['shipping_option_id']) {
                    foreach ($storeOrder['products'] as $product){
                        if($product['selected']){
                            throw new Exception(
                                sprintf('Please select a shipping method for "%s" store', $storeOrder['name'])
                            );
                        }
                    }
                }
            }

            $validatedData = $request->validate([
                'payment_method' => 'required',
            ]);

            $paymentMethod = $request['payment_method'];


            // add payment fee
            $paymentFee = $paymentService->getFeePayment($checkoutCart['total'], $paymentMethod);
            $checkoutCart['total'] = $checkoutCart['total'] + $paymentFee;
            // Create payment
            $checkoutId = uniqid();
            $external_id = uniqid('SHUK-EXTERNAL-');
            $customerEmail = $user->email;
            $amount = $checkoutCart['total'];
            $description = 'Order created on ' . date('H:i d-m-Y');
            $invoiceOptions['success_redirect_url'] = route('checkout.success', $checkoutId);
            $invoiceOptions['payment_methods'] = $paymentMethod;
//            $invoiceOptions['payment_methods'] = ["BCA", "BRI", "MANDIRI", "BNI"];

            $paymentResponse = $paymentService->createInvoice(
                $external_id,
                $amount,
                $customerEmail,
                $description,
                $invoiceOptions
            );

            if (array_key_exists('error_code', $paymentResponse)) {
                throw new Exception($paymentResponse['error_code']);
            }

            // create payment
            $payment = $paymentService->createPayment($paymentResponse, $paymentFee);


            $orders = [];
            foreach ($checkoutCart['store_orders'] as $storeOrder) {
                if($storeOrder['selected']){
                    $orders[] = $orderService->saveOrder(
                        $user,
                        $storeOrder,
                        $shippingAddress,
                        $payment,
                        $checkoutId
                    );
                }
            }

            // Send email to customer
            foreach ($orders as $order) {
                try {
                    SendOrderEmail::dispatch($order)->delay(now()->addMinutes(1));
                    Log::info('Send a email to seller - new order');
                }catch (Exception $exception){
                    Log::error('Send email error - new order', $exception);
                }
            }

            // decrease the quantities of all the products in the cart
//            $orderService->decreaseQuantities($cart);

//            SendOrderConfirmToBuyerEmail::dispatch($user)->delay(1);
//            session()->forget('coupon');
//            session()->forget('checkout');

            return response()->json(['invoice_url' => $paymentResponse['invoice_url']]);
        } catch (Exception $e) {
            if($e->getMessage()=="UNAVAILABLE_PAYMENT_METHOD_ERROR"){

            }
            $message = ($e->getMessage() == "UNAVAILABLE_PAYMENT_METHOD_ERROR")?"payment method is faulty, please choose another method":$e->getMessage();
            return response()->json(['errors' => [$message]], 400);
        }

    }

    public function getPaymentFee(Request $request, CartService $cartService, PaymentService $paymentService)
    {
        if (!$checkoutId = $request->get('ref')) {
            throw new Exception('Something wrong');
        }

        $checkoutCart = $cartService->getCheckoutCart($checkoutId);
        return Response()->json(
            $paymentService->getFeePayment($checkoutCart['total'], $request['payment_method'])
        );
    }
}
