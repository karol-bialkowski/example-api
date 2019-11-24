<?php

declare(strict_types=1);

namespace App\Money\Currency;

use App\Money\Contracts\CurrencyInterface;
use App\Money\Currency;
use App\Money\Money;

class Pln implements CurrencyInterface
{
    private const ISO_CODE = 'PLN';
    private const SYMBOL = 'zł';
    private const SYMBOL_PLACEMENT = 'after';
    private const value = 1.0;
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


    /**
     * Pln constructor.
     * @param Money $money
     */
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
