<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Loan;

use App\Enums\LoanStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateLoanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::enum(LoanStatusEnum::class)
            ],
        ];
    }
}
