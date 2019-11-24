<?php

use App\Cart;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Cart::class, function (Faker $faker) {
    return [
        'id' => Str::uuid(),
        'expire_at' => \Carbon\Carbon::now()->addHours(2)
    ];
});
