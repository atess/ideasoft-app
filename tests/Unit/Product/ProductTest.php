<?php

namespace Tests\Unit\Product;

use Domain\Product\Models\Product;
use Illuminate\Support\Str;
use Tests\TestCase;


class ProductTest extends TestCase
{
    private array $structure = [
        'id',
        'name',
        'category_id',
        'stock',
        'price',
    ];

    public function test_product_index()
    {
        Product::factory()->count(10)->create();

        $this->login()
            ->getJson(route('products.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ],
                'links',
                'meta',
            ]);
    }

    public function test_product_show()
    {
        $product = Product::factory()->create();

        $this->login()
            ->getJson(
                route('products.show', [
                    'product' => $product,
                ])
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(
                    $this->structure,
                )
            ]);
    }

    public function test_product_search_name()
    {
        Product::factory()->count(10)->create();

        $this->login()
            ->getJson(
                route('products.index', [
                    'filter' => [
                        'search' => Str::random(),
                    ]
                ])
            )
            ->assertStatus(200)
            ->assertJsonPath('meta.total', 0)
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ],
                'links',
                'meta',
            ]);
    }

    public function test_product_store()
    {
        $product = Product::factory()->raw();

        $this->login()
            ->postJson(route('products.store'), $product)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);

        $this->assertDatabaseHas(Product::class, $product);
    }

    public function test_product_update()
    {
        $product = Product::factory()->create();
        $newProduct = Product::factory()->raw();

        $this->login()
            ->putJson(
                route('products.update', [
                    'product' => $product
                ]), $newProduct
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);

        $this->assertDatabaseHas(Product::class, $newProduct);
    }

    public function test_product_destroy()
    {
        $product = Product::factory()->create();
        $this->assertDatabaseHas(Product::class, $product->toArray());

        $this
            ->login()
            ->deleteJson(
                route('products.destroy', [
                    'product' => $product
                ])
            )->assertStatus(204);

        $this->assertDatabaseMissing(Product::class, array_merge(
            $product->toArray(),
            ['deleted_at' => null]
        ));
    }
}
