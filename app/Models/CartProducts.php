<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartProducts extends Model
{
    protected $table = 'cart_products';
    protected $fillable = [
        'product_id',
        'cart_id'
    ];

}
