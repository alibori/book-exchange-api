<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rating>
 */
final class RatingFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Rating::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'rateable_type' => fake()->word,
            'rateable_id' => fake()->randomNumber(),
            'user_id' => User::factory(),
            'rating' => fake()->boolean,
            'comment' => fake()->optional()->text,
        ];
    }
}
