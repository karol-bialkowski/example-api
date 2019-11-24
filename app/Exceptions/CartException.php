<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Cart;

class CartException extends \Exception
{
    /**
     * @return CartException
     */
    public static function notSave(): CartException
    {
        return new self(sprintf('Not save cart'));
    }

    /**
     * @param string $product_uuid
     * @return CartException
     */
    public static function existProduct(string $product_uuid): CartException
    {
        return new self(sprintf('You can`t assign product: %s - this products is exist in this cart.', $product_uuid));
    }

    /**
     * @return CartException
     */
    public static function exceededProductsLimit(): CartException
    {
        return new self(sprintf('exceeded products limit. You can assign max products: %d', Cart::MAX_PRODUCTS));
    }
}
