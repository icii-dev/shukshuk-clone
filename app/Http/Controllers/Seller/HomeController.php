<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\SellerController;

class HomeController extends SellerController
{
    public function index()
    {
        return redirect()
            ->route('seller.product.index')
            ->with('message', session()->get('message'))
            ->setStatusCode(301);

        return view('seller.home.home');
    }
}
