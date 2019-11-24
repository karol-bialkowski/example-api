<?php

declare(strict_types=1);

namespace App\Exceptions;

class CartException extends \Exception
{
    /**
     * @return CartException
     */
    public static function notSave(): CartException
    {
        return new self(sprintf('Not save cart'));
    }
}
