<?php

declare(strict_types=1);

namespace App\Money\Currency;

use App\Money\Contracts\CurrencyInterface;
use App\Money\Currency;
use App\Money\Money;

class Eur implements CurrencyInterface
{
    private const ISO_CODE = 'EUR';
    private const SYMBOL = '€';
    private const SYMBOL_PLACEMENT = 'after';
    private const value = 0.23273;
    private const DECIMAL = 2;
    private const DECIMAl_SEPARATOR = ',';
    private const THOUSANDS_SEPARATOR = '';

    /**
     * @var Money
     */
    private $money;
    /**
     * @var float
     */
    private $calculated_price;


    public function __construct(Money $money)
    {
        $this->money = $money;
        $this->calculated_price = ($this->money->multiplyPrice(self::value)) / 100;
    }

    /**
     * @param float $price
     * @return string
     */
    public static function localCurrencyFormat(float $price): string
    {
        return number_format($price, self::DECIMAL, self::DECIMAl_SEPARATOR, self::THOUSANDS_SEPARATOR);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return Currency::symbolPlacement(self::localCurrencyFormat($this->calculated_price), self::SYMBOL_PLACEMENT, self::SYMBOL);

    }

    /**
     * @return string
     */
    public function getIsoCode(): string
    {
        return self::ISO_CODE;
    }


}
