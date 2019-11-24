<?php

declare(strict_types=1);

namespace App\Money;

use App\Money\Contracts\CurrencyInterface;
use App\Money\Contracts\MoneyInterface;
use App\Money\Currency\Pln;
use App\Money\Exceptions\CurrencyException;
use ReflectionClass;
use ReflectionException;

class Money implements MoneyInterface {

    /**
     * @var integer
     */
    private $fractionalValue;

    public function __construct(int $fractionalValue)
    {
        $this->fractionalValue = $fractionalValue;
    }

    /**
     * @return int
     */
    public function getPriceAsFractionalUnits(): int
    {
        return $this->fractionalValue;
    }

    /**
     * @param float $value
     * @return float
     */
    public function multiplyPrice(float $value): float
    {
        return $this->fractionalValue * $value;
    }

    /**
     * @param string $currency
     * @return Currency
     */
    public function getPrice($currency = Pln::class): Currency
    {
        try {
            $class = new ReflectionClass($currency);
        } catch (ReflectionException $e) {
            throw CurrencyException::wrongClassCurrency();
        }

        if ( !$class->implementsInterface(CurrencyInterface::class) ) {
            throw CurrencyException::wrongClassCurrency();
        }

        return new Currency($this, $currency);
    }


}
