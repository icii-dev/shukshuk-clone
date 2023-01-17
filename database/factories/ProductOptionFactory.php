<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Model\ProductOption::class, function (Faker $faker) {
    return [
        'name' => $faker->text(25)
    ];
});