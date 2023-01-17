<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reviewService = new \App\Service\ReviewService();
        try {
            $users = \App\Model\User::all();
            $products = \App\Model\Product::all();
            foreach ($products as $product){
                if($product->id%2==0){
                    foreach ($users as $user){
                        $reviewService->seedingReviewForProduct($product, 'good good', rand(1,5), $user->id);
                    }
                }
            }

        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
}
