<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\Mock\AdminTableSeeder;
use Database\Seeders\Mock\AuthorTableSeeder;
use Database\Seeders\Mock\BookTableSeeder;
use Database\Seeders\Mock\CategoryTableSeeder;
use Database\Seeders\Mock\UserTableSeeder;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(class: AdminTableSeeder::class);
        $this->call(class: UserTableSeeder::class);
        $this->call(class: AuthorTableSeeder::class);
        $this->call(class: CategoryTableSeeder::class);
        $this->call(class: BookTableSeeder::class);
    }
}
