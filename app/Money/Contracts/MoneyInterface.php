<?php

declare(strict_types=1);

namespace App\Money\Contracts;

use App\Money\Currency;

interface MoneyInterface
{
    public function getPrice(): Currency;
    public function getPriceAsFractionalUnits(): int;
    public function multiplyPrice(float $value): float;

}
