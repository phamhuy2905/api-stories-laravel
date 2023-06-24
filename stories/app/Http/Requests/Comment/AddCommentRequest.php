<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddCommentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'story_id' => [
                'bail',
                'required',
                'exists:stories,id',
            ],
            'comment' => [
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
