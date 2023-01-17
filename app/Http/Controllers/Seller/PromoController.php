<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\SellerController;

class PromoController extends SellerController
{
    public function index()
    {

        return view('seller.promo.index');
    }
}