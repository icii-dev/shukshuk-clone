<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\SellerController;

class StatisticController extends SellerController
{
    public function index()
    {
        return view('seller.statistic.index');
    }
}