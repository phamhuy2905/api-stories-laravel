<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCommentRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment' => [
                'bail',
                'required',
            ],
            'id' => [
                'bail',
                'required',
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
