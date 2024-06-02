<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname'=>'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'numero' => 'required|digits:10|unique:users,numero',
            'photo_url' => 'nullable',
            'is_active' => 'nullable|boolean',
            'password' => 'required',

           
            'roles_ids' => 'required',
            'roles_ids.*' => 'required|exists:roles,id', // one role at least must be attached, role must be real record

            // 'r
        ];
    }
}
