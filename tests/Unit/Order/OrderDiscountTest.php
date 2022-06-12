<?php

namespace Tests\Unit\Order;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderItem;
use Domain\Product\Models\Product;
use Tests\TestCase;

class OrderDiscountTest extends TestCase
{
    private array $structure = [
        'order_id',
        'discounts',
        'total_discount',
        'discounted_total',
    ];

    public function test_order_discount_live()
    {
        $order = Order::factory()
            ->has(
                OrderItem::factory()
                    ->has(
                        Product::factory()
                    )
                    ->count(10),
                'items'
            )
            ->create();

        $this->login()
            ->getJson(
                route('orders.discounts', [
                    'order_id' => $order->id,
                ])
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);
    }
}
