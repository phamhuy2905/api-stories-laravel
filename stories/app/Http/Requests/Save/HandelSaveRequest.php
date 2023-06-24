<?php

namespace App\Http\Requests\Save;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class HandelSaveRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

 
    public function rules(): array
    {
        return [
            'story_id' => [
                'bail',
                'required',
                'exists:stories,id',
            ],
            'chaper_id' => [
                'bail',
                'required',
                'exists:chapers,id',
            ],
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
}
