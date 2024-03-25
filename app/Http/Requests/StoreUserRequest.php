<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'store_name' => 'required|unique:users,store_name',
            'phone' =>'required|unique:users,phone|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            
            // 'password' =>  'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'password' =>  'required|min:6',
          
        ];
    }

    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
