<?php

namespace Tests\Unit\User;

use Domain\User\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    private array $structure = [
        'id',
        'name',
        'email',
        'since',
        'revenue',
    ];

    public function test_user_index()
    {
        User::factory()->count(10)->create();

        $this->login()
            ->getJson(route('users.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ],
                'links',
                'meta',
            ]);
    }

    public function test_user_index_with_created_by_and_updated_by()
    {
        User::factory()->count(10)->create();

        $this->login()
            ->getJson(
                route('users.index', [
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

    public function test_user_show_with_created_by_and_updated_by()
    {
        $user = User::factory()->create();

        $this->login()
            ->getJson(
                route('users.show', [
                    'user' => $user,
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

    public function test_user_show()
    {
        $user = User::factory()->create();

        $this->login()
            ->getJson(
                route('users.show', [
                    'user' => $user,
                ])
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(
                    $this->structure,
                )
            ]);
    }

    public function test_user_search_name()
    {
        User::factory()->count(10)->create();

        $this->login()
            ->getJson(
                route('users.index', [
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

    public function test_user_store()
    {
        $pass = Str::random() . '}aA';
        $user = User::factory()->raw([
            'password' => $pass,
            'password_confirmation' => $pass,
        ]);

        $this->login()
            ->postJson(route('users.store'), $user)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);

        $this->assertDatabaseHas(User::class, Arr::only($user, [
            'name',
            'email',
        ]));
    }

    public function test_user_update()
    {
        $pass = Str::random();
        $pass2 = Str::random() . '}aA';

        $user = User::factory()->create([
            'password' => $pass,
        ]);
        $newUser = User::factory()->raw([
            'password' => $pass2,
            'password_confirmation' => $pass2,
        ]);

        $this->login()
            ->putJson(
                route('users.update', [
                    'user' => $user
                ]), $newUser
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);

        $this->assertDatabaseHas(User::class, Arr::only($newUser, [
            'name',
            'email',
        ]));
    }

    public function test_user_destroy()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas(User::class, $user->toArray());

        $this
            ->login()
            ->deleteJson(
                route('users.destroy', [
                    'user' => $user
                ])
            )->assertStatus(204);

        $this->assertDatabaseMissing(User::class, array_merge(
            $user->toArray(),
            ['deleted_at' => null]
        ));
    }
}
