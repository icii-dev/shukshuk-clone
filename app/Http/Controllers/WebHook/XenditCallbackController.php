<?php

namespace App\Http\Controllers\WebHook;

use App\Model\Disbursement;
use App\Model\Payment;
use App\Http\Controllers\Controller;
use App\Model\Transaction;
use App\Service\StoreTransactionService;
use http\Env\Response;
use Illuminate\Http\Request;

class XenditCallbackController extends Controller
{
    public function updatePaymentStatus(Request $request){
        $accessKey = $request->header('X-CALLBACK-TOKEN');
        $PaymentWebhookKey = env('PG_CALLBACK_TOKEN') ?? false;
        if(!$PaymentWebhookKey || $accessKey != $PaymentWebhookKey){
            return response()->json('Error Token', 401);
        }
        $payment = Payment::where('id',$request['id'])->first();
        //return 404 to security
        if(!$payment){
            return response()->json('404 page not found', 404);
        }

        $user = $payment->orders[0]->user;
        if($user){
            /*
             * update order
             */
            event(new \App\Events\UpdatePayment($user, $payment, $request->all()));
        }
        return \response()->json($payment);
    }

    public function updateDisbursement(Request $request, StoreTransactionService $storeTransactionService){
        $disbursement = Disbursement::where('id', $request['id'])->first();
        //return 4040 to security
        if(!$disbursement){
            return response()->json('404 page not found', 404);
        }

        $disbursement->update([
            'status' => $request['status'],
            'failure_code' => $request['failure_code'],
            'is_instant' => $request['is_instant'],
        ]);

        $disbursement->save();

        if($request['status'] === 'COMPLETED'){
            // create transaction to save transactions history
            $store = $disbursement->user->store;
            $amount = $disbursement->amount;
//            $storeTransactionService->pay($store, $amount, Transaction::TYPE_WITHDRAW);
        }

        return $disbursement;
    }

}
