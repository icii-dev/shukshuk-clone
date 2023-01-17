<?php

namespace App\Service;

use App\Model\Product;
use App\Model\Review;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewService
{
    /**
     * this function attaches the review to the product by its ID,
     * then the average rating for the product is recalculated
     * @param $productID
     * @param $comment
     * @param $rating must be between 1 and 20
     * User must be has buy product
     */
    public function storeReviewForProduct($orderId, Product $product, $comment, $rating, $imageName = null){
        if(!Auth::user()){
            throw new Exception('Please login!');
        }
        $user_id = Auth::user()->id;
        if($rating<1 || $rating>5){
            throw new Exception('Rating must be between 1 and 5');
        }
        //check user has review this product
        // if has review, update.
        $review = Review::where('order_id',$orderId)
                            ->where('user_id', $user_id)
                            ->first();
        if(!$review){
            $review = new Review();
        }

        $review->user_id = $user_id;
        $review->comment = $comment;
        $review->rating = $rating;
        $review->images = $imageName;
        $review->order_id = $orderId;

        $product->reviews()->save($review);

        // recalculate ratings for the specified product
        $product->recalculateRating();
        return true;
    }

    public function seedingReviewForProduct(Product $product, $comment, $rating, $user_id){


        if($rating<1 || $rating>5){
            throw new Exception('Rating must be between 1 and 5');
        }
        //check user has review this product
        // if has review, update.
        $review = Review::where('product_id',$product->id)
            ->where('user_id', $user_id)
            ->first();
        if(!$review){
            $review = new Review();

        }

        $review->user_id = $user_id;
        $review->comment = $comment;
        $review->rating = $rating;

        $product->reviews()->save($review);

        // recalculate ratings for the specified product
        $product->recalculateRating();
        return true;
    }

    //upload review image
    function uploadImage($image){
//        $request->validate([ 'avatar' => 'required|image|max:5120' ]);
        if ($image) {
            $fileExtension = $image->getClientOriginalExtension();

            $fileName = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension;
            $pathReviews = 'storage/reviews/';
            $uploadPath = public_path($pathReviews); // Thư mục upload

            $image->move($uploadPath, $fileName);

            return $pathReviews.$fileName;
        }
        else {
            // Lỗi file
            throw new ErrorException('The image failed to upload.');
        }
    }

}