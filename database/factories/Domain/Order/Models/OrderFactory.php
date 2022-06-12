<?php

namespace Database\Factories\Domain\Order\Models;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderItem;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
