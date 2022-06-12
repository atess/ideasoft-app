<?php

namespace Database\Factories\Domain\Product\Models;

use Domain\Product\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(100),
        ];
    }
}
