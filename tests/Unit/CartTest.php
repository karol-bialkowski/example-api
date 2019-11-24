<?php

namespace Tests\Unit;

use App\Cart;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CartTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldCreateCartWithFutureExpireDate()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $now = new \DateTime();

        //Then
        $this->assertTrue($cart->expire_at > $now);
    }

}
