<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Loan;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class RequestLoanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'lender_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
        ];
    }
}
