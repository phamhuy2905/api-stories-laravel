<?php

namespace App\Http\Requests\Story;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStoryRequest extends FormRequest
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
            'name' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('stories')->ignore($this->request->get('id')),
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
