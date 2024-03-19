<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Author;
use App\Models\BookApplication;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookApplication>
 */
final class BookApplicationFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = BookApplication::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'author_id' => Author::factory(),
            'category_id' => Category::factory(),
            'author_name' => fake()->optional()->word,
            'title' => fake()->title,
            'description' => fake()->text,
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
