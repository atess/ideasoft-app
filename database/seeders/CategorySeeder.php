<?php

namespace Database\Seeders;

use Domain\Product\Contracts\Services\CategoryServiceInterface;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $categoryService = resolve(CategoryServiceInterface::class);

        $categories = [
            [
                'name' => 'Kategori 1',
            ],
            [
                'name' => 'Kategori 2',
            ],
        ];

        foreach ($categories as $category) {
            $categoryService->updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
