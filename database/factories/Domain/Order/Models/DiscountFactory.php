<?php

namespace Database\Factories\Domain\Order\Models;

use Domain\Order\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    protected $model = Discount::class;

    public function definition(): array
    {
        return [
            'reason' => $this->faker->slug(1),
            'rules' => [
                'conditions' => [
                    'min_price' => 1000,
                ],
                'discount_rate' => 10,
            ],
        ];
    }
}
