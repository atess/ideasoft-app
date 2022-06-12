<?php

namespace Database\Factories\Domain\Product\Models;

use Domain\Product\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(100),
            'category_id' => Category::factory(),
            'stock' => rand(1, 100),
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
