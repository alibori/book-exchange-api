<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Category|null $category
 * @property Collection|Book[] $books
 * @property Collection|Category[] $categories
 *
 * @package App\Models
 */
class Category extends Model
{
	use HasFactory;
	protected $table = 'categories';

	protected $casts = [
		'parent_id' => 'int'
	];

	protected $fillable = [
		'parent_id',
		'name'
	];

	public function category(): BelongsTo
    {
		return $this->belongsTo(Category::class, 'parent_id');
	}

	public function books(): HasMany
    {
		return $this->hasMany(Book::class);
	}

	public function categories(): HasMany
    {
		return $this->hasMany(Category::class, 'parent_id');
	}

    public function book_applications(): HasMany
    {
        return $this->hasMany(BookApplication::class);
    }
}
