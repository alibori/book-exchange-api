<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Loan>
 */
final class LoanFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Loan::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'book_id' => \App\Models\Book::factory(),
            'lender_id' => \App\Models\User::factory(),
            'borrower_id' => fake()->randomNumber(),
            'quantity' => fake()->boolean,
            'status' => fake()->boolean,
            'from' => fake()->date(),
            'to' => fake()->date(),
        ];
    }
}
