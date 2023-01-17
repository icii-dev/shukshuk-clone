<?php

namespace App\Http\Controllers\Buyer;

use App\Model\Order;
use App\Model\Review;
use App\Service\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(OrderService $orderService){
        $user = auth()->user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        $orderStatistics = $orderService->statistics($orders);
        $this->seo()->setTitle(
            trans('order.title', [])
        );
        $this->seo()->setDescription(
            trans('order.description', [])
        );

        if(is_mobile()){
            return view('buyer.mobile.orders')->with([
                'orders' => $orders,
            ]);
        }
        return view('buyer.order.index')->with([
            'orderStatistics' => $orderStatistics,
        ]);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Order $order, OrderService $orderService)
    {
        if (auth()->id() !== $order->user_id && !auth()->user()->hasPermission('browse_orders')) {
            return abort(403,'You do not have access to this!');
        }

        $products=$order->products;

        $BillingTotal = $orderService->getBillingTotal($order);

        $review = Review::where('user_id',auth()->user()->id)
                        ->where('order_id', $order->id)
                        ->first('id');
        $isReview = $review ? true : false;

        $canCancelOrder = $orderService->canCancelOrder($order);

        $orderShiping = $order->orderShipping;
        $orderTracking = isset($orderShiping->shipping_referrer_id) ? $orderShiping->shipping_referrer_id : null;

        $view = is_mobile() ? 'buyer.mobile.order-detail' : 'buyer.order.order-detail';

        return view($view)->with([
            'order'=>$order,
            'products'=>$products,
            'paymentFee'=> $BillingTotal['paymentFee'],
            'BillingTotal'=>$BillingTotal['total'],
            'canCancelOrder' => $canCancelOrder,
            'orderTracking' => $orderTracking,
            'isReview' => $isReview
        ]);
    }

    public function cancel($order_id, OrderService $orderService){
        $user = auth()->user();
        $order = Order::whereId($order_id)->where('user_id', $user->id)->first();
        if(!$order){
            return response()->json([
                'error'=> 'Access Denied'
            ], 403);
        }
        $orderService->cancelOrder($order, true);
        return redirect()->route('users.orders');
    }

    public function received($order_id, OrderService $orderService){
        $user = auth()->user();
        $order = Order::whereId($order_id)->where('user_id', $user->id)->first();
        if(!$order){
            return response()->json([
                'error'=> 'Access Denied'
            ], 403);
        }
        $orderService->updateStatusTo($order, Order::STATUS_COMPLETED);
        return redirect()->route('users.orders');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
