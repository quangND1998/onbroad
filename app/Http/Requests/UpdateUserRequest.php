<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => [
                'required','email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'store_name' =>  [
                'required',
                Rule::unique('users', 'store_name')->ignore($this->user),
            ],

           
            'phone' =>  [
                'required',
                Rule::unique('users', 'phone')->ignore($this->user)
            ],
            'phone' =>'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            // 'password' =>  'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'password' =>  'required|min:6',
        ];
    }

    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
