<?php

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'id' => Str::uuid(),
        'name' => $faker->name,
    ];
});
