<?php

declare(strict_types=1);

namespace Database\Seeders\Mock;

use Database\Factories\AuthorFactory;
use Illuminate\Database\Seeder;

final class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AuthorFactory::new()->create(attributes: ['name' => 'J.K. Rowling']);
        AuthorFactory::new()->create(attributes: ['name' => 'Stephen King']);
        AuthorFactory::new()->create(attributes: ['name' => 'Dan Brown']);
        AuthorFactory::new()->create(attributes: ['name' => 'J.R.R. Tolkien']);
        AuthorFactory::new()->create(attributes: ['name' => 'George R.R. Martin']);
    }
}
