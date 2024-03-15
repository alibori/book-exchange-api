<?php

namespace App\Http\Requests\Api\V1\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ListBooksRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'results' => 'integer|min:1|max:100',
            'page' => 'integer|min:1',
            'title' => 'string|max:255',
            'author' => 'string|max:255',
        ];
    }
}
