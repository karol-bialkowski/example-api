<?php

namespace App;

use App\Events\CartCreating;
use App\Models\Traits\UseUuid;
use Illuminate\Database\Eloquent\Model;

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

    protected $dispatchesEvents = [
        'creating' => CartCreating::class,
    ];

}
