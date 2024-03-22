<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\LoanStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Loan
 *
 * @property int $id
 * @property int $book_id
 * @property int $lender_id
 * @property int $borrower_id
 * @property int $quantity
 * @property LoanStatusEnum $status
 * @property Carbon $from
 * @property Carbon $to
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Book $book
 * @property User $user
 *
 * @package App\Models
 */
class Loan extends Model
{
	use HasFactory;
	protected $table = 'loans';

	protected $casts = [
		'book_id' => 'int',
		'lender_id' => 'int',
		'borrower_id' => 'int',
		'quantity' => 'int',
		'status' => LoanStatusEnum::class,
		'from' => 'datetime',
		'to' => 'datetime'
	];

	protected $fillable = [
		'book_id',
		'lender_id',
		'borrower_id',
		'quantity',
		'status',
		'from',
		'to'
	];

	public function book(): BelongsTo
    {
		return $this->belongsTo(Book::class);
	}

	public function lender(): BelongsTo
    {
		return $this->belongsTo(User::class, 'lender_id');
	}

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }
}
