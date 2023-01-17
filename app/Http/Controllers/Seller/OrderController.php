<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\SellerController;
use App\Http\Resources\OrderResource;
use App\Jobs\SendEmailCancelOrder;
use App\Jobs\SendOrderEmail;
use App\Model\Order;
use App\Service\OrderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Mail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends SellerController
{
    /**
     * @var OrderService
     */
    private $pagedervice;

    public function __construct(
        OrderService $pagedervice
    ) {
        $this->orderService = $pagedervice;
    }

    public function listNew()
    {

        $store = auth()->user()->store;

        $paged = $this->orderService->getListPagedOfStore(
            $store,
            request()->get('page', 1),
            10,
            ['status' => [Order::STATUS_NEW, Order::STATUS_INPROCESS]]
        );

//        dd($paged);

        if (\request()->ajax()) {
            return \response()->json([
                'status' => 1,
                'html_data' => view('seller.order._list_order', ['paged' => $paged])->render(),
                'current_page' => $paged->currentPage(),
                'is_next_page' => $paged->currentPage() < $paged->lastPage() ? 1 : 0
            ], 200);
        }

        return view('seller.order.index', [
            'paged' => $paged,
            'status' => Order::STATUS_NEW
        ]);
    }

    public function listSchedulePickup()
    {
        $store = auth()->user()->store;

        $paged = $this->orderService->getListPagedOfStore(
            $store,
            request()->get('page', 1),
            10,
            ['status' => [Order::STATUS_SCHEDULE_PICK_UP]]
        );

        return view('seller.order.index', [
            'paged' => $paged,
            'status' => Order::STATUS_INPROCESS
        ]);
    }

    public function listShipping()
    {

        $store = auth()->user()->store;

        $paged = $this->orderService->getListPagedOfStore(
            $store,
            request()->get('page', 1),
            10,
            ['status' => [Order::STATUS_SHIPPING]]
        );

//        dd($paged);

        if (\request()->ajax()) {
            return \response()->json([
                'status' => 1,
                'html_data' => view('seller.order._list_order', ['paged' => $paged])->render(),
                'current_page' => $paged->currentPage(),
                'is_next_page' => $paged->currentPage() < $paged->lastPage() ? 1 : 0
            ], 200);
        }

        return view('seller.order.index', [
            'paged' => $paged,
            'status' => Order::STATUS_SHIPPING
        ]);
    }

    public function listCompleted()
    {
        $store = auth()->user()->store;

        $paged = $this->orderService->getListPagedOfStore(
            $store,
            request()->get('page', 1),
            10,
            ['status' => [Order::STATUS_COMPLETED]]
        );

        return view('seller.order.index', [
            'paged' => $paged,
            'status' => Order::STATUS_COMPLETED
        ]);
    }

    public function listCancelled()
    {
        $store = auth()->user()->store;

        $paged = $this->orderService->getListPagedOfStore(
            $store,
            request()->get('page', 1),
            10,
            ['status' => [Order::STATUS_CANCELLED]]
        );

        return view('seller.order.index', [
            'paged' => $paged,
            'status' => Order::STATUS_CANCELLED
        ]);
    }

//    public function ajaxGetOrderDetail($orderId)
//    {
//        $store = auth()->user()->store;
//
//        $order = $this->orderService->getOrderOfStoreById($store, $orderId);
//
//        if (!$order) {
//            return \response()->json([
//                'error' => [
//                    'message' => 'The order does not exist'
//                ]
//            ], Response::HTTP_NOT_FOUND);
//        }
//
//        return \response()->json([
//            'success' => true
//        ]);
//    }

    public function ajaxChangeStatusToCancelled($id)
    {
        $store = auth()->user()->store;

        $order = $this->orderService->getOrderOfStoreById($store, $id);
        if (!$order) {
            return \response()->json([
                'error' => [
                    'message' => 'The order does not exist'
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        $cancel = $this->orderService->cancelOrder($order);
        if($cancel){
//            Mail::to($order->user->email)->send(new \App\Mail\CancelOrder($order->user, $order->id));
            SendEmailCancelOrder::dispatch($order->user, $order->id)->delay(1);
        }

        return \response()->json([
            'success' => true
        ]);
    }

    public function ajaxChangeStatusToInProcess($id, Request $request)
    {
        $store = auth()->user()->store;
        $requestPickupAt = Carbon::parse($request->expect_time);
        $order = $this->orderService->getOrderOfStoreById($store, $id);

        if (!$order) {
            return \response()->json([
                'error' => [
                    'message' => 'The order does not exist'
                ]
            ], Response::HTTP_NOT_FOUND);
        }
        try {
            $this->orderService->orderShipping($order, $requestPickupAt);
            $this->orderService->updateStatusTo($order, Order::STATUS_SCHEDULE_PICK_UP);

        }catch (\ErrorException $exception){
            return Response()->json(
                [
                    'error' => [
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode()
                    ]
                    ] ,
                500
            );
        }

        return \response()->json([
            'success' => true
        ]);
    }

    public function ajaxProceedByDC($id){
        $store = auth()->user()->store;
        $order = $this->orderService->getOrderOfStoreById($store, $id);
        if (!$order) {
            return \response()->json([
                'error' => [
                    'message' => 'The order does not exist'
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        try {
//            $this->orderService->updateStatusTo($order, Order::STATUS_SCHEDULE_PICK_UP);
            return $this->orderService->proceedByDC($order);
        }catch (\ErrorException $exception){
            return Response()->json(
                [
                    'error' => [
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode()
                    ]
                ] ,
                500
            );
        }


        return \response()->json([
            'success' => true
        ]);
    }

    public function ajaxGetSummary()
    {
        $store = auth()->user()->store;

        $summary = $this->orderService->getSummaryOrderStatusOfStore($store);

        return \response()->json($summary);
    }
}
