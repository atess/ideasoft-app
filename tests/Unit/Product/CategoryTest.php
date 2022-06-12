<?php

namespace Tests\Unit\Product;

use Domain\Product\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;


class CategoryTest extends TestCase
{
    private array $structure = [
        'id',
        'name',
    ];

    public function test_category_index()
    {
        Category::factory()->count(10)->create();

        $this->login()
            ->getJson(route('categories.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ],
                'links',
                'meta',
            ]);
    }

    public function test_category_index_with_created_by_and_updated_by()
    {
        Category::factory()->count(10)->create();

        $this->login()
            ->getJson(
                route('categories.index', [
                    'include' => 'createdBy,updatedBy'
                ])
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => array_merge(
                        $this->structure,
                        ['created_by', 'updated_by']
                    )
                ],
                'links',
                'meta',
            ]);
    }

    public function test_category_show_with_created_by_and_updated_by()
    {
        $category = Category::factory()->create();

        $this->login()
            ->getJson(
                route('categories.show', [
                    'category' => $category,
                    'include' => 'createdBy,updatedBy'
                ])
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(
                    $this->structure,
                    ['created_by', 'updated_by']
                )
            ]);
    }

    public function test_category_show()
    {
        $category = Category::factory()->create();

        $this->login()
            ->getJson(
                route('categories.show', [
                    'category' => $category,
                ])
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(
                    $this->structure,
                )
            ]);
    }

    public function test_category_search_name()
    {
        Category::factory()->count(10)->create();

        $this->login()
            ->getJson(
                route('categories.index', [
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

    public function test_category_store()
    {
        $category = Category::factory()->raw();

        $this->login()
            ->postJson(route('categories.store'), $category)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);

        $this->assertDatabaseHas(Category::class, $category);
    }

    public function test_category_update()
    {
        $category = Category::factory()->create();
        $newCategory = Category::factory()->raw();

        $this->login()
            ->putJson(
                route('categories.update', [
                    'category' => $category
                ]), $newCategory
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);

        $this->assertDatabaseHas(Category::class, $newCategory);
    }

    public function test_category_destroy()
    {
        $category = Category::factory()->create();
        $this->assertDatabaseHas(Category::class, $category->toArray());

        $this
            ->login()
            ->deleteJson(
                route('categories.destroy', [
                    'category' => $category
                ])
            )->assertStatus(204);

        $this->assertDatabaseMissing(Category::class, array_merge(
            $category->toArray(),
            ['deleted_at' => null]
        ));
    }
}
