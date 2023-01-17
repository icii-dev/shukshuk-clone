<?php

namespace App\Http\Controllers\Buyer;

use App\Model\Product;
use App\Model\Store;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Service\ProductService;

class WishlistController extends Controller
{
    public function index(ProductService $productService)
    {
        if(!auth()->user()){
            return redirect()->route('home');
        }
        $user = auth()->user();
        $wishlist = $user->wishlist;
        $idProductWishlist = array();
        foreach ($wishlist as $wish){
            $idProductWishlist[] = $wish->product_id;
        }
        $productWishlist = Product::whereIn('id', $idProductWishlist)->get();

        $storeWishlist = $user->wishlistStore()->get('store_id');
        $idlist = array();
        foreach ($storeWishlist as $id){
            $idlist[] = $id->store_id;
        }
        $storeWishlist = Store::whereIn('id', $idlist)->get();

        $this->seo()->setTitle(
            trans('wishlist.title', [])
        );
        $this->seo()->setDescription(
            trans('wishlist.description', [])
        );
        if(is_mobile()){
            return view('buyer.mobile.wishlist')->with([
                'productWishlist' => $productWishlist,
                'storeWishlist'   => $storeWishlist,
            ]);
        }

        return view('buyer.wishlist')->with([
            'productWishlist' => $productWishlist,
            'storeWishlist'   => $storeWishlist,
        ]);
    }
}
