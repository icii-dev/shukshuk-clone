<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\Seller\BankRequest;
use App\Model\Bank;
use App\Service\PaymentService;
use App\Service\StoreService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    public function index(){
        return view('seller.payment.index');
    }

    public function store(Request $request, StoreService $storeService){
        $validatedData = $request->validate([
            'bank_code' => 'required',
            'bank_name' => 'required',
            'account_holder_name' => 'required',
            'account_number' => 'required|numeric'
        ]);

        $store = auth()->user()->store;
        $storeService->createBank($store, $request);
        return response()->json([ 'success' => true ]);
    }

    public function show($bankId, PaymentService $paymentService){
        $bank = Bank::find($bankId);
        $listBank = $paymentService->getAvailableBanks();
        return response()->json([
            'data' => [
                'bank' => $bank,
                'listBank' => $listBank
            ]
        ]);
    }

    public function update(BankRequest $request, StoreService $storeService){
        $bankId = $request->id;
        //check if bank of this store
        $store = auth()->user()->store;
        if(!$storeService->isBankOfStore($store,$bankId)){
            return response()->json([
                'errors' => [
                    'bank' => 'Bank error!'
                ]
            ], 422);
        }
        $bank = Bank::find($bankId)->update($request->all());
        return response()->json(['success'=>true]);
    }

    public function destroy($bankId, StoreService $storeService){
        //check if bank of this store
        $store = auth()->user()->store;
        if(!$storeService->isBankOfStore($store,$bankId)){
            return response()->json([
                'errors' => [
                    'bank' => 'Bank error!'
                ]
            ], 422);
        }
        $bank = Bank::find($bankId);
        $bank->delete();
        return response()->json([
            'message' => 'Data deleted successfully!'
        ]);
    }
}
