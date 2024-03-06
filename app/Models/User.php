<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $phone
 * @property string|null $address
 * @property string $city
 * @property string $country
 * @property string $postal_code
 * @property string|null $avatar
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Collection|Book[] $books
 * @property Collection|Loan[] $loans
 * @property Collection|Rating[] $ratings
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens;
	use HasFactory;
    use SoftDeletes;
	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
	];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'name',
        'surname',
        'email',
        'email_verified_at',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'avatar',
        'password',
        'remember_token',
    ];

	public function books(): BelongsToMany
    {
		return $this->belongsToMany(Book::class)
					->withPivot('id', 'quantity', 'status');
	}

	public function loans(): HasMany
    {
		return $this->hasMany(Loan::class, 'lender_id');
	}

	public function ratings(): MorphMany
    {
		return $this->morphMany(Rating::class, 'rateable');
	}

    public function rateds(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
