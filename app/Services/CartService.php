<?php

declare(strict_types=1);

namespace App\Services;

use App\Cart;
use App\CartProducts;
use App\Exceptions\CartException;
use App\Http\Requests\AssignProductsToCartRequest;
use App\Http\Requests\DeleteProductFromCartRequest;

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

    /**
     * @param AssignProductsToCartRequest $assignProductsToCartRequest
     * @return Cart
     * @throws CartException
     */
    public static function assignProducts(AssignProductsToCartRequest $assignProductsToCartRequest): Cart
    {
        $cart = $assignProductsToCartRequest->getCart();

        if ($cart->getProducts()->count() >= Cart::MAX_PRODUCTS) {
            throw CartException::exceededProductsLimit();
        }

        $cart->assignSpecificProducts($assignProductsToCartRequest->validated()['products']);

        return $cart;
    }

    /**
     * @param DeleteProductFromCartRequest $deleteProductFromCartRequest
     * @return Cart
     */
    public static function deleteProducts(DeleteProductFromCartRequest $deleteProductFromCartRequest)
    {
        $cart = $deleteProductFromCartRequest->getCart();
        $product = $deleteProductFromCartRequest->getProduct();

        //TODO: verify and insert exception
        CartProducts::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id
        ])->delete();

        return $cart;
    }
}
