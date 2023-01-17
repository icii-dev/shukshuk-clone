<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Store::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'slug' => $faker->slug,
        'type' => $faker->randomElement([1,2]),
        'rating' => $faker->randomFloat(1, 0, 5),
        'total_favorite' => $faker->randomDigit,
        'description' => $faker->text,

        'delivery_unit_id' =>1,

        'user_id' => 1,
        'status' => 1
    ];
});
