<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\BookUserStatusEnum;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookUser>
 */
final class BookUserFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = BookUser::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->first(),
            'user_id' => User::inRandomOrder()->first(),
            'quantity' => 1,
            'status' => $this->faker->randomElement([BookUserStatusEnum::Available, BookUserStatusEnum::Borrowed])
        ];
    }
}
