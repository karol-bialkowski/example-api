<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ProductException;
use App\Http\Requests\ApiCreateProductRequest;
use App\Http\Requests\ApiUpdateProductRequest;
use App\Logic\ApiRepresentation;
use App\Logic\ProductRepresentation;
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

            $productRepresentation = new ProductRepresentation($product);
            $response = new ApiRepresentation($productRepresentation->getArrayRepresentation(), true, Response::HTTP_OK);

        } catch (ProductException $exception) {
            $response = new ApiRepresentation([], false, Response::HTTP_NOT_FOUND, $exception->getMessage());
        } finally {
            return $response->getRepresentation();
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
            $response = new ApiRepresentation([], false, Response::HTTP_BAD_REQUEST, 'An error occurred. Probably your request is not correct.');

            return $response->getRepresentation();
        }

        $productRepresentation = new ProductRepresentation($create);
        $response = new ApiRepresentation($productRepresentation->getArrayRepresentation(), true, Response::HTTP_OK);

        return $response->getRepresentation();
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
            $response = new ApiRepresentation([], true, Response::HTTP_OK);
        } catch (ProductException $exception) {
            $response = new ApiRepresentation([], false, Response::HTTP_NOT_FOUND, $exception->getMessage());
        } finally {
            return $response->getRepresentation();
        }
    }

    /**
     * @param string $product_uuid
     * @param ApiUpdateProductRequest $apiUpdateProductRequest
     * @return JsonResponse
     */
    public function update(string $product_uuid, ApiUpdateProductRequest $apiUpdateProductRequest)
    {
        try {
            $product = ProductService::updateProduct($product_uuid, $apiUpdateProductRequest->validated());
            $productRepresentation = new ProductRepresentation($product);
            $response = new ApiRepresentation($productRepresentation->getArrayRepresentation(), true, Response::HTTP_OK);

        } catch (ProductException $exception) {
            $response = new ApiRepresentation([], false, Response::HTTP_NOT_FOUND, $exception->getMessage());
        } finally {
            return $response->getRepresentation();
        }
    }
}
