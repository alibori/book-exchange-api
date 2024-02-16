<?php

declare(strict_types=1);

namespace Database\Seeders\Mock;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryFactory::new()->create(attributes: ['name' => 'Fiction']);
        CategoryFactory::new()->create(attributes: ['name' => 'Non-Fiction']);
        CategoryFactory::new()->create(attributes: ['name' => 'Science']);
        CategoryFactory::new()->create(attributes: ['name' => 'Technology']);
        CategoryFactory::new()->create(attributes: ['name' => 'Biography']);
    }
}
