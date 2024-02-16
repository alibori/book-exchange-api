<?php

declare(strict_types=1);

namespace Database\Seeders\Mock;

use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;

final class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookFactory::new()->count(count: 25)->create();
    }
}
