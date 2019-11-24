<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ProductException;
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
     * @param string $uuid
     * @return mixed
     */
    public static function byId(string $uuid): self
    {
        if(self::find($uuid)) {
            return self::find($uuid);
        }
        throw ProductException::notFound($uuid);
    }

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
