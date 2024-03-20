<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use App\Enums\BookApplicationStatusEnum;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property Author $author
 * @property string $author_name
 * @property Category $category
 * @property string $title
 * @property string $description
 * @property BookApplicationStatusEnum $status
 */
final class BookApplicationResource extends JsonResource
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
            'author' => $this->whenLoaded('author', $this->author?->name),
            'author_name' => $this->author_name,
            'category' => $this->whenLoaded('category', $this->category?->name),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
        ];
    }
}
