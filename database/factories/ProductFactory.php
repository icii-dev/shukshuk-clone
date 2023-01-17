<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Model\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'slug' => $faker->slug,
        'featured' => false,
        'details' => $faker->sentence(8),
        'price' => $faker->numberBetween(1000, 500000),
        'discount' => $faker->randomElement([0, 0, 0, 0, 0, 0, 15, 30]),
        'description' => $faker->paragraph,
        'image' => 'products/dummy/laptop-1.jpg',
        'images' => '["products\/dummy\/laptop-2.jpg","products\/dummy\/laptop-3.jpg","products\/dummy\/laptop-4.jpg"]',
        'quantity' => 10,

        'status' => 1,
        'store_id' => 1,
    ];
});