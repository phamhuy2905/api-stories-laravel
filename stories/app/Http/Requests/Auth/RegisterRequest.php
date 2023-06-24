<?php

namespace App\Http\Requests\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                'min:3',
                'max:50',
                'string',
            ],
            'email' => [
                'bail',
                'required',
                'email',
                'unique:App\Models\User,email',
            ],
            'password' => [
                'bail',
                'required',
                'min:3',
                'string',
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $formattedErrors = [];

        foreach ($errors as  $error) {
            $formattedErrors[] = implode(' ', $error);
        }

        throw new HttpResponseException(response()->json([
            'message' => 'Error valiation',
            'errors' => ['data' => $formattedErrors]
        ],422));
    }
    public function messages()
    {
        return [
            'required' => 'Please provider your :attribute',
            'unique' => 'Field :attribute is already registered',
            'min' => 'Field :attribute should greater or equal 3 character',
            'max' => 'Field :attribute should less or equal 50 character',
            'string' => 'Field :attribute required type string',
            'email' => 'Your email is invalid   !'
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
        ];
    }
}
