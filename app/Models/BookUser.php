<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BookUser
 *
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 * @property int $quantity
 * @property int $status
 *
 * @property Book $book
 * @property User $user
 *
 * @package App\Models
 */
class BookUser extends Model
{
	use HasFactory;
	protected $table = 'book_user';
	public $timestamps = false;

	protected $casts = [
		'book_id' => 'int',
		'user_id' => 'int',
		'quantity' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'book_id',
		'user_id',
		'quantity',
		'status'
	];

	public function book(): BelongsTo
    {
		return $this->belongsTo(Book::class);
	}

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class);
	}
}
