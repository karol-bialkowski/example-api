<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\CartException;
use App\Logic\ApiRepresentation;
use App\Services\CartService;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function create()
    {
        try {
            $cart = CartService::createCart();
            return (new ApiRepresentation(['cart' => $cart], true, Response::HTTP_OK))->getRepresentation();
        } catch (CartException $exception) {
            return (new ApiRepresentation([], false, Response::HTTP_BAD_REQUEST))->getRepresentation();
        }

    }

}
