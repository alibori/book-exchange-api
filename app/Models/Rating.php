<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Rating
 *
 * @property int $id
 * @property string $rateable_type
 * @property int $rateable_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class Rating extends Model
{
	use HasFactory;
	protected $table = 'ratings';

	protected $casts = [
		'rateable_id' => 'int',
		'user_id' => 'int',
		'rating' => 'int'
	];

	protected $fillable = [
		'rateable_type',
		'rateable_id',
		'user_id',
		'rating',
		'comment'
	];

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class);
	}
}
