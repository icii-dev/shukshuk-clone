<?php


namespace App\Service;


use App\Model\Store;
use App\Model\StoreBalance;
use App\Model\Transaction;
use Xendit\Balance;

class StoreTransactionService
{
    //pay and withdraw
    public function pay(
        Store $store,
        $amount,
        $description = '',
        $type = Transaction::TYPE_PAY_FOR_SELLER,
        $status=Transaction::STATUS_SUCCESS)
    {
        $amountTransaction = 0;
        switch ($type){
            case Transaction::TYPE_PAY_FOR_SELLER:
                // admin fee
                $AdminFee = \App\Model\AdminFee::latest()->first('fee');
                $fee = $AdminFee->fee;
                $serviceRate = (100-$fee)/100;
                $amountTransaction = $amount*$serviceRate;
                break;
            case Transaction::TYPE_WITHDRAW:
                $amountTransaction = 0 - $amount;
                break;
            default:
                return 0;
        }

        return $this->makeTransactionToStore($store, $amountTransaction, $type, $description);
    }

    public function makeTransactionToStore(Store $store, $amount, $type, $description = ''){
        $transaction = new Transaction([
            'store_id' => $store->id,
            'amount' => $amount,
            'type' => $type,
            'status' => Transaction::STATUS_SUCCESS,
            'description' => $description,
        ]);

        if($transaction){
            if(!$store->balance){
                $store->balance()->save(new StoreBalance(['total' => 0]));
            }
            $store->balance->total += $transaction->amount;
            $store->balance->save();
            $transaction->save();
        }
        return $store->balance->total;
    }
}