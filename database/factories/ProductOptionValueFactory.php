<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\ProductOptionValue::class, function (Faker $faker) {
    return [
        'name' => $faker->realText(25)
    ];
});
