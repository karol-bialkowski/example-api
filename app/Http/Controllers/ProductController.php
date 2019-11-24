<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ProductException;
use App\Http\Requests\ApiCreateProductRequest;
use App\Http\Requests\ApiUpdateProductRequest;
use App\Money\Currency\Eur;
use App\Money\Currency\Pln;
use App\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'status' => true,
            'payload' => Product::all()
        ]);
    }


    /**
     * @param string $product_uuid
     * @return JsonResponse
     */
    public function product(string $product_uuid): JsonResponse
    {
        try {

            /** @var Product $product */
            $product = Product::byId($product_uuid);
            $response = [
                'status' => true,
                'payload' => [
                    'product' => $product,
                    'price' => [
                        [
                            'currency' => [
                                'PLN' => $product->getPrice(Pln::class)->getPriceWithSymbol(),
                                'EUR' => $product->getPrice(Eur::class)->getPriceWithSymbol(),
                            ],
                            'raw' => $product->getPrice()->getRawPrice()
                        ]
                    ]
                ]
            ]; //TODO: move this array to separate product and price representations
            $code = Response::HTTP_OK;

        } catch (ProductException $exception) {
            $response = [
                'status' => false,
                'message' => $exception->getMessage()
            ];
            $code = Response::HTTP_NOT_FOUND;
        } finally {
            return new JsonResponse($response, $code);
        }
    }

    /**
     * @param ApiCreateProductRequest $apiCreateProductRequest
     * @return JsonResponse
     */
    public function create(ApiCreateProductRequest $apiCreateProductRequest): JsonResponse
    {
        /** @var Product $create */
        $create = ProductService::createProduct($apiCreateProductRequest);

        if (null === $create) {
            return new JsonResponse([
                'status' => false,
                'message' => 'An error occurred. Probably your request is not correct.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'status' => true,
            'payload' => $create
        ], Response::HTTP_OK);
    }

    /**
     * @param string $product_uuid
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(string $product_uuid): JsonResponse
    {
        try {
            ProductService::deleteProduct($product_uuid);
            $response = [
                'status' => true,
            ];
            $code = Response::HTTP_OK;
        } catch (ProductException $exception) {
            $response = [
                'status' => false,
                'message' => $exception->getMessage()
            ];
            $code = Response::HTTP_NOT_FOUND;
        } finally {
            return new JsonResponse($response, $code);
        }
    }

    public function update(string $product_uuid, ApiUpdateProductRequest $apiUpdateProductRequest)
    {
        try {
            ProductService::updateProduct($product_uuid, $apiUpdateProductRequest->validated());
            $response = [
                'status' => true,
            ];
            $code = Response::HTTP_OK;
        } catch (ProductException $exception) {
            $response = [
                'status' => false,
                'message' => $exception->getMessage()
            ];
            $code = Response::HTTP_NOT_FOUND;
        } finally {
            return new JsonResponse($response, $code);
        }
    }
}
