<?php

declare(strict_types=1);

namespace Database\Seeders\Mock;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

final class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->count(count: 10)->create();
    }
}
