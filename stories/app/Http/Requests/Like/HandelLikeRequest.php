<?php

namespace App\Http\Requests\Like;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class HandelLikeRequest extends FormRequest
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
            // 'user_id' => [
            //     'bail',
            //     'required',
            //     'exists:users,id'
            // ],
            'type' => [
                'bail',
                Rule::in(['Like', 'Love', 'Haha','Wow','Sad','Angry']),
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
