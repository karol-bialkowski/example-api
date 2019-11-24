<?php

declare(strict_types=1);

namespace App\Money;

class Currency
{

    private $currency_class;
    /**
     * @var Money
     */
    private $money;

    /**
     * Currency constructor.
     * @param Money $money
     * @param $currency_class
     */
    public function __construct(Money $money, $currency_class)
    {
        $this->currency_class = $currency_class;
        $this->money = $money;
    }

    /**
     * @return mixed
     */
    public function getPriceWithSymbol()
    {
        $currency = new $this->currency_class($this->money);
        return $currency->value();
    }

    /**
     * @param string $price
     * @param string $placement
     * @param string $symbol
     * @return string
     */
    public static function symbolPlacement(string $price, string $placement, string $symbol)
    {
        if ($placement === 'before') {
            return $symbol . ' ' . $price;
        }

        return $price . ' ' . $symbol;
    }
}
