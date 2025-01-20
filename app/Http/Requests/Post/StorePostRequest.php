<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:150',
            'news' => 'required',
            'news_type' => 'required|string|max:50',
            'category' => 'required|string|max:50',
            'tags' => 'required|string|max:50',
            'post_url' => 'required|string|max:255',
        ];
    }
}
