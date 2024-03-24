<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Concerns\IsPaginated;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class LoanResourceCollection extends ResourceCollection
{
    use IsPaginated;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ( ! $this->resource instanceof Paginator) {
            return parent::toArray($request);
        }

        return $this->addPaginationIndexes(collection_data: [
            'data' => LoanResource::collection($this->collection),
        ]);
    }
}
