<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ProductException;
use App\Models\Traits\UseUuid;
use App\Money\Currency;
use App\Money\Currency\Pln;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use UseUuid;

    protected $table = 'products';
    protected $fillable = [
        'id',
        'name'
    ];
    public $incrementing = false;

    /**
     * @param string $uuid
     * @return mixed
     */
    public static function byId(string $uuid): self
    {
        if (self::find($uuid)) {
            return self::find($uuid);
        }
        throw ProductException::notFound($uuid);
    }

    /**
     * @return HasMany
     */
    public function getPrices(): HasMany
    {
        return $this->hasMany(ProductPrice::class, 'product_id', 'id');
    }

    /**
     * @param string $currency
     * @return Currency|null
     */
    public function getPrice($currency = Pln::class)
    {

        $price = $this->hasMany(ProductPrice::class, 'product_id', 'id')
            ->where('active', true)->first();

        if ($price === null) {
            return null;
        }

        return $price->getValue($currency);
    }


}
