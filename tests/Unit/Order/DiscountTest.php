<?php

namespace Tests\Unit\Order;

use Domain\Order\Models\Discount;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;


class DiscountTest extends TestCase
{
    private array $structure = [
        'id',
        'reason',
        'rules',
    ];

    public function test_discount_index()
    {
        Discount::factory()->count(10)->create();

        $this->login()
            ->getJson(route('discounts.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ],
                'links',
                'meta',
            ]);
    }

    public function test_discount_show()
    {
        $discount = Discount::factory()->create();

        $this->login()
            ->getJson(
                route('discounts.show', [
                    'discount' => $discount,
                ])
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->structure
            ]);
    }

    public function test_discount_store()
    {
        $discount = Discount::factory()->raw();

        $this->login()
            ->postJson(route('discounts.store'), $discount)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);
    }

    public function test_discount_destroy()
    {
        $discount = Discount::factory()->create();
        $this->assertDatabaseHas(Discount::class, ['reason' => $discount->reason]);

        $this->login()
            ->deleteJson(
                route('discounts.destroy', [
                    'discount' => $discount
                ])
            )->assertStatus(204);

        $this->assertDatabaseMissing(Discount::class, ['reason' => $discount->reason]);
    }

    public function test_discount_update()
    {
        $reason = Str::random();
        $reason2 = Str::random() . 'aA';

        $discount = Discount::factory()->create([
            'reason' => $reason,
        ]);
        $newDiscount = Discount::factory()->raw([
            'reason' => $reason2,
        ]);

        $this->login()
            ->putJson(
                route('discounts.update', [
                    'discount' => $discount
                ]), $newDiscount
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);

        $this->assertDatabaseHas(Discount::class, Arr::only($newDiscount, [
            'reason',
        ]));
    }
}
