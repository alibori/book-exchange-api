<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class BookApplicationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'author_id' => 'nullable|integer|exists:authors,id',
            'author_name' => 'required_without:author_id|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'title' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
