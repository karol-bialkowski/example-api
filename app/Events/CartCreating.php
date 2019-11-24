<?php

namespace App\Events;


use App\Cart;
use Illuminate\Queue\SerializesModels;

class CartCreating
{
    use SerializesModels;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * CartCreating constructor.
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return $this->cart;
    }

}
