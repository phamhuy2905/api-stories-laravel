<?php

namespace App\Http\Requests\Chaper;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChaperRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

 
    public function rules(): array
    {
        $id = $this->id;
        return [
            'name' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('chapers')->where(function ($query) use ($id) {
                    return $query->where('story_id', $this->story_id)
                        ->where('id', '<>', $id);
                })
            ],
            'thumbnail'=> [
                'bail',
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
