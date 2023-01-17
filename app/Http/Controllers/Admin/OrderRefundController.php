<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use Xendit\Xendit;

class OrderRefundController extends VoyagerBaseController
{
    public function createPayout(Request $request){

        Xendit::setApiKey(env('XENDIT_API_KEY', ''));

        $params = [
            'external_id' => 'SHUK-EXTERNAL-628374039571411',
            'amount' => 111815,
            'email' => 'cau2@gmail.com'
        ];

    try {
        $createPayout = \Xendit\Payouts::create($params);
    }catch (\Exception $exception){
        return $exception;
    }
        return $createPayout;
    }

}
