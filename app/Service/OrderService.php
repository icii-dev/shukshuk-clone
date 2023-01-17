<?php

namespace App\Service;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Jobs\SendEmailCancelOrder;
use App\Model\OrderRefund;
use App\Model\Payment;
use App\Model\ProductVariant;
use App\Model\Store;
use App\Model\User;
use App\Model\UserAddress;
use App\Model\OrderShipping;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Model\Product;
use App\Model\Order;
use App\Model\OrderProduct;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\True_;

class OrderService
{
    /**
     * @var UserAddressService
     */
    private $userAddressService;
    /**
     * @var ShippingService
     */
    private $shippingService;

    public function __construct(
        UserAddressService $userAddressService,
        ShippingService $shippingService
    ) {
        $this->userAddressService = $userAddressService;
        $this->shippingService = $shippingService;
    }

    /**
     * Get order of store by id
     *
     * @param Store $store
     * @param $orderId
     * @return Store|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getOrderOfStoreById(Store $store, $orderId)
    {
        $order = $store->orders()
            ->where('id', '=', $orderId)
            ->first();

        return $order;
    }

    public function checkOrderEmpty()
    {
        Cart::instance('shopping')->content();
    }

    public function saveOrder(
        User $user,
        $storeOrder,
        UserAddress $shippingAddress,
        Payment $payment,
        $checkoutId,
        $error = null
    ) {
        $order = Order::create([
            'id' => uniqid('SHUK-ID-'),// . random_int(1, 10000),

            'user_id' => $user->id,

            'billing_email'    => '',
            'billing_name'     => $shippingAddress->recipient_name,
            'billing_address'  => $shippingAddress->addresses,
            'billing_province' => $shippingAddress->province_id,
            'billing_city'     => $shippingAddress->regency_id,
            'billing_district' => $shippingAddress->district_id,
            'billing_phone'    => $shippingAddress->phone,

            'billing_name_on_card'  => '', // @todo:
            'billing_discount_code' => '',// @todo;

            'billing_subtotal'      => $storeOrder['subtotal'],
            'billing_tax'           => 0, // @todo:
            'billing_discount'      => $storeOrder['discount_amount'], // @todo:
            'billing_insurance_fee' => $storeOrder['insurance_fee'],
            'billing_shipping_fee'  => $storeOrder['shipping_fee'],
            'billing_total'         => $storeOrder['total'],

            'total_weight'    => $storeOrder['total_weight'],
            'shipping_option' => $storeOrder['shipping_option_id'],

            'error'       => $error,
            'store_id'    => $storeOrder['id'],
            'payment_id'  => $payment->id,
            'checkout_id' => $checkoutId,
        ]);

        // Save store detail
        foreach ($storeOrder['products'] as $product) {
            if ($product['selected']) {
                OrderProduct::create([
                    'order_id'           => $order->id,
                    'product_id'         => $product['id'],
                    'name'               => $product['name'],
                    'weight'             => $product['weight'],
                    'quantity'           => $product['quantity'],
                    'options'            => $product['options'],
                    'product_variant_id' => $product['product_variant_id'],
                    'subtotal'           => $product['total'],
                    'note'               => $product['note'],
                    'thumbnail'          => $product['thumbnail'],
                ]);
                foreach (Cart::instance('shopping')->content() as $key => $row) {
                    if ($key == $product['row_id']) {
                        Cart::instance('shopping')->remove($product['row_id']);
                    }
                }
                $this->updateProductSold($product['id'], $product['quantity']);
            }
        }

        //update variant quantity (stock)
        $productVariant = ProductVariant::find($product['product_variant_id']);
        $productVariant->quantity -= $product['quantity'];
        $productVariant->save();

        return $order;
    }

    public function updateProductSold($productId, $qty){
        $product = Product::find($productId);
        if ($product){
            $product->sold += $qty;
            $product->save();
        }
    }

    public function addToOrdersTables($request, $productsOfStore, $checkout_id, $paymentInfo, $error)
    {
        // Insert into orders table
        $order = Order::create([
            'id'                    => uniqid('SHUK-ID-'),
            'user_id'               => auth()->user() ? auth()->user()->id : null,
            'billing_email'         => $request->email,
            'billing_name'          => $request->recipient_name,
            'billing_address'       => $request->address,
            'billing_province'      => $request->province,
            'billing_city'          => $request->city,
            'billing_district'      => $request->district,
            'billing_phone'         => $request->phone,
            'billing_name_on_card'  => $request->name_on_card,
            'billing_discount'      => $this->getValues($productsOfStore)->get('discount'),
            'billing_discount_code' => $this->getValues($productsOfStore)->get('code'),
            'billing_subtotal'      => $this->getValues($productsOfStore)->get('newSubtotal'),
            'billing_tax'           => $this->getValues($productsOfStore)->get('newTax'),
            'billing_total'         => $this->getValues($productsOfStore)->get('newTotal'),
            'error'                 => $error,
            'store_id'              => reset($productsOfStore)->store_id,
            'payment_id'            => $paymentInfo->id,
            'checkout_id'           => $checkout_id,
        ]);

        // Insert into order_product table
        if ($order) {
            foreach ($productsOfStore as $item) {
                OrderProduct::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->id,
                    'quantity'   => $item->qty,
                    'options'    => $item->options,
                    'subtotal'   => $item->subtotal,
                    'note'       => $item->note,
                ]);
            }
        }

        return $order;
    }

    public function decreaseQuantities($cart)
    {
        foreach ($cart as $item) {
            $product = Product::find($item->id);

            $product->update(['quantity' => $product->quantity - $item->qty]);
        }
    }

    public function getListPagedOfStore(Store $store, $page = 1, $limit = 25, $conditions = [])
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        /** @var Builder $qb */
        $qb = $store->orders();
//        $qb = OrderResource::collection($store->orders);
        // Build conditions
        if (isset($conditions['status'])) {
            $qb->whereIn('status', $conditions['status']);
        }

