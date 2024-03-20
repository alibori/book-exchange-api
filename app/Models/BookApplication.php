<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\BookApplicationStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BookApplication
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $author_id
 * @property int|null $category_id
 * @property string|null $author_name
 * @property string $title
 * @property string $description
 * @property BookApplicationStatusEnum $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Author|null $author
 * @property User $user
 *
 * @package App\Models
 */
class BookApplication extends Model
{
	use HasFactory;
	protected $table = 'book_applications';

	protected $casts = [
		'user_id' => 'int',
		'author_id' => 'int',
        'category_id' => 'int',
        'status' => BookApplicationStatusEnum::class
	];

    protected $fillable = [
        'user_id',
        'author_id',
        'category_id',
        'author_name',
        'title',
        'description',
        'status'
    ];

	public function author(): BelongsTo
    {
		return $this->belongsTo(Author::class);
	}

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class);
	}

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
