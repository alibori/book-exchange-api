<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BookUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\BookUser>
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
            'book_id' => \App\Models\Book::factory(),
            'user_id' => \App\Models\User::factory(),
            'quantity' => fake()->boolean,
            'status' => fake()->boolean,
        ];
    }
}
