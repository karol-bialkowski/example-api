<?php

declare(strict_types=1);

namespace App\Logic;

use App\Money\Currency\Eur;
use App\Money\Currency\Pln;
use App\Product;

class ProductRepresentation extends Product
{

    /**
     * @var Product
     */
    private $product;

    /**
     * ProductRepresentation constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    /**
     * @return array
     */
    public function getArrayRepresentation(): array
    {
        return [
            'product' => $this->product,
            'price' => [
                [
                    'currency' => [
                        'PLN' => $this->product->getPrice(Pln::class)->getPriceWithSymbol(),
                        'EUR' => $this->product->getPrice(Eur::class)->getPriceWithSymbol(),
                    ],
                    'raw' => $this->product->getPrice()->getRawPrice()
                ]
            ]
        ];
    }

}
