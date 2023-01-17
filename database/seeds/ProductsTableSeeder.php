<?php

use App\Model\Product;
use App\Model\ProductOption;
use App\Model\ProductOptionValue;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Product::class, 1)->create()->each(function (Product $product) {
//            $product->options()->saveMany(
//                factory(ProductOption::class, random_int(0, 2))->make()
//            )->each(function (ProductOption $productOption) {
//                $productOption->values()->saveMany(
//                    factory(ProductOptionValue::class, random_int(2,5))->make()
//                );
//            });
//        });
//
//        return;

        for ($i=1; $i <= 300; $i++) {
            $isFeatured = false;
            if($i%3==0){
                $isFeatured = true;
            }
            $randPrice = array(50000, 75000, 90000, 150000);
            $randDiscount = array(0, 0, 0, 0, 0, 0, 15, 30);
            $randImage = array(1,1,2);
            $image = $randImage[array_rand($randImage)];
            $image = 'vendor/buyer/Img/product-'. $image .'.jpg';
            /** @var Product $product */
            $product = Product::create([
                'name' => 'Honeycomb Tea Signature by Tea&Co '.$i,
                'slug' => 'honeycomb-tea-'.$i,
                'details' => ' Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit.',
                'price' => $randPrice[array_rand($randPrice)],
                'discount' => $randDiscount[array_rand($randDiscount)],
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. uis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpal. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. uis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa',
                'image' => $image,
//                'images' => '["vendor/buyer/Img/product-2.jpg","vendor/buyer/Img/product-2.jpg","vendor/buyer/Img/product-2.jpg","vendor/buyer/Img/product-2.jpg"]',
//                'images' => '["'.$image.'","'.$image.'","'.$image.'","'.$image.'"]',
                'images' => '',
                'quantity' => '10',
                'store_id' => random_int(7,17),
                'featured' => $isFeatured,
                'status' => 1,
            ]);
            $product->categories()->attach(1);
            if($i%2==0){
                $option = $product->options()->create(['name' => 'Colors']);
                // insert value
                $option->values()->create(['name' => 'Red']);
                $option->values()->create(['name' => 'Yellow']);
                $option->values()->create(['name' => 'Green']);

            }
            $option = $product->options()->create(['name' => 'Sizes']);
            // insert value
            $option->values()->create(['name' => 'M']);
            $option->values()->create(['name' => 'L']);
            $option->values()->create(['name' => 'XL']);

        }



    }
}
