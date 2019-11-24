<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Cart;
use App\Exceptions\CartException;
use App\Http\Requests\AssignProductsToCartRequest;
use App\Http\Requests\DeleteProductFromCartRequest;
use App\Logic\ApiRepresentation;
use App\Logic\CartRepresentation;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Mockery\Exception;

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

    /**
     * @param AssignProductsToCartRequest $assignProductsToCartRequest
     * @return JsonResponse
     */
    public function assignProducts(AssignProductsToCartRequest $assignProductsToCartRequest): JsonResponse
    {
        try {
            $cart = CartService::assignProducts($assignProductsToCartRequest);
            return (new ApiRepresentation(['cart' => $cart, 'cart_products' => $cart->getProducts()->get()], true, Response::HTTP_OK))->getRepresentation();
        } catch (CartException $exception) {
            return (new ApiRepresentation([], false, Response::HTTP_BAD_REQUEST, $exception->getMessage()))->getRepresentation();
        } catch (Exception $exception) {
            return (new ApiRepresentation([], false, Response::HTTP_BAD_REQUEST, 'Unexpected error. Please try again later.'))->getRepresentation();
        }
    }

    public function delete(DeleteProductFromCartRequest $deleteProductFromCartRequest)
    {
        try {
            $cart = CartService::deleteProducts($deleteProductFromCartRequest);
            return (new ApiRepresentation(['cart' => $cart], true, Response::HTTP_OK))->getRepresentation();
        } catch (CartException $exception) {
            return (new ApiRepresentation([], false, Response::HTTP_BAD_REQUEST, $exception->getMessage()))->getRepresentation();
        } catch (Exception $exception) {
            return (new ApiRepresentation([], false, Response::HTTP_BAD_REQUEST, 'Unexpected error. Please try again later.'))->getRepresentation();
        }
    }

    public function index(string $cart_uuid)
    {
        $cart = Cart::find($cart_uuid);

        if ($cart === null) {
            return (new ApiRepresentation([], false, Response::HTTP_NOT_FOUND))->getRepresentation();
        }

        $cartRepresentation = new CartRepresentation($cart);
        return (new ApiRepresentation($cartRepresentation->getArrayRepresentation(), true, Response::HTTP_OK))->getRepresentation();
    }


}
