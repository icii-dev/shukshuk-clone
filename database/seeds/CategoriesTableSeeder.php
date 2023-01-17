<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        \App\Model\Category::insert([
            ['name' => 'Silk', 'slug' => 'silk', 'description'=> 'silk','created_at' => $now, 'updated_at' => $now],
            ['name' => 'Spices', 'slug' => 'spices', 'description'=> 'spices', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Incense', 'slug' => 'incense', 'description'=> 'incense', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
