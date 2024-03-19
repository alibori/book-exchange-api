<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Author
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Book[] $books
 *
 * @package App\Models
 */
class Author extends Model
{
	use HasFactory;
	protected $table = 'authors';

	protected $fillable = [
		'name'
	];

	public function books(): HasMany
    {
		return $this->hasMany(Book::class);
	}

    public function book_applications(): HasMany
    {
        return $this->hasMany(BookApplication::class);
    }
}
