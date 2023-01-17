<?php

namespace App\Http\Controllers\Api;

use App\Model\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function updateStatus(Request $request){

        $payment = Payment::where('id',$request['id'])
                        ->update([
                            'status' => $request['status'],
                            'method' => $request['payment_method'],
                            'channel' => $request['payment_channel'],
                            'paid_amount' => $request['paid_amount'],
                            'currency' => $request['currency'],
                        ]);

        $user = $payment->orders[0]->user;
        event(new \App\Events\UpdatePayment($user, $payment));
        return $payment;
    }
}
