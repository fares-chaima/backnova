<?php 
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BaseApiRequest extends FormRequest{
    /**
     * force the form request to throw json errors 
     * instead of flushing them to the session
     * @return boolean 
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response($validator->errors(), 422)); // 422 stands for unproccesable entity
    }
}