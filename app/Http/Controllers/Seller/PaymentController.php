<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\SellerController;
use App\Service\StoreService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends SellerController
{
    public function index(){
        return view('seller.payment.index');
    }

    public function banks(){
        return view('seller.payment.index');
    }

    public function saveBank(Request $request, StoreService $storeService){
        $validatedData = $request->validate([
            'bank_code' => 'required',
            'bank_name' => 'required',
            'account_holder_name' => 'required',
            'account_number' => 'required|numeric'
        ]);
//        if($validatedData->fails()){
//            return response()->json($validatedData->messages(), Response::HTTP_BAD_REQUEST);
//        }
        $store = auth()->user()->store;
        $storeService->createBank($store, $request);
        return response()->json('success');
    }
}
