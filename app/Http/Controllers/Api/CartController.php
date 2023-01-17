<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

use App\Service\CartService;

class CartController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = new CartService();
        $cart = $cart->getCart();
        return response()->json($cart, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Model\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CartService $cartService)
    {
        //check value qty from 1-20
        $validator = Validator::make($request->all(), [
            'data.qty' => 'required|numeric|between:1,20'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => ['Quantity must be between 1 and 20.']], 400);
        }

        $productId = $request['data']['id'];
        $qty = $request['data']['qty'];
        $productVariantId = $request['data']['variant_id'];
//        $options = $request['data']['options'];
        //check the product in the cart

        $productVariant = ProductVariant::with('product')->where('id', $productVariantId)->firstOrFail();
        $product = $productVariant->product;

        //check stock
        if (!$cartService->isAvailableInStockWhenAddOne($productId, $productVariant, $qty)) {
            return response()->json(['errors' => ['Sorry! We currently do not have enough items in stock.']], 400);
        }
        Cart::instance('shopping')->add($product->id, $product->name, $qty, $productVariant->present_price, [
            'slug'                      => $product->slug,
            'thumbnail'                 => $productVariant->image ?? $product->image,
            'product_variant_id'        => $productVariant->id,
            'discount'                  => $productVariant->discount_value,
            'discount_type'             => $productVariant->discount_type,
            'oldPrice'                  => $productVariant->price,
            'options'                   => $request['data']['options'],
            'note'                      => $request['data']['note'],
            'store_id'                  => $product->store_id,
            'store'                     => [
                'id'   => $product->store->id,
                'name' => $product->store->name
            ],
            'formatted_price'           => $productVariant->formatted_price,
            'formatted_present_price'   => $productVariant->formatted_present_price,
            'formatted_discount_amount' => $productVariant->formatted_discount_amount
        ]);

        $cart = Cart::instance('shopping')->content();
        return response()->json($cart, Response::HTTP_OK);
    }

    /**
     * buynow a product.
     *
     * @param \App\Model\Product $product
     * @return \Illuminate\Http\Response
     */
    public function buynow(Request $request, CartService $cartService)
    {
        //check value qty from 1-20
        $validator = Validator::make($request->all(), [
            'data.qty' => 'required|numeric|between:1,20'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => ['Quantity must be between 1 and 20.']], 400);
        }
        //only one product to bay now
        Cart::instance('buynow')->destroy();

        $productId = $request['data']['id'];
        $qty = $request['data']['qty'];
        $productVariantId = $request['data']['variant_id'];
//        $id = $request['data']['id'];
//        $qty = $request['data']['qty'];

        $productVariant = ProductVariant::with('product')->where('id', $productVariantId)->firstOrFail();
        $product = $productVariant->product;

        //check stock
        if (!$cartService->isAvailableInStock($productId, $productVariant, $qty)) {
            return response()->json(['errors' => ['Sorry! We currently do not have enough items in stock.']], 400);
        }

        Cart::instance('buynow')->add($product->id, $product->name, $qty, $productVariant->present_price, [
            'slug'                      => $product->slug,
            'thumbnail'                 => $productVariant->image ?? $product->image,
            'product_variant_id'        => $productVariant->id,
            'discount'                  => $productVariant->discount_value,
            'discount_type'             => $productVariant->discount_type,
            'oldPrice'                  => $productVariant->price,
            'options'                   => $request['data']['options'],
            'note'                      => $request['data']['note'],
            'store_id'                  => $product->store_id,
            'store'                     => [
                'id'   => $product->store->id,
                'name' => $product->store->name
            ],
            'formatted_price'           => $productVariant->formatted_price,
            'formatted_present_price'   => $productVariant->formatted_present_price,
            'formatted_discount_amount' => $productVariant->formatted_discount_amount
        ]);

        $cart = Cart::instance('buynow')->content();
        return response()->json($cart, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartService $cartService)
    {
        $validator = Validator::make($request->all(), [
            'data.qty' => 'required|numeric|between:1,20'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => ['Quantity must be between 1 and 20.']], 400);
        }

        $rowId = $request['data']['rowId'];
        $qty = $request['data']['qty'];

        $nameCart = 'shopping';
        foreach (Cart::instance('buynow')->content() as $key => $item) {
            if ($key == $rowId) {
                $nameCart = 'buynow';
            }
        }

        $item = Cart::instance($nameCart)->get($rowId);
        $productId = $item->id;
        $productVariantId = $item->options->product_variant_id;
        $productVariant = ProductVariant::where('id', $productVariantId)->firstOrFail();
        //check stock
        if (!$cartService->isAvailableInStock($productId, $productVariant, $qty)) {
            return response()->json(['errors' => ['Sorry! We currently do not have enough items in stock.']], 400);
        }

        Cart::instance($nameCart)->update($rowId, $qty);

        $cart = Cart::instance($nameCart)->content();
        return response()->json($cart, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        $rowId = $request['data']['rowId'];
        Cart::instance('shopping')->remove($rowId);

        $cart = Cart::instance('shopping')->content();
        return response()->json($cart, Response::HTTP_OK);
    }

    public function destroyCart()
    {
        Cart::instance('shopping')->destroy();
        return 'Cart has been destroy';
    }

    /**
     * Switch item for shopping cart to Save for Later.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function switchToSaveForLater($id)
    {
        $item = Cart::instance('shopping')->get($id);

        Cart::instance('shopping')->remove($id);

        $duplicates = Cart::instance('shopping')->instance('saveForLater')->search(function ($cartItem, $rowId) use ($id
        ) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already Saved For Later!');
        }

        Cart::instance('shopping')->instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Model\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item has been Saved For Later!');
    }
}

