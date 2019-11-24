<?php

declare(strict_types=1);

namespace App\Services;

use App\Cart;
use App\Exceptions\CartException;

class CartService extends Cart
{

    /**
     * @return Cart
     * @throws CartException
     */
    public static function createCart(): Cart
    {
        //TODO: block multiple insert cart per user until expired
        $cart = Cart::create();

        if (!$cart) {
            throw CartException::notSave();
        }

        return $cart;
    }
}
