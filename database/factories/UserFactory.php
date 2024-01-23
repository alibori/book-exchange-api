<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\User>
 */
final class UserFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = User::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'surname' => fake()->word,
            'email' => fake()->unique()->safeEmail,
            'email_verified_at' => fake()->optional()->dateTime(),
            'phone' => fake()->optional()->phoneNumber,
            'address' => fake()->optional()->address,
            'city' => fake()->city,
            'country' => fake()->country,
            'postal_code' => fake()->postcode,
            'avatar' => fake()->optional()->word,
            'password' => bcrypt(fake()->password),
            'remember_token' => Str::random(10),
        ];
    }
}
