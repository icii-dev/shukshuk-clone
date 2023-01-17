<?php

use App\Model\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Model\Category;
use App\Model\CategoryProduct;

class CategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        $products = Product::all();
        $category = Category::all();

        for($i=0; $i<count($products); $i++){
            $idCategory = $i%3;
            $idCategory = $category[$idCategory]->id;
            CategoryProduct::insert([
                'product_id' => $products[$i]->id, 'category_id' => $idCategory, 'created_at' => $now, 'updated_at' => $now
            ]);
        }
    }
}
