<?php

declare(strict_types=1);

namespace Database\Seeders\Mock;

use Database\Factories\AdminFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminFactory::new()->create(attributes: [
            'name' => 'John Doe',
            'email' => 'john.doe@book-exchange.com',
            'password' => Hash::make(value: '12345678'),
        ]);
    }
}
