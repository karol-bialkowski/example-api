<?php

namespace App\Http\Requests;

use App\Cart;
use App\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteProductFromCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cart_uuid' => 'required|exists:carts,id',
            'product_uuid' => 'required|exists:cart_products,product_id'
        ];
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return Cart::find($this->get('cart_uuid'));
    }

    public function getProduct(): Product
    {
        return Product::find($this->get('product_uuid'));
    }

    protected function failedValidation(Validator $validator): void
    {
        $jsonResponse = response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 400);

        throw new HttpResponseException($jsonResponse);
    }
}
