<?php

namespace App\Http\Requests;
use App\Http\Requests\BaseApiRequest;


class CreateQuantityCommandeRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'b_c_externe_id' => 'required|exists:b_c_externes,id', 
            'products' => 'array|required',
            'products.*' => 'array|required',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ];
    }
}
