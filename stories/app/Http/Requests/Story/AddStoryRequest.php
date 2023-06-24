<?php

namespace App\Http\Requests\Story;

use Illuminate\Foundation\Http\FormRequest;

class AddStoryRequest extends FormRequest
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
                'string',
                'min:3',
                'max:50',
                'unique:App\Models\Story,name',
            ],
            'name_author'=> [
                'bail',
                'required',
                'string',
                'min:3',
                'max:50',
            ],
            'thumbnail'=> [
                'bail',
                'required',
                'image',
            ],
            'trailer'=> 'required|mimetypes:video/mp4,video/x-msvideo,video/mpeg',
            'description_short'=> [
                'bail',
                'required',
                'string',
                'min:20',
                'max:255',
            ],
            'description_long'=> [
                'bail',
                'string',
                'required',
                'min:100',
            ],
            'publisher_id' => [
                'bail',
                'required',
                'exists:publishers,id'
            ],
            'category_id' => [
                'bail',
                'required',
                'exists:categories,id'
            ],
        ];
    }
}
