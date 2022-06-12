<?php

namespace Database\Seeders;

use Domain\Product\Contracts\Services\ProductServiceInterface;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $productService = resolve(ProductServiceInterface::class);

        $products = [
            [
                'name' => 'Ürün 1',
                'price' => 400.00,
                'stock' => 100,
                'category_id' => 1,
            ],
            [
                'name' => 'Ürün 2',
                'price' => 500.00,
                'stock' => 100,
                'category_id' => 1,
            ],
            [
                'name' => 'Ürün 3',
                'price' => 500.00,
                'stock' => 100,
                'category_id' => 2,
            ],
            [
                'name' => 'Ürün 4',
                'price' => 500.00,
                'stock' => 100,
                'category_id' => 2,
            ],
        ];

        foreach ($products as $product) {
            $productService->updateOrCreate(['name' => $product['name']], $product);
        }
    }
}
