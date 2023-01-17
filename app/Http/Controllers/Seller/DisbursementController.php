<?php

namespace App\Http\Controllers\Seller;

use App\Model\Bank;
use App\Model\Disbursement;
use App\Model\Transaction;
use App\Service\PaymentService;
use App\Service\StoreService;
use App\Service\StoreTransactionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisbursementController extends Controller
{
    function create(Request $request,
                    PaymentService $paymentService,
                    StoreService $storeService,
                    StoreTransactionService $storeTransactionService){
        $validator = \Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'bank_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'    =>  $validator->errors(),
            ], 422);
        }

        // check balance of store
        $store = auth()->user()->store;
        $storeBalance = $store->balance;
        $balanceTotal = $storeBalance?$storeBalance->total:0;
        if($request['amount'] > $balanceTotal){
            return response()->json([
               'errors' => [
                   'amount' => 'The amount in the wallet is not enough'
               ]
            ], 422);
        }

        //check if bank of this store
        if(!$storeService->isBankOfStore($store,$request->bank_id)){
            return response()->json([
                'errors' => [
                    'bank' => 'Bank error!'
                ]
            ], 422);
        }

        $bank = Bank::whereId($request->bank_id)->first();
        $disbursement = new Disbursement();
        $disbursement->account_holder_name = $bank->account_holder_name;
        $disbursement->account_number = $bank->account_number;
        $disbursement->bank_code = $bank->bank_code;
        $disbursement->amount = $request->amount;
        $disbursement->user_id = \Auth::id();
        $disbursement->description = "Seller withdraw on page. Store id: " . $store->id;
        $disbursement->id = uniqid (rand ());
        // need save to auto create ID
        $disbursement->save();

        $response = $paymentService->createDisbursement($disbursement);
        if(array_key_exists("error", $response)){
            $disbursement->status = "ERROR";
            $disbursement->save();
            return response()->json(['errors' => $response], 500);
        }

        $disbursement->status = $response['status'];
        $disbursement->save();

//        $storeBalance->total = $storeBalance->total - $disbursement->amount;
//        $storeBalance->save();
        $balance = $storeTransactionService->pay($store, $disbursement->amount, $disbursement->description, Transaction::TYPE_WITHDRAW);

        return response()->json(['storeBalance' => amountFormat($balance)]);
    }

    function getBanks(PaymentService $paymentService){
        return $paymentService->getAvailableBanks();
    }
}
