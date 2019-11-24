<?php

declare(strict_types=1);

namespace App\Money\Exceptions;

use RuntimeException;

class CurrencyException extends RuntimeException
{
    /**
     * @return CurrencyException
     */
    public static function wrongClassCurrency()
    {
        return new self(sprintf('Wrong currency class given. Currency class must be implement Money\Contracts\CurrencyInterface interface'));
    }
}
