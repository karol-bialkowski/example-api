<?php

declare(strict_types=1);

namespace App;

use App\Models\Traits\UseUuid;
use App\Money\Currency;
use App\Money\Currency\Pln;
use App\Money\Money;
use Illuminate\Database\Eloquent\Model;


class ProductPrice extends Model
{
    use UseUuid;

    protected $table = 'product_prices';
    protected $fillable = [
        'value',
        'active',
        'product_id',
    ];
    private const DEFAULT_CURRENCY = Pln::class;

    /**
     * @param string $currency_class
     * @return Currency
     */
    public function getValue($currency_class = self::DEFAULT_CURRENCY): Currency
    {
        return (new Money($this->value))->getPrice($currency_class);
    }

}
