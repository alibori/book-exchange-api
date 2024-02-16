<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Loan>
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
            'book_id' => Book::factory(),
            'lender_id' => User::factory(),
            'borrower_id' => fake()->randomNumber(),
            'quantity' => fake()->boolean,
            'status' => fake()->boolean,
            'from' => fake()->date(),
            'to' => fake()->date(),
        ];
    }
}
