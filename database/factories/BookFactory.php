<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
final class BookFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Book::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first(),
            'author_id' => Author::inRandomOrder()->first(),
            'title' => fake()->unique()->sentence(),
            'description' => fake()->text,
        ];
    }

    public function configure(): BookFactory
    {
        return $this->afterMaking(function (Book $book) {
            $loop = rand(1, 5);

            BookUserFactory::new()->for(factory: $book)->count(count: $loop)->make();
        })->afterCreating(function (Book $book) {
            $loop = rand(1, 5);

            BookUserFactory::new()->for(factory: $book)->count(count: $loop)->create();
        });
    }
}
