<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ProductException;
use App\Http\Requests\ApiCreateProductRequest;
use App\Product;
use App\ProductPrice;
use DB;

class ProductService extends Product
{


    /**
     * @param ApiCreateProductRequest $apiCreateProductRequest
     * @return Product|null
     */
    public static function createProduct(ApiCreateProductRequest $apiCreateProductRequest): ?Product
    {
        DB::beginTransaction();

        try {
            $productParams = $apiCreateProductRequest->except('price');
            $product = self::create($productParams);

            ProductPrice::create([
                'product_id' => $product->id,
                'active' => true,
                'value' => $apiCreateProductRequest->get('price')
            ]);
        } catch (\Exception $exception) {
            DB::rollback();
            return null;
        }

        DB::commit();

        return $product;
    }

    /**
     * @param string $product_uuid
     * @return bool
     * @throws \Exception
     */
    public static function deleteProduct(string $product_uuid): bool
    {

        DB::beginTransaction();
        /** @var Product $product */
        $product = Product::find($product_uuid);
        if (null === $product) {
            DB::rollback();
            throw ProductException::notFound($product_uuid);
        }

        $product->delete();
        DB::commit();

        return true;
    }

}
