<?php

namespace App\Http\Controllers\Api;

use App\Model\Wishlist;
use App\Model\WishlistStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store($idProduct){
        if(!Auth::user()){
            return response()->json(['errors' => ['Please login to save this Wishlist to your Account']], 400);
        }

        $wishlist = Wishlist::where([
                'product_id' => $idProduct,
                'user_id' => Auth::user()->id,
            ])->first();
        $response = array();

        if($wishlist){
            Wishlist::where([
                'product_id' => $idProduct,
                'user_id' => Auth::user()->id,
            ])->delete();
        }else{
            $response['isAdd'] = Wishlist::create([
                'product_id' => $idProduct,
                'user_id' => Auth::user()->id,
            ])->first();
        }

        return response()->json($response, Response::HTTP_OK);
    }

    public function wishlistStore($idStore){
        if(!Auth::user()){
            return response()->json(['errors' => ['Please login to save this Wishlist to your Account']], 400);
        }

        $wishlist = WishlistStore::where([
            'store_id' => $idStore,
            'user_id' => Auth::user()->id,
        ])->first();
        $response = array();

        if($wishlist){
            WishlistStore::where([
                'store_id' => $idStore,
                'user_id' => Auth::user()->id,
            ])->delete();
        }else{
            $response['isAdd'] = WishlistStore::create([
                'store_id' => $idStore,
                'user_id' => Auth::user()->id,
            ])->first();
        }

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        //
    }

    /**
     * Destroy storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Cart::instance('wishlist')->destroy();
    }


}
