<?php

use App\Product;
use App\ProductPrice;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 10)->create()->each(function ($product) {
            factory(ProductPrice::class)->create([
                'product_id' => $product->id
            ]);
        });
    }
}
