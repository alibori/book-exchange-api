<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use App\Enums\LoanStatusEnum;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property User $lender
 * @property User $borrower
 * @property Book $book
 * @property int $quantity
 * @property string $from
 * @property string $to
 * @property LoanStatusEnum $status
 */
final class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lender' => $this->whenLoaded('lender', fn () => new UserResource($this->lender)),
            'borrower' => $this->whenLoaded('borrower', fn () => new UserResource($this->borrower)),
            'book' => $this->whenLoaded('book', fn () => new BookResource($this->book)),
            'quantity' => $this->quantity,
            'from' => $this->from,
            'to' => $this->to,
            'status' => $this->status->value,
        ];
    }
}
