<?php

use App\Product;
use App\ProductPrice;
use Faker\Generator as Faker;

$factory->define(ProductPrice::class, function (Faker $faker) {
    return [
        'value' => $faker->numberBetween(1, 100000),
        'active' => true,
        'product_id' => factory(Product::class)->create()->id
    ];
});
