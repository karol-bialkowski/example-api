<?php

declare(strict_types=1);

namespace App\Logic;

use App\Cart;
use App\Money\Currency\Eur;
use App\Money\Currency\Pln;
use App\Money\Money;
use App\Product;

class CartRepresentation extends Product
{


    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function cartProducts()
    {
        //hot method, refactor later
        $cartProducts = $this->cart->getProducts()->get();

        if ($cartProducts->count() === 0) {
            return [];
        }

        $summary = 0;

        $result = [];
        foreach ($cartProducts as $cartProduct) {

            $product = Product::byId($cartProduct->product_id);

            $summary +=  (int) $product->getPrice()->getRawPrice();

            $result[] = [
                'product' => (new ProductRepresentation($product))->getArrayRepresentation()
            ];
        }

        $result['summary'] = [
            'PLN' => (new Money($summary))->getPrice(Pln::class)->getPriceWithSymbol(),
            'EUR' => (new Money($summary))->getPrice(Eur::class)->getPriceWithSymbol(),
        ];

        return $result;
    }


    /**
     * @return array
     */
    public function getArrayRepresentation(): array
    {


        return [
            'cart' => $this->cart,
            'cart_products' => $this->cartProducts()
//            'price' => [
//                [
//                    'currency' => [
//                        'PLN' => $this->product->getPrice(Pln::class)->getPriceWithSymbol(),
//                        'EUR' => $this->product->getPrice(Eur::class)->getPriceWithSymbol(),
//                    ],
//                    'raw' => $this->product->getPrice()->getRawPrice()
//                ]
//            ]
        ];
    }

}
