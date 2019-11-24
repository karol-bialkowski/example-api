<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductException extends NotFoundHttpException
{
    public static function notFound(string $uuid)
    {
        return new self(sprintf('Not found product with uuid: %s', $uuid));
    }
}