        // Build sort
        $qb->orderBy('created_at', 'DESC');
//        $qb->limit($limit);

        $data = new OrderCollection($qb->paginate($limit));

        return $data;
    }

    public function getSummaryOrderStatusOfStore(Store $store)
    {
        $results = DB::table('orders')
            ->select(DB::raw('count(*) as total, status'))
            ->whereStoreId($store->id)
            ->groupBy(['status'])
            ->get();

        return array_replace(
            [
                Order::STATUS_NEW              => 0,
                Order::STATUS_INPROCESS        => 0,
                Order::STATUS_SCHEDULE_PICK_UP => 0,
                Order::STATUS_SHIPPING         => 0,
                Order::STATUS_COMPLETED        => 0,
                Order::STATUS_CANCELLED        => 0
            ],
            Arr::pluck($results, 'total', 'status')
        );
    }

    public function updateStatusTo(Order $order, $status)
    {
        if ($status == Order::STATUS_CANCELLED) {
            $this->cancelOrder($order);
        }
        $order->status = $status;
        $order->save();
    }

    public function canCancelOrder(Order $order)
    {
        switch ($order->status) {
            case Order::STATUS_NEW:
            case Order::STATUS_INPROCESS:
                return true;
            default:
                return false;
        }

    }

    public function cancelOrder(Order $order, $isBuyerCancel = false)
    {
        if ($this->canCancelOrder($order)) {
            $order->status = Order::STATUS_CANCELLED;
            if ($this->isOrderPaid($order)) {
                $order->refund_status = Order::REFUND_REQUEST;
            }
            $order->is_buyer_cancel = $isBuyerCancel;
            $order->save();
            return true;
        }
        return false;
    }

    public function isOrderPaid(Order $order)
    {
        if ($order->payment->status == Payment::STATUS_PAID) {
            return true;
        }
        return false;
    }

    public function getTotalNewOrderOfStore(Store $store)
    {
        return $store->orders()->whereStatus(Order::STATUS_NEW)
            ->count();
    }

    public function getTotalNewOrderOfBuyer(User $user)
    {
        return $user->orders()->whereStatus(Order::STATUS_NEW)->count();
    }

    public function getValues($productsOfStore = null)
    {
        $subtotal = 0;
        foreach ($productsOfStore as $item) {
            $subtotal += $item->subtotal;
        }
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $code = session()->get('coupon')['name'] ?? null;
        $newSubtotal = ($subtotal - $discount);
        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax);

        return collect([
            'tax'         => $tax,
            'discount'    => $discount,
            'code'        => $code,
            'newSubtotal' => $newSubtotal,
            'newTax'      => $newTax,
            'newTotal'    => $newTotal,
        ]);
    }

    public function initShipping(Order $order)
    {
        /** @var OrderShipping $orderShipping */
        $orderShipping = $order->orderShipping()->firstOrCreate([]);

        if ($orderShipping->status != null) {
            return $orderShipping;
        }

        $orderShipping->status = OrderShipping::STATUS_CREATED;

        // Shipper address
        $orderShipping->shipper_name = object_get($order, 'store.name');
        $orderShipping->shipper_phone = object_get($order, 'store.phone');
        $orderShipping->shipper_district = object_get($order, 'store.district.ship_code');
        $orderShipping->shipper_address = object_get($order, 'store.address');
        $orderShipping->shipper_district_id = object_get($order, 'store.district.id');

        // Options
        $orderShipping->shipping_option = $order->shipping_option;
        $orderShipping->cost = $order->billing_shipping_fee;

        $orderShipping->save();

        return $orderShipping;
    }

    public function orderShipping(Order $order, \DateTime $requestPickupAt = null)
    {
        $dataTemplate = [
            'booking_id'          => null,
            'service_code'        => null,
            'shipper'             => [
                'name'     => '',
                'phone'    => '',
                'district' => '',
                'address'  => '',
            ],
            'receiver'            => [
                'name'     => '',
                'phone'    => '',
                'district' => '',
                'address'  => '',
            ],
            'items'               => [],
            'use_insurance'       => false,
            'declared_value'      => '',
            'parcel_total_weight' => '',
        ];

        $itemTemplate = [
            'item_name'      => '',
            'item_desc'      => '',
            'item_category'  => '',
            'declared_value' => '',
            'weight'         => '',
        ];

        $data = $dataTemplate;

        $data['booking_id'] = $order->id;
        $data['service_code'] = $order->shipping_option;
        $data['use_insurance'] = $order->billing_insurance_fee ? true : false;
//        $data['declared_value'] = $order->billing_total;
        $data['parcel_total_weight'] = $order->total_weight;

        if ($requestPickupAt) {
            $data['expect_time'] = $requestPickupAt->format('Y-m-d H:i:s');
        }

        // Shipper
        $data['shipper']['name'] = object_get($order, 'store.name');
        $data['shipper']['phone'] = cleanPhoneNum(object_get($order, 'store.seller.phone'));
        $data['shipper']['district'] = object_get($order, 'store.district.ship_code');
        $data['shipper']['address'] = clean(object_get($order, 'store.address'));// @check address is right
//        $data['shipper']['postcode'] = object_get($order, 'store.address');// @check address is right
        $data['shipper']['postcode'] = "";

        // Receiver
        $data['receiver']['name'] = $order->billing_name;
        $data['receiver']['phone'] = cleanPhoneNum($order->billing_phone);
        $data['receiver']['district'] = $order->district->ship_code;
        $data['receiver']['address'] = clean($order->billing_address);
//        $data['receiver']['postcode'] = $order->billing_address;
        $data['receiver']['postcode'] = "";

        $totalDeclaredValue = 0;
        foreach ($order->orderProducts as $orderProduct) {
            $_item = $itemTemplate;

            $_item['item_name'] = $orderProduct->product->name;
            $_item['item_desc'] = 'Qty: ' . $orderProduct->quantity;
            $_item['item_category'] = '';
            $_item['declared_value'] = $orderProduct->subtotal;
            $_item['weight'] = $orderProduct->weight;

            $totalDeclaredValue += $orderProduct->quantity * $orderProduct->subtotal;
            $data['items'][] = $_item;
        }

        $data['declared_value'] = $totalDeclaredValue;

        // Create shipping
        /** @var OrderShipping $orderShipping */
        $orderShipping = $order->order_shipping;

        if (!$orderShipping) {
            $orderShipping = $this->initShipping($order);
        }

        try {
            $responseContent = $this->shippingService->order($data);

            $orderShipping->shipping_referrer_id = $responseContent['waybill_no'];
            $orderShipping->expect_start = $responseContent['expect_start'];
            $orderShipping->expect_finish = $responseContent['expect_finish'];
            $orderShipping->status = OrderShipping::STATUS_IN_PROGRESS;

            $orderShipping->save();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());

            $orderShipping->status = OrderShipping::STATUS_RETRY;
            $orderShipping->save();

            throw $exception;
        }
        return 's';
        return $orderShipping;
    }

    public function proceedByDC(Order $order){
        $dataTemplate = [
            'reference_id' => '',
            'dc_id' => '',
            'store_id' => '',
            'delivery_unit' => '',
            'weight' => null,
            'billing_email' => '',
            'billing_name' => '',
            'billing_address' => '',
            'billing_province' => '',
            'billing_city' => '',
            'billing_district' => '',
            'billing_phone' => '',
            'billing_subtotal' => null,
            'billing_shipping_fee' => null,
            'billing_insurance_fee' => null,
            'billing_payment_fee' => null,
            'billing_tax' => null,
            'billing_total' => null,
            'products' => []
        ];

        $productTemplate = [
            'name' => '',
            'reference_id' => '',
            'description' => '',
            'quantity' => null,
            'price' => null,
            'options' => null,
            'thumbnail' => '',
            'weight' => null
        ];

        $store = $order->store;
        $data = $dataTemplate;

        $data['reference_id'] = $order->id;
        $data['dc_id'] = $store->DC->reference_id;
        $data['store_id'] = $store->id;
        $data['delivery_unit'] = 'Anteraja';
        $data['weight'] = $order->total_weight;
        $data['billing_email'] = $order->billing_email;
        $data['billing_name'] = $order->billing_name;
        $data['billing_district'] = $order->district->ship_code;
        $data['billing_address'] = clean($order->billing_address);
        $data['billing_phone'] = cleanPhoneNum($order->billing_phone);;
        $data['billing_subtotal'] = $order->billing_subtotal;
        $data['billing_shipping_fee'] = $order->billing_shipping_fee;
        $data['billing_insurance_fee'] = $order->billing_insurance_fee;
        $data['billing_payment_fee'] = $order->billing_payment_fee;
        $data['billing_tax'] = $order->billing_tax;
        $data['billing_total'] = $order->billing_total;

        foreach ($order->orderProducts as $orderProduct) {
            $_item = $productTemplate;
            $product = $orderProduct->product;
            $_item['name'] = $product->name;
            $_item['reference_id'] = $product->id;
            $_item['description'] = $product->description;
            $_item['quantity'] = $orderProduct->quantity;
            $_item['price'] = $orderProduct->subtotal;
            $_item['options'] = $orderProduct->options;
            $_item['weight'] = $orderProduct->weight;
            $_item['thumbnail'] = $product->image;

            $data['products'][] = $_item;
        }

        // Create shipping
        /** @var OrderShipping $orderShipping */
        $orderShipping = $order->order_shipping;

        if (!$orderShipping) {
            $orderShipping = $this->initShipping($order);
        }

        try {
            $responseContent = $this->shippingService->orderToDC($data);
            if ($responseContent->getStatusCode()!=200){
                $orderShipping->status = OrderShipping::STATUS_RETRY;
                $orderShipping->save();
            }
            $orderShipping->status = OrderShipping::STATUS_IN_PROGRESS;
            $orderShipping->save();

            $this->updateStatusTo($order, Order::STATUS_SCHEDULE_PICK_UP);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());

            $orderShipping->status = OrderShipping::STATUS_RETRY;
            $orderShipping->save();

            throw $exception;
        }

        return $data;
    }

    public function statistics(Object $orders)
    {
        $result = [
            'NEW'             => [],
            'INPROCESS'       => [],
//            'SCHEDULE_PICKUP' => [],
            'COMPLETED'       => [],
            'CANCELLED'       => [],
            'SHIPPING'        => [],
        ];
        foreach ($orders as $order) {
            switch ($order->status) {
                case Order::STATUS_NEW:
                    array_push($result['NEW'], $order);
                    break;
                case Order::STATUS_SCHEDULE_PICK_UP:
                case Order::STATUS_INPROCESS :
                    array_push($result['INPROCESS'], $order);
                    break;
                case Order::STATUS_SHIPPING:
                    array_push($result['SHIPPING'], $order);
                    break;
                case Order::STATUS_COMPLETED:
                    array_push($result['COMPLETED'], $order);
                    break;
                case Order::STATUS_CANCELLED:
                    array_push($result['CANCELLED'], $order);
                    break;
                default :
                    break;
            }
        }
        return $result;
    }

    function saveOrderRefund(Order $order, $status)
    {
        OrderRefund::updateOrInsert([
            'order_id'       => $order->id,
            'user_id'        => $order->user->id,
            'payment_id'     => $order->payment->id,
            'store_id'       => $order->store->id,
            'billing_tax'    => $order->billing_tax,
            'billing_refund' => $this->getRefundAmount($order),
            'status'         => $status,
        ]);
    }

    /*
     * Multiple orders have the same payment fee
     */
    function getBillingTotal(Order $order)
    {
//        $totalOrders = Order::where('payment_id',$order->payment->id)->count();
//        $paymentFeeForeachOrder= ($order->payment->payment_fee)/($totalOrders);
        $paymentFee = $order->payment->payment_fee;
        $total = $order->billing_total + $paymentFee;
        return $BillingTotal = [
            'paymentFee' => $paymentFee,
            'total'      => $total
        ];
    }

    function getRefundAmount(Order $order)
    {
        if ($order->is_buyer_cancel) {
            $amount = $order->billing_subtotal - 5500;
        } else {
            $amount = $order->billing_subtotal;
        }
        return $amount;
    }

    function getInactiveOrders()
    {
        $inactiveDate = Carbon::now()->subDay(5);
        return \App\Model\Order::where('status', \App\Model\Order::STATUS_INPROCESS)
            ->whereDate('created_at', "<=", $inactiveDate)
            ->get();
    }

    function systemCancel(Order $order)
    {
        $order->status = \App\Model\Order::STATUS_CANCELLED;
        $order->save();
        Log::channel('order_history')->info("\nAUTO-CANCEL: " . $order->id);
        SendEmailCancelOrder::dispatch($order->user, $order->id)->delay(1);
    }
}
