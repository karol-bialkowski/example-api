<?php

namespace Tests\Unit;

use App\Money\Currency\Eur;
use App\Money\Currency\Pln;
use App\Product;
use App\ProductPrice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldCreateExampleProduct(): void
    {
        $product = factory(Product::class)->create();

        $this->assertDatabaseHas('products', [
            'name' => $product->name
        ]);
    }

    public function testShouldGetOnePrice(): void
    {
        // Expect
        $expectPrice = 567;

        // Given
        /** @var Product $product */
        $product = factory(Product::class)->create();
        // When
        /** @var ProductPrice $productPrice */
        $productPrice = factory(ProductPrice::class)->create([
            'product_id' => $product->id,
            'value' => $expectPrice
        ]);

        //Then
        $this->assertEquals($expectPrice, $productPrice->value);
    }

    public function testShouldVerifyInsertingPrice()
    {
        // Given
        $expect_price = '1,33 zł';
        $calculated_eur_price = '0.31 €';

        /** @var Product $product */
        $product = factory(Product::class)->create();
        /** @var ProductPrice $productPrice */
        $productPrice = factory(ProductPrice::class)->create([
            'product_id' => $product->id,
            'value' => 133
        ]);

        // When
        $pln_as_default_value = $productPrice->getValue()->getPriceWithSymbol();
        $pln_as_passed_class = $productPrice->getValue(Pln::class)->getPriceWithSymbol();
        $eur_value = $productPrice->getValue(Eur::class)->getPriceWithSymbol();

        //Then
        $this->assertEquals($expect_price, $pln_as_default_value);
        $this->assertEquals($expect_price, $pln_as_passed_class);
        $this->assertEquals($calculated_eur_price, $eur_value);
    }
}
