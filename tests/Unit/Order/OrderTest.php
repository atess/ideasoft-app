<?php

namespace Tests\Unit\Order;

use Domain\Order\Models\Order;
use Domain\Product\Models\Product;
use Illuminate\Support\Arr;
use Tests\TestCase;


class OrderTest extends TestCase
{
    private array $structure = [
        'id',
        'user_id',
        'total',
    ];

    public function test_order_index()
    {
        Order::factory()->count(10)->create();

        $this->login()
            ->getJson(route('orders.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ],
                'links',
                'meta',
            ]);
    }

    public function test_order_show()
    {
        $order = Order::factory()->create();

        $this->login()
            ->getJson(
                route('orders.show', [
                    'order' => $order,
                ])
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->structure
            ]);
    }

    public function test_order_product_out_of_stock()
    {
        $product = Product::factory()->state([
            'stock' => 0,
        ])->create();

        $postData = [
            [
                'quantity' => 1,
                'product_id' => $product->id,
            ]
        ];

        $this->login()
            ->postJson(route('orders.store'), [
                'products' => $postData,
            ])
            ->assertStatus(400);
    }

    public function test_order_store()
    {
        $products = Product::factory()->state([
            'stock' => 10
        ])->count(10)->create();

        $postData = Arr::map($products->toArray(), function ($product) {
            return [
                'quantity' => 4,
                'product_id' => $product['id'],
            ];
        });

        $this->login()
            ->postJson(route('orders.store'), [
                'products' => $postData,
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [...$this->structure, ...['items']],
            ]);
    }

    public function test_order_destroy()
    {
        $order = Order::factory()->create();
        $this->assertDatabaseHas(Order::class, $order->toArray());

        $this
            ->login()
            ->deleteJson(
                route('orders.destroy', [
                    'order' => $order
                ])
            )->assertStatus(204);

        $this->assertDatabaseMissing(Order::class, array_merge(
            $order->toArray(),
            ['deleted_at' => null]
        ));
    }
}
