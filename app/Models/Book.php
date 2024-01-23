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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Book
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $author_id
 * @property string $title
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Author|null $author
 * @property Category|null $category
 * @property Collection|User[] $users
 * @property Collection|Loan[] $loans
 *
 * @package App\Models
 */
class Book extends Model
{
	use HasFactory;
	protected $table = 'books';

	protected $casts = [
		'category_id' => 'int',
		'author_id' => 'int'
	];

	protected $fillable = [
		'category_id',
		'author_id',
		'title',
		'description'
	];

	public function author(): BelongsTo
    {
		return $this->belongsTo(Author::class);
	}

	public function category(): BelongsTo
    {
		return $this->belongsTo(Category::class);
	}

	public function users(): BelongsToMany
    {
		return $this->belongsToMany(User::class)
					->withPivot('id', 'quantity', 'status');
	}

	public function loans(): HasMany
    {
		return $this->hasMany(Loan::class);
	}
}
