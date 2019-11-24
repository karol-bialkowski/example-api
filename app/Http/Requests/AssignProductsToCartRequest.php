<?php

namespace App\Http\Requests;

use App\Cart;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignProductsToCartRequest extends FormRequest
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
            'cart_id' => 'required|exists:carts,id',
            'products.*' => 'required|exists:products,id'
        ];
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return Cart::find($this->get('cart_id'));
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator): void
    {
        $jsonResponse = response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 400);

        throw new HttpResponseException($jsonResponse);
    }

}
