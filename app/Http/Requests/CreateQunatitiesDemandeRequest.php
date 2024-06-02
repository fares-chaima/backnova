<?php

namespace App\Http\Requests;
use App\Http\Requests\BaseApiRequest;


class CreateQunatitiesDemandeRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      
            return [
                'b_c_interne_id' => 'required|exists:b_c_internes,id', 
                'products' => 'array|required',
                'products.*' => 'array|required',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1'
            ];
      
    }
}
