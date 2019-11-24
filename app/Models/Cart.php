<?php

namespace App;

use App\Events\CartCreating;
use App\Exceptions\CartException;
use App\Models\Traits\UseUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use UseUuid;

    protected $table = 'carts';
    protected $fillable = [
        'id',
        'expire_at',
        'created_at',
        'updated_at'
    ];
    public $incrementing = false;

    public const EXPIRE = 'PT2H';
    public const MAX_PRODUCTS = 3;

    protected $dispatchesEvents = [
        'creating' => CartCreating::class,
    ];

    /**
     * @return HasMany
     */
    public function getProducts(): HasMany
    {
        return $this->hasMany(CartProducts::class, 'cart_id', 'id');
    }

    /**
     * @param array $product_uuids
     * @return bool
     * @throws CartException
     */
    public function assignSpecificProducts(array $product_uuids)
    {
        foreach($product_uuids as $product_uuid) {

            $exist = CartProducts::where('cart_id', $this->id)
                ->where('product_id', $product_uuid)
                ->exists();

            if($exist) {
                throw CartException::existProduct($product_uuid);
            }

            CartProducts::create([
                'cart_id' => $this->id,
                'product_id' => $product_uuid
            ]);
        }

        return true;
    }


}
