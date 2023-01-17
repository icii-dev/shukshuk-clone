<?php

namespace App\Http\Controllers\Api;

use App\Model\Order;
use App\Model\Product;
use App\Service\ReviewService;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request, ReviewService $reviewService){
        //check value rating from 1-5
        $request->validate([
            'rating' => 'required|numeric|between:1,5',
        ]);
        $imageReview = null;
        if($request->file('images')){
            try {
                $imageReview = $reviewService->uploadImage($request['images']);
            }catch (Exception  $exception){
                response()->json(['errors' => [$exception->getMessage()]], 400);
            }
        }
        $order = Order::whereId($request['orderId'])->first();
        $products = $order->products;
//        $product = Product::findOrFail($request['productID']);

        try {
            foreach ($products as $product){
                $reviewService->storeReviewForProduct($order->id, $product, $request['comment'], $request['rating'], $imageReview);
            }
            $store = $order->store;
            $store->recalculateRating();
            return response()->json(['message' => ['Thank you for your feedback!']], Response::HTTP_OK);
        }catch (Exception $exception){
            response()->json(['errors' => [$exception->getMessage()]], 400);
        }


    }
}
