<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
          'name'=>['required'],
           'email'=>['required','unique:users,email'],
           'password'=> ['required','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/']
        ];
    }

    /**
     * @return string[]
     */
    public function messages():array
    {
        return [
            'required'=>':attributes must be provided',
            'unique'=>':attributes already exists',
            'password.regex'=>'Password should contain at least one Uppercase, one Lowercase, one Numeric and one special character',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'name'=>'Name',
            'email'=>'Email',
            'password'=>'Password'

        ];
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = collect($validator->errors());

        $response = response()->json([
            'success' => false,
            'message' => 'Something unexpected happened',
            'errors' => $errors
        ],400);

        throw (new ValidationException($validator,$response));

    }
}
