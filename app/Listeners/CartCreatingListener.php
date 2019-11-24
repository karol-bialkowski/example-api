<?php

namespace App\Listeners;

use App\Cart;
use App\Events\CartCreating;
use Illuminate\Support\Str;

class CartCreatingListener
{
    /**
     * @param CartCreating $cartCreating
     * @return bool
     * @throws \Exception
     */
    public function handle(CartCreating $cartCreating): bool
    {
        $cart = $cartCreating->getCart();

        $cart->id = Str::uuid();
        $cart->expire_at = (new \DateTime('now'))->add(new \DateInterval(Cart::EXPIRE));

        return true;
    }
}
