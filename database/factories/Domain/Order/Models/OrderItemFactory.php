<?php

namespace Database\Factories\Domain\Order\Models;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderItem;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'order_id' => Order::factory(),
            'quantity' => rand(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 100),
            'total' => $this->faker->randomFloat(2, 500, 4000)
        ];
    }
}
