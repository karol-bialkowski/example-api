<?php

declare(strict_types=1);

namespace App;

use App\Models\Traits\UseUuid;
use App\Money\Currency;
use Illuminate\Database\Eloquent\Model;

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
     * @param bool $active
     * @return Currency|null
     */
    public function getPrice($active = true): ?Currency
    {
        $price = $this->hasMany(ProductPrice::class, 'product_id', 'id')
            ->where('active', $active)->first();

        if (null !== $price) {
            return $price->getValue();
        }

        return null;
    }


}
