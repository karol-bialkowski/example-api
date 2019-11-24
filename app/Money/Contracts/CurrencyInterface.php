<?php

declare(strict_types=1);

namespace App\Money\Contracts;

interface CurrencyInterface
{
    public function getIsoCode(): string;
    public static function localCurrencyFormat(float $price): string;
    public function value(): string;
}
