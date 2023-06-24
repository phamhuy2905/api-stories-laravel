<?php

namespace App\Http\Requests\Chaper;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddChaperRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
                'string',
                'min:3',
                'max:50',
                Rule::unique('chapers')->where(function ($query) {
                    return $query->where('story_id', $this->story_id);
                })
            ],
            'thumbnail'=> [
                'bail',
                'required',
                'image',
            ],
            'description'=> [
                'bail',
                'string',
                'min:100',
            ],
            'story_id' => [
                'bail',
                'required',
                'exists:stories,id'
            ],
        ];
    }
}
