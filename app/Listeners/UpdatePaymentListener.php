<?php

namespace App\Listeners;

use App\Events\UpdatePayment;
use App\Mail\PaymentFailure;
use App\Mail\PaymentSuccess;
use App\Model\Order;
use App\Model\PaymentHistory;
use Carbon\Carbon;
use Mail;

class UpdatePaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdatePayment  $event
     * @return void
     */
    public function handle(UpdatePayment $event)
    {
        //update payment status
        $payment = $event->payment;
        $data = $event->data;

        $payment->status = $data['status'];
        $payment->paid_amount = $data['amount'];
        $payment->currency = array_key_exists('currency', $data)
            ?$data['currency']:$payment->currency;
        $payment->method = array_key_exists('payment_method',$data)
            ?$data['payment_method'] : $payment->method;
        $payment->channel = array_key_exists('payment_channel',$data)
            ?$data['payment_channel'] : $payment->channel;
        $payment->save();
        // update order status
        $orders = $payment->orders;
        switch ($event->payment->status){
            case 'COMPLETED':
            case 'PAID':
                foreach ($orders as $order){
                    if($order->status == Order::STATUS_NEW){
                        $order->status = Order::STATUS_INPROCESS;
                        $order->save();
                    }
                }
                Mail::to($event->buyer)->send(new PaymentSuccess($event->buyer, $event->payment));
                break;
            case 'FAILED':
            case 'EXPIRED':
                foreach ($orders as $order){
                    $order->status = Order::STATUS_CANCELLED;
                    $order->save();
                }
                Mail::to($event->buyer)->send(new PaymentFailure($event->buyer, $event->payment));
                break;
            default:

                break;
        }

        // update history
        $paymentHistory = new PaymentHistory();
        $paymentHistory->payment_id = $data['id'];
        $paymentHistory->status = $data['status'];
        $paymentHistory->description = array_key_exists('description', $data)
            ? $data['description'] : null;
        $paymentHistory->action_at = array_key_exists('status_updated', $data)
            ? new Carbon($data['status_updated']) : null;
        $paymentHistory->save();
    }
}
