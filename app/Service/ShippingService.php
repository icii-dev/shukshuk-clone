<?php

namespace App\Service;

use App\Dto\Shipping\OrderShippingOptionItem;
use App\Events\OrderCancelled;
use App\Events\OrderPayForSeller;
use App\Events\ShippingFailed;
use App\Events\ShippingSucceed;
use App\Model\Order;
use App\Model\OrderShipping;
use App\Model\OrderShippingHistory;
use App\Shipment\Dto\ShipmentOption;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ShippingService
{
    /**
     * @var AnterajaService
     */
    private $anterajaService;

    /**
     * @var DCService
     */
    private $DCService;

//    /**
//     * @var OrderService
//     */
//    private $orderService;

    public function __construct(
        AnterajaService $anterajaService,
        DCService $DCService
//        OrderService $orderService
    )
    {
        $this->anterajaService = $anterajaService;
        $this->DCService = $DCService;
//        $this->orderService = $orderService;
    }

    public function findOptions($originId, $destinationId, $weight)
    {
        $weight = max($weight, 1000);
        $weight = min($weight, 5000);

        try {
            $response = $this->anterajaService->serviceRate($originId, $destinationId, $weight);
        } catch (\Exception $exception) {
            return [];
        }

        $responseBody = json_decode($response->getBody()->getContents(), true);

        $listServiceRate = Arr::get($responseBody, 'content.services');
        $dtoArrList = [];
        foreach ($listServiceRate as $serviceRate) {
            $shippingOptionItem = new OrderShippingOptionItem();
            $shippingOptionItem->id = $serviceRate['product_code'];
            $shippingOptionItem->name = $serviceRate['product_name'];
            $shippingOptionItem->cost = $serviceRate['rates'];
            $shippingOptionItem->description = $serviceRate['etd'];

            array_push($dtoArrList, $shippingOptionItem);
        }

        return $dtoArrList;
    }

    public function order($data)
    {
        $response = $this->anterajaService->order($data);

        return $response['content'];
    }

    public function orderToDC($data){
        $response = $this->DCService->postOrder($data);

        return $response;
    }

//    public function findOptions($originId, $destinationId)
//    {
//        $wrapper = [
//            "origin" => [
//                'id' => $originId
//            ],
//            'destination' => [
//                'id' => $destinationId
//            ],
//            'providers' => []
//        ];
//
//        $wrapper['providers'][] = $this->findAnterajaOptions($originId, $destinationId);
//
//        return $wrapper;
//    }

    private function findAnterajaOptions($originId, $destinationId)
    {
        return [
            "provider" => [
                "id"   => 1,
                "name" => 'Kanteraja'
            ],
            "options"  => [
                [
                    'id'       => 'REG',// product_code
                    'name'     => 'Regular', // product_name
                    'est_from' => '2',
                    'est_to'   => '4',
                    'cost'     => 130000,
                    'attrs'    => []
                ]
            ]
        ];
    }

    public function getShippingByReferrerId($referrerId)
    {
        $shipping = OrderShipping::where('shipping_referrer_id', $referrerId)
            ->first();

        return $shipping;
    }

    public function addHistoryFromPayload(OrderShipping $orderShipping, $payload)
    {
        $data = [
            'message'       => $payload['message'],
            'tracking_code' => $payload['tracking_code'],
            'action_at'     => new Carbon($payload['timestamp']),
        ];

        return $this->addHistory($orderShipping, $data);
    }

    public function addHistory(OrderShipping $orderShipping, $data)
    {
        $shippingHistory = new OrderShippingHistory($data);
        $shippingHistory->order_id = $orderShipping->order_id;

        $orderShipping->histories()->save($shippingHistory);

        // update order status
        $this->handleShippingStatusAfterCreatedHistory($shippingHistory);

        return $shippingHistory;
    }

    public function handleShippingStatusAfterCreatedHistory(OrderShippingHistory $shippingHistory)
    {
        /** @var OrderShipping $orderShipping */
        $orderShipping = $shippingHistory->orderShipping;

        /** @var Order $order */
        $order = $orderShipping->order;

        switch ((int)$shippingHistory->tracking_code) {
            case 250:
                $orderShipping->status = OrderShipping::STATUS_SHIPPED;
                $order->status = Order::STATUS_COMPLETED;

                $orderShipping->save();
                $order->save();
                // not pay for seller after finish ship, pay after 3 days
                break;
            case 430:
                $orderShipping->status = OrderShipping::STATUS_CANCELLED;
                $orderShipping->save();

                $order->status = Order::STATUS_CANCELLED;
                $order->save();

                event(new OrderCancelled($order));
                break;
            case 255:
                $orderShipping->status = OrderShipping::STATUS_RETURNED;
                $orderShipping->save();

                $order->status = Order::STATUS_CANCELLED;
                $order->save();

                event(new OrderCancelled($order));
                break;
            case 200:
                $orderShipping->status = OrderShipping::STATUS_IN_PROGRESS;
                $orderShipping->save();

                $order->status = Order::STATUS_SHIPPING;
                $order->save();

                break;
            case 100:
            case 150:
                $orderShipping->status = OrderShipping::STATUS_IN_PROGRESS;
                $orderShipping->save();
                //Order In progress = paid, STATUS_SCHEDULE_PICK_UP = waiting for the shipper to pick up the order
                $order->status = Order::STATUS_SCHEDULE_PICK_UP;
                $order->save();

                break;
            default:
                $orderShipping->status = OrderShipping::STATUS_IN_PROGRESS;
                $orderShipping->save();
                //khong luu status don hang tai day. Nhieu trang thai lam status quay ve trang thai truoc do cua don hang
                break;
        }
    }

    public function isEndStatus($status)
    {
        return in_array($status, [
           OrderShipping::STATUS_SHIPPED,
           OrderShipping::STATUS_CANCELLED,
           OrderShipping::STATUS_RETURNED
        ]);
    }

    /**
     * Get list overdue shipping to processing.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getListOverdueShipping()
    {
        $yesterday = new \DateTime();
        $yesterday->modify('-1day');

        $listShippings = OrderShipping::where('status', OrderShipping::STATUS_IN_PROGRESS)
            ->where('expect_finish', '<', $yesterday->format('Y-m-d H:i:s'))
            ->get();

        return $listShippings;
    }


    public function processAllOverdueShipping()
    {
        $listOverdueShipping = $this->getListOverdueShipping();

        foreach ($listOverdueShipping as $overdueShipping) {
            try {
                $this->processOverdueShipping($overdueShipping);
            }catch (\Exception $exception){
                \Log::channel('processAllOverdueShipping')->error('Error on: ' . $overdueShipping->order_id);
                \Log::channel('processAllOverdueShipping')->error('Error info: ' . $exception->getMessage());
            }
            \Log::channel('processAllOverdueShipping')->info('Checked order ' . $overdueShipping->order_id);
        }
    }

    public function processOverdueShipping(OrderShipping $orderShipping)
    {
        if ($this->isEndStatus($orderShipping->status)) {
            return;
        }

        $waybillNo = $orderShipping->shipping_referrer_id;

        $response = $this->anterajaService->tracking($waybillNo);
        $response = $response['content'];

        $histories = $response['history'];
        if($histories == null){
            return;
        }
        $response['waybill_no'];
        $response['order'];

        $lastHistory = $histories[0];// List histories response from api default sort by timestamp desc

        // Skip if shipping still in process
        if (!$this->anterajaService->isShippingEndStatus($lastHistory['tracking_code'])) {
            return;
        }

        // Update shipping history
        $this->syncShippingHistory($orderShipping, $histories);

        if ($this->anterajaService->isShippingSucceed($lastHistory['tracking_code'])) {
            // Update shipping status
            $orderShipping->status = OrderShipping::STATUS_SHIPPED;
            $orderShipping->save();

            // Fire event
            event(new ShippingSucceed($orderShipping));
        } else {
            // Update shipping status
            $orderShipping->status = OrderShipping::STATUS_CANCELLED;
            $orderShipping->save();

            // Fire event
            event(new ShippingFailed($orderShipping));
        }
    }

    public function syncShippingHistory(OrderShipping $orderShipping, $histories)
    {
        $existedShippingHistories = OrderShippingHistory::where('order_shipping_id', $orderShipping->id)
            ->get();

        $existedStatusCodes = $existedShippingHistories->map(function($existShippingHistory) {
            return $existShippingHistory->tracking_code;
        })->toArray();

        $histories = array_reverse($histories);// @todo: array_sort date

        foreach ($histories as $history) {
            if (!in_array($history['tracking_code'], $existedStatusCodes)) {
                $orderShippingHistory = new OrderShippingHistory();

                $orderShippingHistory->order_shipping_id = $orderShipping->id;
                $orderShippingHistory->order_id = $orderShipping->order_id;
                $orderShippingHistory->message = 'Call tracking API - ' . $history['message']['id'];
                $orderShippingHistory->tracking_code = $history['tracking_code'];
                $orderShippingHistory->action_at = (new \DateTime($history['timestamp']))->format('Y-m-d H:i:s');

                $orderShippingHistory->save();
            }
        }
    }
}
