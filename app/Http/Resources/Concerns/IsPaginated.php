<?php

declare(strict_types=1);

namespace App\Http\Resources\Concerns;

trait IsPaginated
{
    public function addPaginationIndexes(array $collection_data): array
    {
        return array_merge($collection_data, [
            'pagination' => [
                'current_page' => $this->resource->currentPage(),
                'has_more_pages' => $this->resource->hasMorePages(),
            ],
        ]);
    }
}
